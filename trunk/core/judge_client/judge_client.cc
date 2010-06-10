//
// File:   main.cc
// Author: sempr
//

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
#define bufsize 512

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
static int DEBUG=0;
static char host_name[bufsize];
static char user_name[bufsize];
static char password [bufsize];
static char db_name  [bufsize];
static int port_number;
static int max_running;
static int sleep_time;
//static int sleep_tmp;

MYSQL *conn;

char lang_ext[4][8]={"c","cc","pas","java"};
char buf[bufsize];

long get_file_size(const char * filename )
   {
        struct stat f_stat;

        if( stat( filename, &f_stat ) == -1 ){
            return -1;
        }

        return (long)f_stat.st_size;
    }
int cleft[512];

void init_cleft(int lang){
	int i;
	memset(cleft,0,sizeof(cleft));
	if (lang<=1){ // C & C++
		for (i=0;LANG_CV[i];i++) cleft[LANG_CV[i]]=LANG_CC[i];
	}else if (lang==2){ // Pascal
		for (i=0;LANG_PV[i];i++) cleft[LANG_PV[i]]=LANG_PC[i];
	}else{ // Java
		for (i=0;LANG_JV[i];i++) cleft[LANG_JV[i]]=LANG_JC[i];
	}
}

// read the configue file
void init_mysql_conf(){
	FILE *fp;
	char buf[bufsize];
	host_name[0]=0;
	user_name[0]=0;
	password[0]=0;
	db_name[0]=0;
	port_number=3306;
	max_running=3;
	sleep_time=3;
	fp=fopen("/home/judge/etc/judge.conf","r");
	while (fgets(buf,bufsize-1,fp)){
		buf[strlen(buf)-1]=0;
		if (      strncmp(buf,"OJ_HOST_NAME",12)==0){
			strcpy(host_name,buf+13);
		}else if (strncmp(buf,"OJ_USER_NAME",12)==0){
			strcpy(user_name,buf+13);
		}else if (strncmp(buf,"OJ_PASSWORD",11)==0){
			strcpy(password, buf+12);
		}else if (strncmp(buf,"OJ_DB_NAME",10)==0){
			strcpy(db_name,buf+11);
		}else if (strncmp(buf,"OJ_PORT_NUMBER",14)==0){
			sscanf(buf+15,"%d",&port_number);
		}
	}
}

void write_log(const char *fmt, ...)
{
	va_list         ap;
	char            buffer[4096];
//	time_t          t = time(NULL);
	int             l;
	FILE *fp = fopen("/home/judge/log/client.log","a+");
	if (fp==NULL) fprintf(stderr,"openfile error!\n");
	va_start(ap, fmt);
	l = vsprintf(buffer, fmt, ap);
	fprintf(fp,"%s\n",buffer);
	if (DEBUG) printf("%s\n",buffer);
	va_end(ap);
	fclose(fp);
}



int isInFile(const char fname[]){
	int l=strlen(fname);
	if (l<=3||strcmp(fname+l-3,".in")!=0) return 0;
	else return l-3;
}

/****	
int compare(const char *file1,const char *file2){
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
 * */
int compare(const char *file1,const char *file2) {
    int ret = OJ_AC;
    FILE * f1,*f2;
    f1=fopen(file1,"r");
    f2=fopen(file2,"r");
    if (!f1||!f2) {
        ret=OJ_RE;
    }else
    for (;;) {
        // Find the first non-space character at the beginning of line.
        // Blank lines are skipped.
        int c1 = fgetc(f1);
        int c2 = fgetc(f2);
        while (isspace(c1) || isspace(c2)) {
            if (c1 != c2) {
                ret = OJ_PE;
            }
            if (isspace(c1)) {
                c1 = fgetc(f1);
            }
            if (isspace(c2)) {
                c2 = fgetc(f2);
            }
        }
        // Compare the current line.
        for (;;) {
            // Read until 2 files return a space or 0 together.
            while ((!isspace(c1) && c1) || (!isspace(c2) && c2)) {
                if (c1 < 0 || c2 < 0) {
                    return -1;
                }
                if (c1 != c2) {
                    // Consecutive non-space characters should be all exactly the same
                    return OJ_WA;
                }
                c1 = fgetc(f1);
                c2 = fgetc(f2);
            }
            // Find the next non-space character or \n.
            while ((isspace(c1) && c1 != '\n') || (isspace(c2) && c2 != '\n')) {
                if (c1 != c2) {
                    ret = OJ_PE;
                }
                if (isspace(c1) && c1 != '\n') {
                    c1 = fgetc(f1);
                }
                if (isspace(c2) && c2 != '\n') {
                    c2 = fgetc(f2);
                }
            }
            if (c1 < 0 || c2 < 0) {
                return OJ_RE;
            }
            if (!c1 && !c2) {
                return ret;
            }
            if ((c1 == '\n' || !c1) && (c2 == '\n' || !c2)) {
                break;
            }
        }
    }
    return ret;
}
void updatedb(int solution_id,int result,int time,int memory){
	char sql[bufsize];
	sprintf(sql,"UPDATE solution SET result=%d,time=%d,memory=%d,judgetime=NOW() WHERE solution_id=%d LIMIT 1%c"
			,result,time,memory,solution_id,0);
//	printf("sql= %s\n",sql);
	if (mysql_real_query(conn,sql,strlen(sql))){
//		printf("..update failed! %s\n",mysql_error(conn));
	}
}


void addceinfo(int solution_id){
	char sql[(1<<16)],*end;
	char ceinfo[(1<<16)],*cend;
	FILE *fp=fopen("ce.txt","r");
	snprintf(sql,(1<<16)-1,"DELETE FROM compileinfo WHERE solution_id=%d",solution_id);
	mysql_real_query(conn,sql,strlen(sql));
	cend=ceinfo;
	while (fgets(cend,1024,fp)){
		cend+=strlen(cend);
		if (cend-ceinfo>40000) break;
	}
	cend=0;
	end=sql;
	strcpy(end,"INSERT INTO compileinfo VALUES(");
	end+=strlen(sql);
	*end++='\'';
	end+=sprintf(end,"%d",solution_id);
	*end++='\'';
	*end++=',';
	*end++='\'';
	end+=mysql_real_escape_string(conn,end,ceinfo,strlen(ceinfo));
	*end++='\'';
	*end++=')';
	*end=0;
//	printf("%s\n",ceinfo);
	if(mysql_real_query(conn,sql,end-sql))
		printf("%s\n",mysql_error(conn));
	fclose(fp);
}


void update_user(char user_id[]){
	char sql[bufsize];
	sprintf(sql,"UPDATE `users` SET `solved`=(SELECT count(DISTINCT `problem_id`) FROM `solution` WHERE `user_id`=\'%s\' AND `result`=\'4\') WHERE `user_id`=\'%s\'",user_id,user_id);
	if (mysql_real_query(conn,sql,strlen(sql)))
		write_log(mysql_error(conn));
	sprintf(sql,"UPDATE `users` SET `submit`=(SELECT count(*) FROM `solution` WHERE `user_id`=\'%s\') WHERE `user_id`=\'%s\'",user_id,user_id);
	if (mysql_real_query(conn,sql,strlen(sql)))
		write_log(mysql_error(conn));
}


void update_problem(int p_id){
	char sql[bufsize];
	sprintf(sql,"UPDATE `problem` SET `accepted`=(SELECT count(*) FROM `solution` WHERE `problem_id`=\'%d\' AND `result`=\'4\') WHERE `problem_id`=\'%d\'",p_id,p_id);
	if (mysql_real_query(conn,sql,strlen(sql)))
		write_log(mysql_error(conn));
	sprintf(sql,"UPDATE `problem` SET `submit`=(SELECT count(*) FROM `solution` WHERE `problem_id`=\'%d\') WHERE `problem_id`=\'%d\'",p_id,p_id);
	if (mysql_real_query(conn,sql,strlen(sql)))
		write_log(mysql_error(conn));
}

int compile(int lang){
	int pid;

     const char * CP_C[]={"gcc","Main.c","-o","Main","-Wall","-lm","--static","-std=c99","-DONLINE_JUDGE",NULL};
	 const char * CP_X[]={"g++","Main.cc","-o","Main","-O2","-Wall","-lm","--static","-DONLINE_JUDGE",NULL};//"-I/usr/include/c++/4.3",
     const char * CP_P[]={"fpc","Main.pas","-oMain","-Co","-Cr","-Ct","-Ci",NULL};
	 const char * CP_J[]={"javac","-J-Xmx256m","Main.java",NULL};
	pid=fork();
	if (pid==0){
		struct rlimit LIM;
		LIM.rlim_max=60;
		LIM.rlim_cur=60;
		setrlimit(RLIMIT_CPU,&LIM);

		LIM.rlim_max=8*STD_MB;
		LIM.rlim_cur=8*STD_MB;
		setrlimit(RLIMIT_FSIZE,&LIM);

		LIM.rlim_max=512*STD_MB;
		LIM.rlim_cur=512*STD_MB;
		setrlimit(RLIMIT_AS,&LIM);

		freopen("ce.txt","w",stderr);
		freopen("/dev/null","w",stdout);
		switch(lang){
			case 0:execvp(CP_C[0],(char * const*)CP_C); break;
			case 1:execvp(CP_X[0],(char * const*)CP_X); break;
			case 2:execvp(CP_P[0],(char * const*)CP_P); break;
			case 3:execvp(CP_J[0],(char * const*)CP_J); break;
		}
//		printf("compile end!\n");
        return 0;
	}else{
		int status;
		waitpid(pid,&status,0);
//		printf("status=%d\n",status);
		return status;
	}

}
int read_proc_statm(int pid){
    FILE * pf;
    char fn[4096];
    int ret;
    sprintf(fn,"/proc/%d/statm",pid);
    pf=fopen(fn,"r");
    fscanf(pf,"%d",&ret);
    if(false&&DEBUG) {
		    int debug;
		    printf("statm: %d\t",ret);
	    	fscanf(pf,"%d",&debug);
	    	printf("%d\t",debug);
	    	fscanf(pf,"%d",&debug);
	    	printf("%d\t",debug);
	    	fscanf(pf,"%d",&debug);
	    	printf("%d\t",debug);
	    	fscanf(pf,"%d",&debug);
	    	printf("%d\t",debug);
	    	fscanf(pf,"%d",&debug);
	    	printf("%d\t",debug);
	    	fscanf(pf,"%d",&debug);
	    	printf("%d\n",debug);
	    	
	}
    fclose(pf);
    return ret;
}
int main(int argc, char** argv) {
	if (argc<3){
		fprintf(stderr,"Usage:%s runid runmachine.\n",argv[0]);
		exit(1);
	}
	if(argc==4) DEBUG=1;
	// init our work
	init_mysql_conf();
	conn=mysql_init(NULL);
	//mysql_real_connect(conn,host_name,user_name,password,db_name,port_number,0,0);
    const char timeout=30;
	mysql_options(conn,MYSQL_OPT_CONNECT_TIMEOUT,&timeout);

    if(!mysql_real_connect(conn,host_name,user_name,password,
			db_name,port_number,0,0)){
		write_log("%s", mysql_error(conn));
		return 0;
	}
    const char * utf8sql="set names utf8";
	if (mysql_real_query(conn,utf8sql,strlen(utf8sql))){
		write_log("%s", mysql_error(conn));
		return 0;
	}
	// copy the source file and get the limit
	char sql[bufsize];
	char work_dir[bufsize];
	char src_pth[bufsize];
	char cmd[bufsize];

	int solution_id=atoi(argv[1]);
	int p_id,time_lmt,mem_lmt,cas_lmt,lang,isspj;
	char user_id[bufsize];

	int sub;

	MYSQL_RES *res;
	MYSQL_ROW row;

	sprintf(work_dir,"/home/judge/run%s/",argv[2]);

	chdir(work_dir);

	// get the problem id and user id from Table:solution
	sprintf(sql,"SELECT problem_id, user_id, language FROM solution where solution_id=%s",argv[1]);
	//printf("%s\n",sql);
	mysql_real_query(conn,sql,strlen(sql));
	res=mysql_store_result(conn);
	row=mysql_fetch_row(res);
	p_id=atoi(row[0]);
	strcpy(user_id,row[1]);
	lang=atoi(row[2]);
	mysql_free_result(res);

	// get the problem info from Table:problem
	sprintf(sql,"SELECT time_limit,memory_limit,case_time_limit,spj FROM problem where problem_id=%d",p_id);
	mysql_real_query(conn,sql,strlen(sql));
	res=mysql_store_result(conn);
	row=mysql_fetch_row(res);
	time_lmt=atoi(row[0]);
	mem_lmt=atoi(row[1]);
	cas_lmt=atoi(row[2]);
	isspj=row[3][0]-'0';

	mysql_free_result(res);

	// the limit for java
	if (lang==3){
		time_lmt=time_lmt*2+2;
		mem_lmt=mem_lmt*2+687;
	}
    if(DEBUG)printf("time: %d mem: %d\n",time_lmt,mem_lmt);

	// get the source code
	sprintf(sql,"SELECT source FROM source_code WHERE solution_id=%s",argv[1]);
	mysql_real_query(conn,sql,strlen(sql));
	res=mysql_store_result(conn);
	row=mysql_fetch_row(res);

	// clear the work dir
	sprintf(cmd,"rm -rf %s*",work_dir);
	system(cmd);

	// create the src file
	sprintf(src_pth,"Main.%s",lang_ext[lang]);
	FILE *fp_src=fopen(src_pth,"w");
	fprintf(fp_src,"%s",row[0]);
	mysql_free_result(res);
	fclose(fp_src);

	// copy java.policy
	if (lang==3){
		sprintf(cmd,"cp /home/judge/etc/java%s.policy %sjava.policy", argv[2],work_dir);
		system(cmd);
	}

	// compile

//	printf("%s\n",cmd);
	// set the result to compiling
	int Compile_OK;
	Compile_OK=compile(lang);
	if (Compile_OK!=0){
		updatedb(solution_id,OJ_CE,0,0);
		addceinfo(solution_id);
		update_user(user_id);
		update_problem(p_id);
		system("rm *");
		return 0;
	}else{
		updatedb(solution_id,OJ_RI,0,0);
	}
	// run
	char fullpath[bufsize];	// DIR of the datafiles
	char fname[bufsize];	// FULL Name of the FILES
	char infile[bufsize];	// PATH&Name of the INPUT FILES
	char outfile[bufsize];	// PATH&Name of the OUTPUT FILES
	char userfile[bufsize];	// PATH&Name of the USERs OUTPUT FILES

	sprintf(fullpath,"/home/judge/data/%d",p_id);	// the fullpath of data dir

	// open DIRs
	DIR *dp;
	dirent *dirp;
	if ((dp=opendir(fullpath))==NULL){
		write_log("No such dir:%s!\n",fullpath);
		return -1;
	}
	int ACflg,PEflg;
	ACflg=PEflg=OJ_AC;
	int namelen;
	int usedtime, topmemory, tempmemory;
	int comp_res;
	usedtime=0; topmemory=0;
	// read files and run
	for (;ACflg==OJ_AC && (dirp=readdir(dp))!=NULL;){
		namelen=isInFile(dirp->d_name); // check if the file is *.in or not
		if (namelen==0) continue;
//		printf("ACflg=%d %d check a file!\n",ACflg,solution_id);
		strncpy(fname,dirp->d_name,namelen);
		fname[namelen]=0;
		sprintf(infile,"/home/judge/data/%d/%s.in",p_id,fname);
		sprintf(cmd,"cp %s %sdata.in",infile,work_dir);
		system(cmd);
		sprintf(outfile,"/home/judge/data/%d/%s.out",p_id,fname);
		sprintf(userfile,"/home/judge/run%s/user.out",argv[2]);\
		init_cleft(lang);
		pid_t pidApp=fork();	
		if (pidApp==0){		// child
			// set the limit
			struct rlimit LIM; // time limit, file limit& memory limit
			// time limit
			LIM.rlim_cur=(time_lmt-usedtime/1000)+2;
			LIM.rlim_max=LIM.rlim_cur+1;
			//if(DEBUG) printf("LIM_CPU=%d",(int)(LIM.rlim_cur));
			setrlimit(RLIMIT_CPU,  &LIM);
			alarm(LIM.rlim_cur*2+3);
			// file limit
			LIM.rlim_max=STD_F_LIM+STD_MB; LIM.rlim_cur=STD_F_LIM;
			setrlimit(RLIMIT_FSIZE,&LIM);

			// proc limit
			LIM.rlim_cur=10; LIM.rlim_max=10;
			setrlimit(RLIMIT_NPROC,&LIM);
			// set the stack
			LIM.rlim_cur=STD_MB<<3; LIM.rlim_max=STD_MB<<3;
			setrlimit(RLIMIT_STACK,&LIM);

			chdir(work_dir);
			if(DEBUG) printf("starting \n");
			// open the files
			freopen("data.in","r",stdin);
			freopen("user.out","w",stdout);
			freopen("error.out","w",stderr);
			// trace me
			ptrace(PTRACE_TRACEME,0,NULL,NULL);
			// run me
			if (lang!=3) chroot(work_dir);
			// now the user is "judger"
			setuid(1536);
			setresuid(1536,1536,1536);
			
			if (lang!=3) execl("./Main","./Main",NULL);
			else execl("/usr/bin/java","/usr/bin/java","-Xmx256m","-Djava.security.manager"
			,"-Djava.security.policy=./java.policy","Main",NULL);
			//sleep(1);
			
			
			return 0;
		}else{				// parent
			if(DEBUG) printf("judging \n");
			int status,sig;
			struct user_regs_struct reg;
			struct rusage ruse;
			
			sub=0;
			while (1){
				// check the usage

				wait4(pidApp,&status,0,&ruse);
				sig=status>>8;/*status >> 8 差不多是EXITCODE*/

				if (WIFEXITED(status)) break;
				if(get_file_size("error.out")){
					ACflg=OJ_RE;
					ptrace(PTRACE_KILL,pidApp,NULL,NULL);
					break;				
				}
				
				if(get_file_size(userfile)>get_file_size(outfile)*10){
					ACflg=OJ_OL;
					ptrace(PTRACE_KILL,pidApp,NULL,NULL);
					break;
				}
				
				if (WIFSIGNALED(status)){
					sig=WTERMSIG(status);
					printf("sig=%d\n",sig);
					if (ACflg==OJ_AC) switch (sig){
						case SIGALRM:
						case SIGXCPU: ACflg=OJ_TL; break;
						case SIGXFSZ: ACflg=OJ_OL; break;
						default: ACflg=OJ_RE;
					}
					break;
				}
				
				if (sig==0x05);
				else {
					if (ACflg==OJ_AC) switch (sig){
						case SIGALRM:
						case SIGXCPU: ACflg=OJ_TL; break;
						case SIGXFSZ: ACflg=OJ_OL; break;
						default: ACflg=OJ_RE;
					}
					ptrace(PTRACE_KILL,pidApp,NULL,NULL);
					break;
				}
/* sig == 5 差不多是正常暂停     commited from http://www.felix021.com/blog/index.php?go=category_13

WIFSIGNALED: 如果进程是被信号结束的，返回True
  WTERMSIG: 返回在上述情况下结束进程的信号

WIFSTOPPED: 如果进程在被ptrace调用监控的时候被信号暂停/停止，返回True
  WSTOPSIG: 返回在上述情况下暂停/停止进程的信号

另 psignal(int sig, char *s)，进行类似perror(char *s)的操作，打印 s, 并输出信号 sig 对应的提示，其中
sig = 5 对应的是 Trace/breakpoint trap
sig = 11 对应的是 Segmentation fault
sig = 25 对应的是 File size limit exceeded*/

				// check the system calls
				ptrace(PTRACE_GETREGS,pidApp,NULL,&reg);
				if (cleft[reg.orig_eax]==0){
					ACflg=OJ_RE;
					write_log("[ERROR] A Not allowed system call: runid:%s callid:%d\n",argv[1],reg.orig_eax);
					ptrace(PTRACE_KILL,pidApp,NULL,NULL);
				}else{
					if (sub==1) cleft[reg.orig_eax]--;
				}
				sub=1-sub;

				   
				tempmemory=read_proc_statm(pidApp)*getpagesize();
				if (tempmemory>topmemory) topmemory=tempmemory;
				if(DEBUG&&false) {
					printf("wait4: %ld\t%ld\t%ld\t%d\t%ld\n",ruse.ru_maxrss,ruse.ru_isrss,ruse.ru_ixrss,getpagesize(),ruse.ru_minflt);
					printf("memory: %d %d %ld\n",topmemory,mem_lmt*STD_MB,ruse.ru_majflt);
					//system("jps");
					//sprintf(cmd,"jstat -gccapacity %d",pidApp);
					//system(cmd);
				}
				if (topmemory>mem_lmt*STD_MB){
					if(DEBUG) printf("out of memory %d\n",topmemory);
					if (ACflg==OJ_AC) ACflg=OJ_ML;
					ptrace(PTRACE_KILL,pidApp,NULL,NULL);
					break;
				}
				ptrace(PTRACE_SYSCALL,pidApp,NULL,NULL);
			}
			usedtime+=(ruse.ru_utime.tv_sec*1000+ruse.ru_utime.tv_usec/1000);
			usedtime+=(ruse.ru_stime.tv_sec*1000+ruse.ru_stime.tv_usec/1000);
			//usedtime-=1000;
			if (ACflg==OJ_AC && usedtime>time_lmt*1000) ACflg=OJ_TL;
			// compare
			if (ACflg==OJ_AC){
				if (isspj){
					sprintf(buf,"/home/judge/data/%d/spj %s %s %s", p_id, infile, outfile, userfile);
					comp_res = system(buf);
					if (comp_res == 0) comp_res = OJ_AC;
					else{
					    if(DEBUG) printf("fail test %s\n",infile);
					    comp_res = OJ_WA;
                    }
				}else{
					comp_res=compare(outfile,userfile);
				}
				if (comp_res==OJ_WA) {
				    ACflg=OJ_WA;
				    if(DEBUG) printf("fail test %s\n",infile);
				}
				else if (comp_res==OJ_PE) PEflg=OJ_PE;
			}
			if(lang==3&&ACflg!=OJ_AC){
				sprintf(buf,"cat %s/error.out", work_dir);
				comp_res = system(buf);
				sprintf(buf,"grep 'java.lang.OutOfMemoryError'  %s/error.out", work_dir);
				comp_res = system(buf);
				printf("MLE:%d",comp_res);
				if(!comp_res) {
					ACflg=OJ_ML;
					topmemory=512*STD_MB;
				}
				sprintf(buf,"grep 'Could not create'  %s/error.out", work_dir);
				comp_res = system(buf);
				printf("jvm:%d",comp_res);
				if(!comp_res) {
					ACflg=OJ_RE;
					topmemory=0;
				}
			}
		}
	}
	if(DEBUG) printf("result: %d\n",ACflg);
	sprintf(buf,"rm %s/*", work_dir);
	system(buf);
	if (ACflg==OJ_AC && PEflg==OJ_PE) ACflg=OJ_PE;
	updatedb(solution_id,ACflg,usedtime,topmemory>>10);
	update_user(user_id);
	update_problem(p_id);
	mysql_close(conn);
	return 0;
}

