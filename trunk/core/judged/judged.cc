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
#include <time.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <syslog.h>
#include <errno.h>
#include <fcntl.h>
#include <stdarg.h>
#include <mysql/mysql.h>
#include <sys/wait.h>
#include <sys/stat.h>

static int DEBUG=0;
#define bufsize 1024
#define LOCKFILE "/var/run/judged.pid"
#define LOCKMODE (S_IRUSR|S_IWUSR|S_IRGRP|S_IROTH)
#define STD_MB 1048576

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


static char host_name[bufsize];
static char user_name[bufsize];
static char password [bufsize];
static char db_name  [bufsize];
static char oj_home  [bufsize];
static int port_number;
static int max_running;
static int sleep_time;
static int sleep_tmp;
static int oj_tot;
static int oj_mod;



static MYSQL *conn;
static MYSQL_RES *res;
static MYSQL_ROW row;
//static FILE *fp_log;
static char query[bufsize];

void write_log(const char *fmt, ...)
{
	va_list         ap;
	char            buffer[4096];
//	time_t          t = time(NULL);
	int             l;
	FILE *fp = fopen("./log/server.log","a+");
	if (fp==NULL){
		 fprintf(stderr,"openfile error!\n");
		 system("pwd");
	}va_start(ap, fmt);
	l = vsprintf(buffer, fmt, ap);
	fprintf(fp,"%s\n",buffer);
	if (DEBUG) printf("%s\n",buffer);
	va_end(ap);
	fclose(fp);

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
	oj_tot=1;
	oj_mod=0;
	fp=fopen("./etc/judge.conf","r");
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
		}else if (strncmp(buf,"OJ_RUNNING",10)==0){
			sscanf(buf+11,"%d",&max_running);
			if (max_running<1) max_running=1;
			if (max_running>8) max_running=8;
		}else if (strncmp(buf,"OJ_SLEEP_TIME",13)==0){
			sscanf(buf+14,"%d",&sleep_time);
			if (sleep_time<1) sleep_time=1;
			if (sleep_time>20) sleep_time=20;
		}else if (strncmp(buf,"OJ_TOTAL",8)==0){
			sscanf(buf+9,"%d",&oj_tot);
			if (oj_tot<=0) oj_tot=1;
		}else if (strncmp(buf,"OJ_MOD",6)==0){
			sscanf(buf+7,"%d",&oj_mod);
			if (oj_mod<0 || oj_mod>=oj_tot) oj_mod=0;
		}
	}
	sprintf(query,"SELECT solution_id FROM solution WHERE result<2 and MOD(solution_id,%d)=%d ORDER BY result ASC,solution_id ASC limit %d",oj_tot,oj_mod,max_running*2);
	sleep_tmp=sleep_time;
}

bool updatedb(int solution_id,int result){
	char sql[bufsize];
	sprintf(sql,"UPDATE solution SET result=%d,time=0,memory=0,judgetime=NOW() WHERE solution_id=%d and result<2 LIMIT 1"
			,result,solution_id);
	if (mysql_real_query(conn,sql,strlen(sql))){
		syslog(LOG_ERR | LOG_DAEMON, "%s",mysql_error(conn));
		return false;
	}else{
		if(mysql_affected_rows(conn)>0ul)
			return true;
		else
			return false;
	}
	
}

void run_client(int runid,int clientid){
    char buf[2],runidstr[1024];
        struct rlimit LIM;
		LIM.rlim_max=300;
		LIM.rlim_cur=300;
		setrlimit(RLIMIT_CPU,&LIM);

		LIM.rlim_max=80*STD_MB;
		LIM.rlim_cur=80*STD_MB;
		setrlimit(RLIMIT_FSIZE,&LIM);

		LIM.rlim_max=STD_MB<<11;
		LIM.rlim_cur=STD_MB<<11;
		setrlimit(RLIMIT_AS,&LIM);

	//buf[0]=clientid+'0'; buf[1]=0;
	sprintf(buf,"%d",clientid);
	sprintf(runidstr,"%d",runid);
	if (!DEBUG)
		execl("/usr/bin/judge_client","/usr/bin/judge_client",runidstr,buf,oj_home,NULL);
	else
		execl("/usr/bin/judge_client","/usr/bin/judge_client",runidstr,buf,oj_home,"debug",NULL);


	//exit(0);
}
int executesql(const char * sql){

	if (mysql_real_query(conn,sql,strlen(sql))){
		if(DEBUG)write_log("%s", mysql_error(conn));
		sleep_time=60;
		return 1;
	}else
	    return 0;
}


int init_mysql(){
   // if(conn!=NULL) mysql_close(conn);	// close db
	conn=mysql_init(NULL);		// init the database connection
	/* connect the database */
	const char timeout=30;
    mysql_options(conn,MYSQL_OPT_CONNECT_TIMEOUT,&timeout);

	if(!mysql_real_connect(conn,host_name,user_name,password,
			db_name,port_number,0,0)){
		if(DEBUG)write_log("%s", mysql_error(conn));
		sleep_time=60;
		return 1;
	}
	if (executesql("set names utf8"))
        return 1;
	return 0;
}
int work(){
//	char buf[1024];
	int retcnt;
	int i;
	static pid_t ID[8]={0,0,0,0,0,0,0,0};
	static int workcnt=0;
	int runid;
	pid_t tmp_pid;

	retcnt=0;


	if (mysql_real_query(conn,query,strlen(query))){
		if(DEBUG)write_log("%s", mysql_error(conn));
		sleep_time=60;
		return 0;
	}
	sleep_time=sleep_tmp;
	/* get the database info */
	retcnt=0;
	res=mysql_store_result(conn);
	/* exec the submit */
	while ((row=mysql_fetch_row(res))){
		runid=atoi(row[0]);
		if (runid%oj_tot!=oj_mod) continue;
		if(DEBUG)write_log("Judging solution %d",runid);
		if (workcnt==max_running){		// if no more client can running
			tmp_pid=waitpid(-1,NULL,0);	// wait 4 one child exit
			for (i=0;i<max_running;i++)	// get the client id
				if (ID[i]==tmp_pid) break; // got the client id
		}else{							// have free client
			workcnt++;
			for (i=0;i<max_running;i++)	// find the client id
				if (ID[i]==0) break;	// got the client id
		}
		if(updatedb(atoi(row[0]),OJ_CI)){
			ID[i]=fork();					// start to fork
			if (ID[i]==0){
				if(DEBUG)write_log("<<=sid=%d===clientid=%d==>>\n",runid,i);
				run_client(runid,i);	// if the process is the son, run it
				exit(0);
			}
			retcnt++;
		}
	}
	if (retcnt==0){
		while (workcnt>0){
			workcnt--;
			waitpid(-1,NULL,0);

		}
		memset(ID,0,sizeof(ID));
	}
	mysql_free_result(res);				// free the memory
	executesql("commit");
    if(DEBUG&&retcnt)write_log("<<%ddone!>>",retcnt);
	return retcnt;
}

int lockfile(int fd)
{
	struct flock fl;
	fl.l_type = F_WRLCK;
	fl.l_start = 0;
	fl.l_whence = SEEK_SET;
	fl.l_len = 0;
	return (fcntl(fd,F_SETLK,&fl));
}

int already_running(){
	int fd;
	char buf[16];
	fd = open(LOCKFILE, O_RDWR|O_CREAT, LOCKMODE);
	if (fd < 0){
		syslog(LOG_ERR|LOG_DAEMON, "can't open %s: %s", LOCKFILE, strerror(errno));
		exit(1);
	}
	if (lockfile(fd) < 0){
		if (errno == EACCES || errno == EAGAIN){
			close(fd);
			return 1;
		}
		syslog(LOG_ERR|LOG_DAEMON, "can't lock %s: %s", LOCKFILE, strerror(errno));
		exit(1);
	}
	ftruncate(fd, 0);
	sprintf(buf,"%d", getpid());
	write(fd,buf,strlen(buf)+1);
	return (0);
}

void daemonize(){
	int i,fd0,fd1,fd2;
	pid_t pid;
	struct rlimit rl;
	struct sigaction sa;
	umask(0);
	if (getrlimit(RLIMIT_NOFILE, &rl)<0){
		syslog(LOG_DAEMON|LOG_ERR,"can't get file limit");
		exit(1);
	}
	if ((pid = fork()) < 0){
		syslog(LOG_ERR|LOG_DAEMON, "Can't fork!");
		printf("Could not daemonize!\n");
		exit(1);
	}
	else if (pid != 0) /* parent */
		exit(0);
	setsid();

	sa.sa_handler = SIG_IGN;
	sigemptyset(&sa.sa_mask);
	sa.sa_flags = 0;
	if (sigaction(SIGHUP, &sa, NULL) < 0){
		syslog(LOG_ERR|LOG_DAEMON, "can't ignore SIGHUP");
		exit(1);
	}

	if ((pid = fork()) < 0){
		syslog(LOG_ERR|LOG_DAEMON,"Can't fork(2)!");
		exit(1);
	}else if (pid != 0) exit(0);

	if (chdir(oj_home) < 0){
		syslog(LOG_ERR|LOG_DAEMON,"can't change dirctory to /");
		exit(1);
	}
	if (rl.rlim_max == RLIM_INFINITY) rl.rlim_max=1024;
	if (rl.rlim_max>1024) rl.rlim_max=1024;
	for (i=0; i < (int)rl.rlim_max; i++) close(i);
	fd0 = open("/dev/null", O_RDWR);
	fd1 = dup(0);
	fd2 = dup(0);
}

int main(int argc, char** argv){
    DEBUG=(argc>2);
    if (argc>1)
		strcpy(oj_home,argv[1]);
	else
	   strcpy(oj_home,"/home/judge");
	chdir(oj_home);// change the dir

	if (!DEBUG) daemonize();
	if ( strcmp(oj_home,"/home/judge")==0&&already_running()){
		syslog(LOG_ERR|LOG_DAEMON, "This daemon program is already running!\n");
		return 1;
	}
//	struct timespec final_sleep;
//	final_sleep.tv_sec=0;
//	final_sleep.tv_nsec=500000000;
	init_mysql_conf();	// set the database info

	while (1){			// start to run
	    if(!init_mysql()){
	        int j=work();
	        mysql_close(conn);	// close db
            if (j==0){	// if nothing done
                sleep(sleep_time);	// sleep
                syslog(LOG_ERR|LOG_DAEMON,"No WORK -- sleeping once");
            }

		}else{
			sleep(sleep_time*2);
		}
	}
	return 0;
}

