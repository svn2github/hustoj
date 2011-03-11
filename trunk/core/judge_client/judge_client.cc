//
// File:   main.cc
// Author: sempr
//
/*
 * Copyright 2008 sempr <iamsempr@gmail.com>
 *
 * This file is part of HUSTOJ.
 *
 * HUSTOJ is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * HUSTOJ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HUSTOJ. if not, see <http://www.gnu.org/licenses/>.
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <dirent.h>
#include <unistd.h>
#include <time.h>
#include <stdarg.h>
#include <ctype.h>
#include <sys/wait.h>
#include <sys/ptrace.h>
#include <sys/types.h>
#include <sys/user.h>
#include <sys/syscall.h>
#include <sys/time.h>
#include <sys/resource.h>
#include <sys/signal.h>
//#include <sys/types.h>
#include <sys/stat.h>
#include <unistd.h>
#include <mysql/mysql.h>

#include "okcalls.h"

#define STD_MB 1048576
#define STD_T_LIM 2
#define STD_F_LIM (STD_MB<<5)
#define STD_M_LIM (STD_MB<<7)
#define BUFFER_SIZE 512

#define OJ_WT0 0
#define OJ_WT1 1
#define OJ_CI 2
#define OJ_RI 3
#define OJ_AC 4
#define OJ_PE 5
#define OJ_WA 6
#define OJ_TL 7
#define OJ_ML 8
#define OJ_OL 9
#define OJ_RE 10
#define OJ_CE 11
#define OJ_CO 12

/*copy from ZOJ
 http://code.google.com/p/zoj/source/browse/trunk/judge_client/client/tracer.cc?spec=svn367&r=367#39
 */
#ifdef __i386
#define REG_SYSCALL orig_eax
#define REG_RET eax
#define REG_ARG0 ebx
#define REG_ARG1 ecx
#else
#define REG_SYSCALL orig_rax
#define REG_RET rax
#define REG_ARG0 rdi
#define REG_ARG1 rsi

#endif

static int DEBUG = 0;
static char host_name[BUFFER_SIZE];
static char user_name[BUFFER_SIZE];
static char password[BUFFER_SIZE];
static char db_name[BUFFER_SIZE];
static char oj_home[BUFFER_SIZE];
static int port_number;
static int max_running;
static int sleep_time;
static int java_time_bonus = 5;
static int java_memory_bonus = 512;
static char java_xmx[BUFFER_SIZE];
static int sim_enable = 0;
//static int sleep_tmp;
#define ZOJ_COM
MYSQL *conn;

static char lang_ext[7][8] = { "c", "cc", "pas", "java", "rb", "sh", "py" };
static char buf[BUFFER_SIZE];

long get_file_size(const char * filename) {
	struct stat f_stat;

	if (stat(filename, &f_stat) == -1) {
		return 0;
	}

	return (long) f_stat.st_size;
}

void write_log(const char *fmt, ...) {
	va_list ap;
	char buffer[4096];
	//	time_t          t = time(NULL);
	int l;
	FILE *fp = fopen("../log/client.log", "a+");
	if (fp == NULL) {
		fprintf(stderr, "openfile error!\n");
		system("pwd");
	}
	va_start(ap, fmt);
	l = vsprintf(buffer, fmt, ap);
	fprintf(fp, "%s\n", buffer);
	if (DEBUG)
		printf("%s\n", buffer);
	va_end(ap);
	fclose(fp);

}
int execute_cmd(const char * fmt, ...) {
	char cmd[BUFFER_SIZE];

	int ret = 0;
	va_list ap;

	va_start(ap, fmt);
	vsprintf(cmd, fmt, ap);
	ret = system(cmd);
	va_end(ap);
	return ret;
}

int call_counter[512];

void init_syscalls_limits(int lang) {
	int i;
	memset(call_counter, 0, sizeof(call_counter));
	if (DEBUG)
		write_log("init_call_counter:%d", lang);
	if (lang <= 1) { // C & C++
		for (i = 0; LANG_CC[i]; i++) {
			call_counter[LANG_CV[i]] = LANG_CC[i];
		}
	} else if (lang == 2) { // Pascal
		for (i = 0; LANG_PC[i]; i++)
			call_counter[LANG_PV[i]] = LANG_PC[i];
	} else if (lang == 3) { // Java
		for (i = 0; LANG_JC[i]; i++)
			call_counter[LANG_JV[i]] = LANG_JC[i];
	} else if (lang == 4) { // Ruby
		for (i = 0; LANG_RC[i]; i++)
			call_counter[LANG_RV[i]] = LANG_RC[i];
	} else if (lang == 5) { // Bash
		for (i = 0; LANG_BC[i]; i++)
			call_counter[LANG_BV[i]] = LANG_BC[i];
	}else if (lang == 6) { // Python
		for (i = 0; LANG_YC[i]; i++)
			call_counter[LANG_YV[i]] = LANG_YC[i];
	}

}

// read the configue file
void init_mysql_conf() {
	FILE *fp;
	char buf[BUFFER_SIZE];
	host_name[0] = 0;
	user_name[0] = 0;
	password[0] = 0;
	db_name[0] = 0;
	port_number = 3306;
	max_running = 3;
	sleep_time = 3;
	strcpy(java_xmx, "-Xmx256M");
	fp = fopen("./etc/judge.conf", "r");
	while (fgets(buf, BUFFER_SIZE - 1, fp)) {
		buf[strlen(buf) - 1] = 0;
		if (strncmp(buf, "OJ_HOST_NAME", 12) == 0) {
			strcpy(host_name, buf + 13);
		} else if (strncmp(buf, "OJ_USER_NAME", 12) == 0) {
			strcpy(user_name, buf + 13);
		} else if (strncmp(buf, "OJ_PASSWORD", 11) == 0) {
			strcpy(password, buf + 12);
		} else if (strncmp(buf, "OJ_DB_NAME", 10) == 0) {
			strcpy(db_name, buf + 11);
		} else if (strncmp(buf, "OJ_PORT_NUMBER", 14) == 0) {
			sscanf(buf + 15, "%d", &port_number);
		} else if (strncmp(buf, "OJ_JAVA_TIME_BONUS", 18) == 0) {
			sscanf(buf + 19, "%d", &java_time_bonus);
		} else if (strncmp(buf, "OJ_JAVA_MEMORY_BONUS", 20) == 0) {
			sscanf(buf + 21, "%d", &java_memory_bonus);
		} else if (strncmp(buf, "OJ_JAVA_XMX", 11) == 0) {
			strcpy(java_xmx, buf + 12);
			printf("javaxmx:%s\n", java_xmx);
		} else if (strncmp(buf, "OJ_SIM_ENABLE", 13) == 0) {
			sscanf(buf + 14, "%d", &sim_enable);
			printf("sim=%d\n", sim_enable);
		}
	}
}

int isInFile(const char fname[]) {
	int l = strlen(fname);
	if (l <= 3 || strcmp(fname + l - 3, ".in") != 0)
		return 0;
	else
		return l - 3;
}

void find_next_nonspace(int & c1, int & c2, FILE *& f1, FILE *& f2, int & ret) {
	// Find the next non-space character or \n.
	while ((isspace(c1)) || (isspace(c2))) {
		if (c1 != c2) {
			if (c2 == EOF) {
				do {
					c1 = fgetc(f1);
				} while (isspace(c1));
				continue;
			} else if (c1 == EOF) {
				do {
					c2 = fgetc(f2);
				} while (isspace(c2));
				continue;
			} else if ((c1 == '\r' && c2 == '\n')) {
				c1 = fgetc(f1);
			} else {
				if (DEBUG)
					printf("%d=%c\t%d=%c", c1, c1, c2, c2);
				;
				ret = OJ_PE;
			}
		}
		if (isspace(c1)) {
			c1 = fgetc(f1);
		}
		if (isspace(c2)) {
			c2 = fgetc(f2);
		}
	}
}

/***
 int compare_diff(const char *file1,const char *file2){
 char diff[1024];
 sprintf(diff,"diff -q -B -b -w --strip-trailing-cr %s %s",file1,file2);
 int d=system(diff);
 if (d) return OJ_WA;
 sprintf(diff,"diff -q -B --strip-trailing-cr %s %s",file1,file2);
 int p=system(diff);
 if (p) return OJ_PE;
 else return OJ_AC;

 }
 */
/*
 * translated from ZOJ judger r367
 * http://code.google.com/p/zoj/source/browse/trunk/judge_client/client/text_checker.cc#25
 *
 */
int compare_zoj(const char *file1, const char *file2) {
	int ret = OJ_AC;
	FILE * f1, *f2;
	f1 = fopen(file1, "r");
	f2 = fopen(file2, "r");
	if (!f1 || !f2) {
		ret = OJ_RE;
	} else
		for (;;) {
			// Find the first non-space character at the beginning of line.
			// Blank lines are skipped.
			int c1 = fgetc(f1);
			int c2 = fgetc(f2);
			find_next_nonspace(c1, c2, f1, f2, ret);
			// Compare the current line.
			for (;;) {
				// Read until 2 files return a space or 0 together.
				while ((!isspace(c1) && c1) || (!isspace(c2) && c2)) {
					if (c1 == EOF && c2 == EOF) {
						goto end;
					}
					if (c1 == EOF || c2 == EOF) {
						break;
					}
					if (c1 != c2) {
						// Consecutive non-space characters should be all exactly the same
						ret = OJ_WA;
						goto end;
					}
					c1 = fgetc(f1);
					c2 = fgetc(f2);
				}
				find_next_nonspace(c1, c2, f1, f2, ret);
				if (c1 == EOF && c2 == EOF) {
					goto end;
				}
				if (c1 == EOF || c2 == EOF) {
					ret = OJ_WA;
					goto end;
				}

				if ((c1 == '\n' || !c1) && (c2 == '\n' || !c2)) {
					break;
				}
			}
		}
	end: if (f1)
		fclose(f1);
	if (f2)
		fclose(f2);
	return ret;
}

void delnextline(char s[]) {
	int L;
	L = strlen(s);
	while (L > 0 && (s[L - 1] == '\n' || s[L - 1] == '\r'))
		s[--L] = 0;
}

int compare(const char *file1, const char *file2) {
#ifdef ZOJ_COM
	//compare ported and improved from zoj don't limit file size
	return compare_zoj(file1, file2);
#endif
#ifndef ZOJ_COM
	//the original compare from the first version of hustoj has file size limit
	//and waste memory
	FILE *f1,*f2;
	char *s1,*s2,*p1,*p2;
	int PEflg;
	s1=new char[STD_F_LIM+512];
	s2=new char[STD_F_LIM+512];
	if (!(f1=fopen(file1,"r")))
	return OJ_AC;
	for (p1=s1;EOF!=fscanf(f1,"%s",p1);)
	while (*p1) p1++;
	fclose(f1);
	if (!(f2=fopen(file2,"r")))
	return OJ_RE;
	for (p2=s2;EOF!=fscanf(f2,"%s",p2);)
	while (*p2) p2++;
	fclose(f2);
	if (strcmp(s1,s2)!=0) {
		//              printf("A:%s\nB:%s\n",s1,s2);
		delete[] s1;
		delete[] s2;

		return OJ_WA;
	} else {
		f1=fopen(file1,"r");
		f2=fopen(file2,"r");
		PEflg=0;
		while (PEflg==0 && fgets(s1,STD_F_LIM,f1) && fgets(s2,STD_F_LIM,f2)) {
			delnextline(s1);
			delnextline(s2);
			if (strcmp(s1,s2)==0) continue;
			else PEflg=1;
		}
		delete [] s1;
		delete [] s2;
		fclose(f1);fclose(f2);
		if (PEflg) return OJ_PE;
		else return OJ_AC;
	}
#endif
}

/* write result back to database */
void update_solution(int solution_id, int result, int time, int memory,
		int sim, int sim_s_id) {
	char sql[BUFFER_SIZE];
	sprintf(
			sql,
			"UPDATE solution SET result=%d,time=%d,memory=%d,judgetime=NOW() WHERE solution_id=%d LIMIT 1%c",
			result, time, memory, solution_id, 0);
	//	printf("sql= %s\n",sql);
	if (mysql_real_query(conn, sql, strlen(sql))) {
		//		printf("..update failed! %s\n",mysql_error(conn));
	}
	if (sim) {
		sprintf(
				sql,
				"insert into sim(s_id,sim_s_id,sim) values(%d,%d,%d) on duplicate key update  sim_s_id=%d,sim=%d",
				solution_id, sim_s_id, sim, sim_s_id, sim);
		//	printf("sql= %s\n",sql);
		if (mysql_real_query(conn, sql, strlen(sql))) {
			//		printf("..update failed! %s\n",mysql_error(conn));
		}

	}

}

/* write compile error message back to database */
void addceinfo(int solution_id) {
	char sql[(1 << 16)], *end;
	char ceinfo[(1 << 16)], *cend;
	FILE *fp = fopen("ce.txt", "r");
	snprintf(sql, (1 << 16) - 1,
			"DELETE FROM compileinfo WHERE solution_id=%d", solution_id);
	mysql_real_query(conn, sql, strlen(sql));
	cend = ceinfo;
	while (fgets(cend, 1024, fp)) {
		cend += strlen(cend);
		if (cend - ceinfo > 40000)
			break;
	}
	cend = 0;
	end = sql;
	strcpy(end, "INSERT INTO compileinfo VALUES(");
	end += strlen(sql);
	*end++ = '\'';
	end += sprintf(end, "%d", solution_id);
	*end++ = '\'';
	*end++ = ',';
	*end++ = '\'';
	end += mysql_real_escape_string(conn, end, ceinfo, strlen(ceinfo));
	*end++ = '\'';
	*end++ = ')';
	*end = 0;
	//	printf("%s\n",ceinfo);
	if (mysql_real_query(conn, sql, end - sql))
		printf("%s\n", mysql_error(conn));
	fclose(fp);
}

void update_user(char user_id[]) {
	char sql[BUFFER_SIZE];
	sprintf(
			sql,
			"UPDATE `users` SET `solved`=(SELECT count(DISTINCT `problem_id`) FROM `solution` WHERE `user_id`=\'%s\' AND `result`=\'4\') WHERE `user_id`=\'%s\'",
			user_id, user_id);
	if (mysql_real_query(conn, sql, strlen(sql)))
		write_log(mysql_error(conn));
	sprintf(
			sql,
			"UPDATE `users` SET `submit`=(SELECT count(*) FROM `solution` WHERE `user_id`=\'%s\') WHERE `user_id`=\'%s\'",
			user_id, user_id);
	if (mysql_real_query(conn, sql, strlen(sql)))
		write_log(mysql_error(conn));
}

void update_problem(int p_id) {
	char sql[BUFFER_SIZE];
	sprintf(
			sql,
			"UPDATE `problem` SET `accepted`=(SELECT count(*) FROM `solution` WHERE `problem_id`=\'%d\' AND `result`=\'4\') WHERE `problem_id`=\'%d\'",
			p_id, p_id);
	if (mysql_real_query(conn, sql, strlen(sql)))
		write_log(mysql_error(conn));
	sprintf(
			sql,
			"UPDATE `problem` SET `submit`=(SELECT count(*) FROM `solution` WHERE `problem_id`=\'%d\') WHERE `problem_id`=\'%d\'",
			p_id, p_id);
	if (mysql_real_query(conn, sql, strlen(sql)))
		write_log(mysql_error(conn));
}

int compile(int lang) {
	int pid;

	const char * CP_C[] = { "gcc", "Main.c", "-o", "Main", "-Wall", "-lm",
			"--static", "-std=c99", "-DONLINE_JUDGE", NULL };
	const char * CP_X[] = { "g++", "Main.cc", "-o", "Main", "-O2", "-Wall",
			"-lm", "--static", "-DONLINE_JUDGE", NULL };
	const char * CP_P[] = { "fpc", "Main.pas", "-oMain", "-Co", "-Cr", "-Ct",
			"-Ci", NULL };
	const char * CP_J[] = { "javac", "-J-Xms32m", "-J-Xmx256m", "Main.java",
			NULL };
	const char * CP_R[] = { "ruby", "-c", "Main.rb", NULL };
	const char * CP_B[] = { "chmod", "+rx", "Main.sh", NULL };
	const char * CP_Y[] = { "python","-c","import py_compile; py_compile.compile(r'Main.py')", NULL };
	pid = fork();
	if (pid == 0) {
		struct rlimit LIM;
		LIM.rlim_max = 60;
		LIM.rlim_cur = 60;
		setrlimit(RLIMIT_CPU, &LIM);

		LIM.rlim_max = 8 * STD_MB;
		LIM.rlim_cur = 8 * STD_MB;
		setrlimit(RLIMIT_FSIZE, &LIM);

		LIM.rlim_max = 1024 * STD_MB;
		LIM.rlim_cur = 1024 * STD_MB;
		setrlimit(RLIMIT_AS, &LIM);
		if (lang != 2) {
			freopen("ce.txt", "w", stderr);
			//freopen("/dev/null", "w", stdout);
		} else {
			freopen("ce.txt", "w", stdout);
		}
		switch (lang) {
		case 0:
			execvp(CP_C[0], (char * const *) CP_C);
			break;
		case 1:
			execvp(CP_X[0], (char * const *) CP_X);
			break;
		case 2:
			execvp(CP_P[0], (char * const *) CP_P);
			break;
		case 3:
			execvp(CP_J[0], (char * const *) CP_J);
			break;
		case 4:
			execvp(CP_R[0], (char * const *) CP_R);
			break;
		case 5:
			execvp(CP_B[0], (char * const *) CP_B);
			break;
		case 6:
			execvp(CP_Y[0], (char * const *) CP_Y);
			break;
		default:
			printf("nothing to do!\n");
		}
		if (DEBUG)
			printf("compile end!\n");
		exit(!system("cat ce.txt"));
		//exit(0);
	} else {
		int status=0;
		
		waitpid(pid, &status, 0);
		if(lang>3)
			status=get_file_size("ce.txt");
		if (DEBUG)
			printf("status=%d\n", status);
		return status;
	}

}
/*
 int read_proc_statm(int pid){
 FILE * pf;
 char fn[4096];
 int ret;
 sprintf(fn,"/proc/%d/statm",pid);
 pf=fopen(fn,"r");
 fscanf(pf,"%d",&ret);
 fclose(pf);
 return ret;
 }
 */
int get_proc_status(int pid, const char * mark) {
	FILE * pf;
	char fn[BUFFER_SIZE], buf[BUFFER_SIZE];
	int ret = 0;
	sprintf(fn, "/proc/%d/status", pid);
	pf = fopen(fn, "r");
	int m = strlen(mark);
	while (pf && fgets(buf, BUFFER_SIZE - 1, pf)) {
		//if(DEBUG&&buf[0]=='V') printf("%s",buf);
		buf[strlen(buf) - 1] = 0;
		if (strncmp(buf, mark, m) == 0) {
			sscanf(buf + m + 1, "%d", &ret);
		}
	}
	if (pf)
		fclose(pf);
	return ret;
}
int init_mysql_conn() {

	init_mysql_conf();
	conn = mysql_init(NULL);
	//mysql_real_connect(conn,host_name,user_name,password,db_name,port_number,0,0);
	const char timeout = 30;
	mysql_options(conn, MYSQL_OPT_CONNECT_TIMEOUT, &timeout);

	if (!mysql_real_connect(conn, host_name, user_name, password, db_name,
			port_number, 0, 0)) {
		write_log("%s", mysql_error(conn));
		return 0;
	}
	const char * utf8sql = "set names utf8";
	if (mysql_real_query(conn, utf8sql, strlen(utf8sql))) {
		write_log("%s", mysql_error(conn));
		return 0;
	}
	return 1;
}
void get_solution(int solution_id, char * work_dir, int & lang) {
	char sql[BUFFER_SIZE], cmd[BUFFER_SIZE], src_pth[BUFFER_SIZE];
	// get the source code
	MYSQL_RES *res;
	MYSQL_ROW row;

	sprintf(sql, "SELECT source FROM source_code WHERE solution_id=%d",
			solution_id);
	mysql_real_query(conn, sql, strlen(sql));
	res = mysql_store_result(conn);
	row = mysql_fetch_row(res);
	// clear the work dir
	sprintf(cmd, "rm -rf %s*", work_dir);
	if (!DEBUG)
		system(cmd);

	// create the src file
	sprintf(src_pth, "Main.%s", lang_ext[lang]);
	if (DEBUG)
		printf("Main=%s", src_pth);
	FILE *fp_src = fopen(src_pth, "w");
	fprintf(fp_src, "%s", row[0]);
	mysql_free_result(res);
	fclose(fp_src);
}
void get_solution_info(int solution_id, int & p_id, char * user_id, int & lang) {
	MYSQL_RES *res;
	MYSQL_ROW row;

	char sql[BUFFER_SIZE];
	// get the problem id and user id from Table:solution
	sprintf(
			sql,
			"SELECT problem_id, user_id, language FROM solution where solution_id=%d",
			solution_id);
	//printf("%s\n",sql);
	mysql_real_query(conn, sql, strlen(sql));
	res = mysql_store_result(conn);
	row = mysql_fetch_row(res);
	p_id = atoi(row[0]);
	strcpy(user_id, row[1]);
	lang = atoi(row[2]);
	mysql_free_result(res);
}

void get_problem_info(int & p_id, int & time_lmt, int & mem_lmt, int & isspj) {
	// get the problem info from Table:problem
	char sql[BUFFER_SIZE];
	MYSQL_RES *res;
	MYSQL_ROW row;
	sprintf(
			sql,
			"SELECT time_limit,memory_limit,spj FROM problem where problem_id=%d",
			p_id);
	mysql_real_query(conn, sql, strlen(sql));
	res = mysql_store_result(conn);
	row = mysql_fetch_row(res);
	time_lmt = atoi(row[0]);
	mem_lmt = atoi(row[1]);
	isspj = row[2][0] - '0';
	mysql_free_result(res);
}

void prepare_files(char * filename, int namelen, char * infile, int & p_id,
		char * work_dir, char * outfile, char * userfile, int runner_id) {
	//		printf("ACflg=%d %d check a file!\n",ACflg,solution_id);

	char cmd[BUFFER_SIZE], fname[BUFFER_SIZE];
	strncpy(fname, filename, namelen);
	fname[namelen] = 0;
	sprintf(infile, "%s/data/%d/%s.in", oj_home, p_id, fname);
	execute_cmd("cp %s %sdata.in", infile, work_dir);

	sprintf(outfile, "%s/data/%d/%s.out", oj_home, p_id, fname);
	sprintf(userfile, "%s/run%d/user.out", oj_home, runner_id);
}

void copy_shell_runtime(char * work_dir) {

	execute_cmd("mkdir %s/lib", work_dir);
	execute_cmd("mkdir %s/bin", work_dir);
	execute_cmd("cp /lib/* %s/lib/", work_dir);
	execute_cmd("cp /bin/busybox %s/bin/", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/sh", work_dir);

}
void copy_bash_runtime(char * work_dir) {
	char cmd[BUFFER_SIZE];
	//const char * ruby_run="/usr/bin/ruby";
	copy_shell_runtime(work_dir);
	execute_cmd("cp /bin/bash %s/bin/bash", work_dir);
	execute_cmd("cp `which bc`  %s/bin/", work_dir);
	execute_cmd("busybox dos2unix Main.sh", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/grep", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/awk", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/sed", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/sort", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/join", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/wc", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/tr", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/dc", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/dd", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/cat", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/tail", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/head", work_dir);
	execute_cmd("ln -s /bin/busybox %s/bin/xargs", work_dir);
    execute_cmd("chmod +rx %s/Main.sh", work_dir);

}
void copy_ruby_runtime(char * work_dir) {

	copy_shell_runtime(work_dir);
	execute_cmd("mkdir %s/usr", work_dir);
	execute_cmd("mkdir %s/usr/lib", work_dir);
	execute_cmd("cp /usr/lib/libruby* %s/usr/lib/", work_dir);
	execute_cmd("cp /usr/bin/ruby* %s/", work_dir);

}
void copy_python_runtime(char * work_dir) {

	copy_shell_runtime(work_dir);
	execute_cmd("mkdir %s/usr", work_dir);
	execute_cmd("mkdir %s/usr/lib", work_dir);
	execute_cmd("cp /usr/bin/python* %s/", work_dir);

}

void run_solution(int & lang, char * work_dir, int & time_lmt, int & usedtime,
		int & mem_lmt) {
	char java_p1[BUFFER_SIZE], java_p2[BUFFER_SIZE];
	// child
	// set the limit
	struct rlimit LIM; // time limit, file limit& memory limit
	// time limit
	LIM.rlim_cur = (time_lmt - usedtime / 1000) + 1;
	LIM.rlim_max = LIM.rlim_cur;
	//if(DEBUG) printf("LIM_CPU=%d",(int)(LIM.rlim_cur));
	setrlimit(RLIMIT_CPU, &LIM);
	alarm(LIM.rlim_cur * 2 + 3);
	// file limit
	LIM.rlim_max = STD_F_LIM + STD_MB;
	LIM.rlim_cur = STD_F_LIM;
	setrlimit(RLIMIT_FSIZE, &LIM);
	// proc limit
	if (lang < 3) { //java ruby bash python need more threads/processes
		LIM.rlim_cur = 10;
		LIM.rlim_max = 10;
	} else {
		LIM.rlim_cur = 100;
		LIM.rlim_max = 100;
	}
	setrlimit(RLIMIT_NPROC, &LIM);
	// set the stack
	LIM.rlim_cur = STD_MB << 3;
	LIM.rlim_max = STD_MB << 3;
	setrlimit(RLIMIT_STACK, &LIM);
	chdir(work_dir);
	// open the files
	freopen("data.in", "r", stdin);
	freopen("user.out", "w", stdout);
	freopen("error.out", "w", stderr);
	// trace me
	ptrace(PTRACE_TRACEME, 0, NULL, NULL);
	// run me
	if (lang != 3)
		chroot(work_dir);

	// now the user is "judger"
	setuid(1536);
	setresuid(1536, 1536, 1536);
	switch (lang) {
	case 0:
	case 1:
	case 2:
		execl("./Main", "./Main", NULL);
		break;
	case 3:
		sprintf(java_p1, "-Xms%dM", mem_lmt / 2);
		sprintf(java_p2, "-Xmx%dM", mem_lmt);
		if (DEBUG)
			write_log("java_parameter:%s %s", java_p1, java_p2);
		execl("/usr/bin/java", "/usr/bin/java", java_p1, java_p2,
				"-Djava.security.manager",
				"-Djava.security.policy=./java.policy", "Main", NULL);
		break;
	case 4:
		system("/ruby Main.rb<data.in");
		//execl("./ruby", "Main.rb", NULL);
		break;
	case 5: //bash
		system("/Main.sh<data.in");
		break;
	case 6: //Python
		system("/python Main.py<data.in");
		break;
	}
	//sleep(1);
	exit(0);
}
int fix_java_mis_judge(char *work_dir, int & ACflg, int & topmemory,
		int mem_lmt) {
	int comp_res = OJ_AC;
	if (DEBUG)
		execute_cmd("cat %s/error.out", work_dir);
	comp_res = execute_cmd("grep 'java.lang.OutOfMemoryError'  %s/error.out",
			work_dir);

	if (!comp_res) {
		printf("JVM need more Memory!");
		ACflg = OJ_ML;
		topmemory = mem_lmt * STD_MB;
	}
	comp_res = execute_cmd("grep 'java.lang.OutOfMemoryError'  %s/user.out",
			work_dir);

	if (!comp_res) {
		printf("JVM need more Memory or Threads!");
		ACflg = OJ_ML;
		topmemory = mem_lmt * STD_MB;
	}
	comp_res = execute_cmd("grep 'Could not create'  %s/error.out", work_dir);

	if (!comp_res) {
		printf("jvm need more resource,tweak -Xmx Settings");
		ACflg = OJ_RE;
		//topmemory=0;
	}
	return comp_res;
}

void judge_solution(int & ACflg, int & usedtime, int time_lmt, int isspj,
		int p_id, char * infile, char * outfile, char * userfile, int & PEflg,
		int lang, char * work_dir, int & topmemory, int mem_lmt) {
	//usedtime-=1000;
	int comp_res;
	if (ACflg == OJ_AC && usedtime > time_lmt * 1000)
		ACflg = OJ_TL;
	// compare
	if (ACflg == OJ_AC) {
		if (isspj) {
			comp_res = execute_cmd("%s/data/%d/spj %s %s %s", oj_home,
					p_id, infile, outfile, userfile);

			if (comp_res == 0)
				comp_res = OJ_AC;
			else {
				if (DEBUG)
					printf("fail test %s\n", infile);
				comp_res = OJ_WA;
			}
		} else {
			comp_res = compare(outfile, userfile);
		}
		if (comp_res == OJ_WA) {
			ACflg = OJ_WA;
			if (DEBUG)
				printf("fail test %s\n", infile);
		} else if (comp_res == OJ_PE)
			PEflg = OJ_PE;
		ACflg = comp_res;
	}
	//jvm popup messages, if don't consider them will get miss-WrongAnswer
	if (lang == 3 && ACflg != OJ_AC) {
		comp_res = fix_java_mis_judge(work_dir, ACflg, topmemory, mem_lmt);
	}
}

int get_page_fault_mem(struct rusage & ruse, pid_t & pidApp) {
	//java use pagefault
	int m_vmpeak, m_vmdata, m_minflt;
	m_minflt = ruse.ru_minflt * getpagesize();
	if (0 && DEBUG) {
		m_vmpeak = get_proc_status(pidApp, "VmPeak:");
		m_vmdata = get_proc_status(pidApp, "VmData:");
		printf("VmPeak:%d KB VmData:%d KB minflt:%d KB\n", m_vmpeak, m_vmdata,
				m_minflt >> 10);
	}
	return m_minflt;
}

void watch_solution(pid_t pidApp, char * infile, int & ACflg, int isspj,
		char * userfile, char * outfile, int solution_id, int lang,
		int & topmemory, int mem_lmt, int & usedtime, int time_lmt, int & p_id,
		int & PEflg, char * work_dir) {
	// parent
	int tempmemory;
	if (DEBUG)
		printf("pid=%d judging %s\n", pidApp, infile);

	int status, sig, exitcode;
	struct user_regs_struct reg;
	struct rusage ruse;
	int sub = 0;
	while (1) {
		// check the usage

		wait4(pidApp, &status, 0, &ruse);
		//sig = status >> 8;/*status >> 8 差不多是EXITCODE*/

		if (WIFEXITED(status))
			break;
		if (lang < 4 && get_file_size("error.out")) {
			ACflg = OJ_RE;
			ptrace(PTRACE_KILL, pidApp, NULL, NULL);
			break;
		}

		if (!isspj && get_file_size(userfile) > get_file_size(outfile) * 10) {
			ACflg = OJ_OL;
			ptrace(PTRACE_KILL, pidApp, NULL, NULL);
			break;
		}

		exitcode = WEXITSTATUS(status);
		/*exitcode == 5 是正常暂停
		 * ruby using system to run,exit 17 ok
		 *  */
		if ((lang >= 4 && exitcode == 17) || exitcode == 0x05 || exitcode == 0)
			//go on and on
			;
		else {
			if (DEBUG) {
				printf("status>>8=%d\n", exitcode);
				psignal(exitcode, NULL);
			}
			if (ACflg == OJ_AC)
				switch (exitcode) {
				case SIGXCPU:
					ACflg = OJ_TL;
					break;
				case SIGXFSZ:
					ACflg = OJ_OL;
					break;
				case SIGALRM:
				default:
					ACflg = OJ_RE;
				}
			ptrace(PTRACE_KILL, pidApp, NULL, NULL);

			break;
		}
		if (WIFSIGNALED(status)) {
			/*  WIFSIGNALED: 如果进程是被信号结束的，返回True
			 *
			 *  另 psignal(int sig, char *s)，进行类似perror(char *s)的操作，打印 s, 并输出信号 sig 对应的提示，其中
			 *  sig = 5 对应的是 Trace/breakpoint trap
			 *  sig = 11 对应的是 Segmentation fault
			 *  sig = 25 对应的是 File size limit exceeded
			 *
			 *  WTERMSIG: 返回在上述情况下结束进程的信号
			 *  */
			sig = WTERMSIG(status);
			if (DEBUG) {
				printf("WTERMSIG=%d\n", sig);
				psignal(sig, NULL);
			}
			if (ACflg == OJ_AC)
				switch (sig) {
				case SIGCHLD:
				case SIGALRM:
				case SIGKILL:
				case SIGXCPU:
					ACflg = OJ_TL;
					break;
				case SIGXFSZ:
					ACflg = OJ_OL;
					break;

				default:
					ACflg = OJ_RE;
				}
			break;
		}
		/*     commited from http://www.felix021.com/blog/index.php?go=category_13


		 WIFSTOPPED: 如果进程在被ptrace调用监控的时候被信号暂停/停止，返回True
		 WSTOPSIG: 返回在上述情况下暂停/停止进程的信号

		 */

		// check the system calls
		ptrace(PTRACE_GETREGS, pidApp, NULL, &reg);
		/*if(DEBUG){
		 write_log("call:%lucounter:%d",reg.REG_SYSCALL,call_counter[reg.REG_SYSCALL]);
		 }*/
		if (call_counter[reg.REG_SYSCALL] == 0) { //do not limit JVM syscall for using different JVM
			ACflg = OJ_RE;
			write_log(
					"[ERROR] A Not allowed system call: runid:%d callid:%d\n",
					solution_id, reg.REG_SYSCALL);
			ptrace(PTRACE_KILL, pidApp, NULL, NULL);
		} else {
			if (sub == 1)
				call_counter[reg.REG_SYSCALL]--;
		}
		sub = 1 - sub;

		//jvm gc ask VM before need,so used kernel page fault times and page size
		if (lang == 3) {
			tempmemory = get_page_fault_mem(ruse, pidApp);
		} else {//other use VmPeak
			tempmemory = get_proc_status(pidApp, "VmPeak:") << 10;
		}
		if (tempmemory > topmemory)
			topmemory = tempmemory;
		if (topmemory > mem_lmt * STD_MB) {
			if (DEBUG)
				printf("out of memory %d\n", topmemory);
			if (ACflg == OJ_AC)
				ACflg = OJ_ML;
			ptrace(PTRACE_KILL, pidApp, NULL, NULL);
			break;
		}
		ptrace(PTRACE_SYSCALL, pidApp, NULL, NULL);
	}
	usedtime += (ruse.ru_utime.tv_sec * 1000 + ruse.ru_utime.tv_usec / 1000);
	usedtime += (ruse.ru_stime.tv_sec * 1000 + ruse.ru_stime.tv_usec / 1000);

}
void clean_workdir(char work_dir[BUFFER_SIZE]) {
	if (DEBUG) {
		execute_cmd("mv %s/* %slog/", work_dir, work_dir);

	} else {
		execute_cmd("rm -Rf %s/*", work_dir);
	}

}

void init_parameters(int argc, char **& argv, int & solution_id,
		int & runner_id) {
	if (argc < 3) {
		fprintf(stderr, "Usage:%s solution_id runner_id.\n", argv[0]);
		fprintf(stderr, "Multi:%s solution_id runner_id judge_base_path.\n",
				argv[0]);
		fprintf(stderr,
				"Debug:%s solution_id runner_id judge_base_path debug.\n",
				argv[0]);
		exit(1);
	}
	DEBUG = (argc > 4);
	if (argc > 3)
		strcpy(oj_home, argv[3]);

	else
		strcpy(oj_home, "/home/judge");

	chdir(oj_home); // change the dir// init our work
	if (!init_mysql_conn()) {
		exit(0); //exit if mysql is down
	}
	solution_id = atoi(argv[1]);
	runner_id = atoi(argv[2]);
}
int get_sim(int solution_id, int lang, int pid, int &sim_s_id) {
	char src_pth[BUFFER_SIZE];
	char cmd[BUFFER_SIZE];
	sprintf(src_pth, "Main.%s", lang_ext[lang]);

	int sim = execute_cmd("sim.sh %s %d", src_pth, pid);
	if (!sim) {
		execute_cmd("mkdir ../data/%d/ac/", pid);

		execute_cmd("mv %s ../data/%d/ac/%d.%s", src_pth, pid, solution_id,
				lang_ext[lang]);

	} else {

		FILE * pf;
		pf = fopen("sim", "r");
		if (pf) {
			fscanf(pf, "%d%d", &sim, &sim_s_id);
			fclose(pf);
		}

	}
	return sim;
}
int main(int argc, char** argv) {

	char work_dir[BUFFER_SIZE];
	char cmd[BUFFER_SIZE];
	char user_id[BUFFER_SIZE];
	int solution_id = 1000;
	int runner_id = 0;
	int p_id, time_lmt, mem_lmt, lang, isspj, sim, sim_s_id;

	init_parameters(argc, argv, solution_id, runner_id);

	//set work directory to start running & judging
	sprintf(work_dir, "%s/run%s/", oj_home, argv[2]);
	chdir(work_dir);

	get_solution_info(solution_id, p_id, user_id, lang);
	//get the limit
	get_problem_info(p_id, time_lmt, mem_lmt, isspj);
	//copy source file
	get_solution(solution_id, work_dir, lang);

	//java is lucky
	if (lang >= 3) {
		// the limit for java
		time_lmt = time_lmt + java_time_bonus;
		mem_lmt = mem_lmt + java_memory_bonus;
		// copy java.policy
		execute_cmd( "cp %s/etc/java0.policy %sjava.policy", oj_home, work_dir);

	}
	//never bigger than judged set value;
	if (time_lmt > 300 || time_lmt < 1)
		time_lmt = 300;
	if (mem_lmt > 1024 || mem_lmt < 1)
		mem_lmt = 1024;

	if (DEBUG)
		printf("time: %d mem: %d\n", time_lmt, mem_lmt);

	// compile
	//	printf("%s\n",cmd);
	// set the result to compiling
	int Compile_OK;
	Compile_OK = compile(lang);
	if (Compile_OK != 0) {
		update_solution(solution_id, OJ_CE, 0, 0, 0, 0);
		addceinfo(solution_id);
		update_user(user_id);
		update_problem(p_id);
		mysql_close(conn);
		if (!DEBUG)
			system("rm *");
		else
			write_log("compile error");
		exit(0);
	} else {
		update_solution(solution_id, OJ_RI, 0, 0, 0, 0);
	}
	//exit(0);
	// run
	char fullpath[BUFFER_SIZE];
	char infile[BUFFER_SIZE];
	char outfile[BUFFER_SIZE];
	char userfile[BUFFER_SIZE];
	sprintf(fullpath, "%s/data/%d", oj_home, p_id); // the fullpath of data dir

	// open DIRs
	DIR *dp;
	dirent *dirp;
	if ((dp = opendir(fullpath)) == NULL) {
		write_log("No such dir:%s!\n", fullpath);
		mysql_close(conn);
		exit(-1);
	}
	int ACflg, PEflg;
	ACflg = PEflg = OJ_AC;
	int namelen;
	int usedtime = 0, topmemory = 0;
	//create chroot for ruby bash python
	if (lang == 4)
		copy_ruby_runtime(work_dir);
	if (lang == 5)
		copy_bash_runtime(work_dir);
	if (lang == 6)
		copy_python_runtime(work_dir);
		
	// read files and run
	for (; ACflg == OJ_AC && (dirp = readdir(dp)) != NULL;) {
		namelen = isInFile(dirp->d_name); // check if the file is *.in or not
		if (namelen == 0)
			continue;

		prepare_files(dirp->d_name, namelen, infile, p_id, work_dir, outfile,
				userfile, runner_id);
		init_syscalls_limits(lang);
		pid_t pidApp = fork();
		if (pidApp == 0) {
			run_solution(lang, work_dir, time_lmt, usedtime, mem_lmt);
		} else {
			watch_solution(pidApp, infile, ACflg, isspj, userfile, outfile,
					solution_id, lang, topmemory, mem_lmt, usedtime, time_lmt,
					p_id, PEflg, work_dir);
			judge_solution(ACflg, usedtime, time_lmt, isspj, p_id, infile,
					outfile, userfile, PEflg, lang, work_dir, topmemory,
					mem_lmt);
		}
	}
	if (ACflg == OJ_AC && PEflg == OJ_PE)
		ACflg = OJ_PE;
	if (sim_enable && ACflg == OJ_AC && lang < 5) {//bash don't supported
		sim = get_sim(solution_id, lang, p_id, sim_s_id);
	}else{
	    sim = 0;
    }
	clean_workdir(work_dir);

	update_solution(solution_id, ACflg, usedtime, topmemory >> 10, sim,
			sim_s_id);
	update_user(user_id);
	update_problem(p_id);
	if (DEBUG)
		write_log("result=%d", ACflg);
	mysql_close(conn);
	return 0;
}

