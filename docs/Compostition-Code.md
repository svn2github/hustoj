# 代码解读


原文地址：<http://blog.csdn.net/legan/article/details/40746829> <http://blog.csdn.net/legan/article/details/40789939>

### 第一部分

> 非常感谢 `zhblue` 贡献了这么美丽的代码
> 
> 为了开发适合自己学校的oj，努力研读代码中，不断的百度，调试，测试
> 
> 对 `ubuntu` ，`linux` 的各种文件系统，进程系统，C语言编程都学习了不少
> 
> 给大家分享下，希望能减少重复的工作量
> 
> 注释里有很多不足，不到位的地方，请批评指正
> 
> 应该不侵权吧

```c
/*
 * Copyright 2008 sempr <iamsempr@gmail.com>
 *
 * Refacted and modified by zhblue<newsclan@gmail.com> 
 * Bug report email newsclan@gmail.com
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
#include <ctype.h>
#include <stdlib.h>
#include <unistd.h>
#include <syslog.h>
#include <errno.h>
#include <fcntl.h>
#include <stdarg.h>
#include <mysql/mysql.h>
#include <sys/wait.h>
#include <sys/stat.h>
#include <signal.h>
#include <sys/resource.h>
static int DEBUG = 0; //是否启用调试，来查看日志运行记录，默认0，不启用
#define BUFFER_SIZE 1024
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
 
static char host_name[BUFFER_SIZE];
static char user_name[BUFFER_SIZE];
static char password[BUFFER_SIZE];
static char db_name[BUFFER_SIZE];
static char oj_home[BUFFER_SIZE];
static char oj_lang_set[BUFFER_SIZE];
static int port_number;
static int max_running;
static int sleep_time;
static int sleep_tmp;
static int oj_tot;
static int oj_mod;
static int http_judge = 0;
static char http_baseurl[BUFFER_SIZE];
static char http_username[BUFFER_SIZE];
static char http_password[BUFFER_SIZE];
 
static bool STOP = false;
 
static MYSQL *conn;
static MYSQL_RES *res;	//mysql读取结果集，在_get_http/mysql_jobs()中被更新
static MYSQL_ROW row;
//static FILE *fp_log;
static char query[BUFFER_SIZE];//在init_mysql_conf中更新，固定取2倍最大判题客户端的待评判题目solution_id
 
void call_for_exit(int s) {
	STOP = true;
	printf("Stopping judged...\n");
}
 
void write_log(const char *fmt, ...) {
	va_list ap;
	char buffer[4096];
//	time_t          t = time(NULL);
//	int             l;
	sprintf(buffer, "%s/log/client.log", oj_home);
	FILE *fp = fopen(buffer, "a+");
	if (fp == NULL) {
		fprintf(stderr, "openfile error!\n");
		system("pwd");
	}
	va_start(ap, fmt);
	vsprintf(buffer, fmt, ap);
	fprintf(fp, "%s\n", buffer);
	if (DEBUG)
		printf("%s\n", buffer);
	va_end(ap);
	fclose(fp);
 
}
 
int after_equal(char * c) {
	int i = 0;
	for (; c[i] != '\0' && c[i] != '='; i++)
		;
	return ++i;
}
void trim(char * c) {
	char buf[BUFFER_SIZE];
	char * start, *end;
	strcpy(buf, c);
	start = buf;
	while (isspace(*start))
		start++;
	end = start;
	while (!isspace(*end))
		end++;
	*end = '\0';
	strcpy(c, start);
}
bool read_buf(char * buf, const char * key, char * value) {
	if (strncmp(buf, key, strlen(key)) == 0) {
		strcpy(value, buf + after_equal(buf));
		trim(value);
		if (DEBUG)
			printf("%s\n", value);
		return 1;
	}
	return 0;
}
void read_int(char * buf, const char * key, int * value) {
	char buf2[BUFFER_SIZE];
	if (read_buf(buf, key, buf2))
		sscanf(buf2, "%d", value);
 
}
// read the configue file
void init_mysql_conf() {
	FILE *fp = NULL;
	char buf[BUFFER_SIZE];
	host_name[0] = 0;
	user_name[0] = 0;
	password[0] = 0;
	db_name[0] = 0;
	port_number = 3306;
	max_running = 3;
	sleep_time = 1;
	oj_tot = 1;
	oj_mod = 0;
	strcpy(oj_lang_set, "0,1,2,3,4,5,6,7,8,9,10");
	fp = fopen("./etc/judge.conf", "r");
	if (fp != NULL) {
		while (fgets(buf, BUFFER_SIZE - 1, fp)) {
			read_buf(buf, "OJ_HOST_NAME", host_name);
			read_buf(buf, "OJ_USER_NAME", user_name);
			read_buf(buf, "OJ_PASSWORD", password);
			read_buf(buf, "OJ_DB_NAME", db_name);
			read_int(buf, "OJ_PORT_NUMBER", &port_number);
			read_int(buf, "OJ_RUNNING", &max_running);
			read_int(buf, "OJ_SLEEP_TIME", &sleep_time);
			read_int(buf, "OJ_TOTAL", &oj_tot);
 
			read_int(buf, "OJ_MOD", &oj_mod);
 
			read_int(buf, "OJ_HTTP_JUDGE", &http_judge);
			read_buf(buf, "OJ_HTTP_BASEURL", http_baseurl);
			read_buf(buf, "OJ_HTTP_USERNAME", http_username);
			read_buf(buf, "OJ_HTTP_PASSWORD", http_password);
			read_buf(buf, "OJ_LANG_SET", oj_lang_set);
 
		}
		sprintf(query,
				"SELECT solution_id FROM solution WHERE language in (%s) and result<2 and MOD(solution_id,%d)=%d ORDER BY result ASC,solution_id ASC limit %d",
				oj_lang_set, oj_tot, oj_mod, max_running * 2);
		sleep_tmp = sleep_time;
		//	fclose(fp);
	}
}
 
 
//当有代评测提交，并且进程数允许的情况下，创建新的子进程调用该评测函数
//输入：代评测提交的solution_id, 子进程在ID[]中的保存位置 i  
void run_client(int runid, int clientid) {
	char buf[BUFFER_SIZE], runidstr[BUFFER_SIZE];
	//在Linux系统中，Resouce limit指在一个进程的执行过程中，它所能得到的资源的限制，
	//比如进程的core file的最大值，虚拟内存的最大值等 ，这是运行时间，内存大小实现的关键 
	/*
	结构体中 rlim_cur是要取得或设置的资源软限制的值，rlim_max是硬限制
	这两个值的设置有一个小的约束：	
	1） 任何进程可以将软限制改为小于或等于硬限制
	2）任何进程都可以将硬限制降低，但普通用户降低了就无法提高，该值必须等于或大于软限制
	3） 只有超级用户可以提高硬限制
	
	setrlimit(int resource,const struct rlimit rlptr);返回：若成功为0，出错为非0	
	RLIMIT_CPU：CPU时间的最大量值（秒），当超过此软限制时向该进程发送SIGXCPU信号
	RLIMIT_FSIZE:可以创建的文件的最大字节长度，当超过此软限制时向进程发送SIGXFSZ
	*/ 
	struct rlimit LIM;
	LIM.rlim_max = 800;
	LIM.rlim_cur = 800;
	setrlimit(RLIMIT_CPU, &LIM);//cpu运行时间限制 
 
	LIM.rlim_max = 80 * STD_MB;
	LIM.rlim_cur = 80 * STD_MB;
	setrlimit(RLIMIT_FSIZE, &LIM);//可文件大小限制，防止恶意程序的吗？ 
 
	LIM.rlim_max = STD_MB << 11;//左移11 STD_MB是2^20 MB 2^11MB 2GB机器起码的2GB虚拟内存？ 
	LIM.rlim_cur = STD_MB << 11;
	setrlimit(RLIMIT_AS, &LIM);//最大运行的虚拟内存大小限制 
 
	LIM.rlim_cur = LIM.rlim_max = 200;
	setrlimit(RLIMIT_NPROC, &LIM);//每个实际用户ID所拥有的最大子进程数，这些都是为了防止恶意程序的吧？？ 
 
	//buf[0]=clientid+'0'; buf[1]=0;
	sprintf(runidstr, "%d", runid);//转换成字符？还是字符串？ 
	sprintf(buf, "%d", clientid);
 
	//write_log("sid=%s\tclient=%s\toj_home=%s\n",runidstr,buf,oj_home);
	//sprintf(err,"%s/run%d/error.out",oj_home,clientid);
	//freopen(err,"a+",stderr);
 
	if (!DEBUG)
		execl("/usr/bin/judge_client", "/usr/bin/judge_client", runidstr, buf,
				oj_home, (char *) NULL);
	else
	
    // 返回值：如果执行成功则函数不会返回, 执行失败则直接返回-1, 失败原因存于errno 中. 
	// execl()其中后缀"l"代表list也就是参数列表的意思，第一参数path字符指针所指向要执行的文件路径， 
	// 接下来的参数代表执行该文件时传递的参数列表：argv[0],argv[1]... 最后一个参数须用空指针NULL作结束。 
    // 执行/bin目录下的ls, 第一参数为程序名ls, 第二个参数为"-al", 第三个参数为"/etc/passwd"
    // execl("/bin/ls", "ls", "-al", "/etc/passwd", (char *) 0);
    // 这里第一个参数为程序名称 judge_client ，第二个参数为代评测题目 id , 第三个为本进程 pid 保存位置，第四个参数为 oj 目录
    // 默认/home/judge,第五个参数为"debug" 
		execl("/usr/bin/judge_client", "/usr/bin/judge_client", runidstr, buf,
				oj_home, "debug", (char *) NULL);
 
	// exit(0);
}
//执行sql语句成功返回1，否则返回0 
//并且关闭是否conn，它在init里初始化开始的 
int executesql(const char * sql) {
 
	if (mysql_real_query(conn, sql, strlen(sql))) {
		if (DEBUG)
			write_log("%s", mysql_error(conn));
		sleep(20);
		conn = NULL;
		return 1;
	} else
		return 0;
}
 
int init_mysql() {
	if (conn == NULL) {
		conn = mysql_init(NULL);		// init the database connection
		/* connect the database */
		const char timeout = 30;
		mysql_options(conn, MYSQL_OPT_CONNECT_TIMEOUT, &timeout);
 
		if (!mysql_real_connect(conn, host_name, user_name, password, db_name,
				port_number, 0, 0)) {
			if (DEBUG)
				write_log("%s", mysql_error(conn));
			sleep(2);
			return 1;
		} else {
			return 0;
		}
	} else {
		return executesql("set names utf8");
	}
}
FILE * read_cmd_output(const char * fmt, ...) {
	char cmd[BUFFER_SIZE];
 
	FILE * ret = NULL;
	va_list ap;
 
	va_start(ap, fmt);
	vsprintf(cmd, fmt, ap);
	va_end(ap);
	//if(DEBUG) printf("%s\n",cmd);
	ret = popen(cmd, "r");
 
	return ret;
}
int read_int_http(FILE * f) {
	char buf[BUFFER_SIZE];
	fgets(buf, BUFFER_SIZE - 1, f);
	return atoi(buf);
}
bool check_login() {
	const char * cmd =
			"wget --post-data=\"checklogin=1\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	int ret = 0;
 
	FILE * fjobs = read_cmd_output(cmd, http_baseurl);
	ret = read_int_http(fjobs);
	pclose(fjobs);
 
	return ret > 0;
}
void login() {
	if (!check_login()) {
		char cmd[BUFFER_SIZE];
		sprintf(cmd,
				"wget --post-data=\"user_id=%s&password=%s\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/login.php\"",
				http_username, http_password, http_baseurl);
		system(cmd);
	}
 
}
int _get_jobs_http(int * jobs) {
	login();
	int ret = 0;
	int i = 0;
	char buf[BUFFER_SIZE];
	const char * cmd =
			"wget --post-data=\"getpending=1&oj_lang_set=%s&max_running=%d\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	FILE * fjobs = read_cmd_output(cmd, oj_lang_set, max_running, http_baseurl);
	while (fscanf(fjobs, "%s", buf) != EOF) {
		//puts(buf);
		int sid = atoi(buf);
		if (sid > 0)
			jobs[i++] = sid;
		//i++;
	}
	pclose(fjobs);
	ret = i;
	while (i <= max_running * 2)
		jobs[i++] = 0;
	return ret;
	return ret;
}
//功能：取得待评测题目信息到jobs数组
//输入：int * jobs :保存solution_id/runid
//输出：如果查询成功则返回：要评测题目数量 
//如果查询待判题目不成功则返回0
 
int _get_jobs_mysql(int * jobs) {
	//mysql.h
	//如果查询数据包括二进制或者更快速度 用这个
	//如果执行成功，返回0；不成功非0
	if (mysql_real_query(conn, query, strlen(query))) {
		if (DEBUG)
			write_log("%s", mysql_error(conn));
		sleep(20);
		return 0;
	}
	
	//mysql.h
	//返回具有多个结果的MYSQL_RES结果集合。如果出现错误，返回NULL
	//具体参见百度
	res = mysql_store_result(conn);
	int i = 0;
	int ret = 0;
	//遍历结果集mysql_fetch_row()
	while ((row = mysql_fetch_row(res)) != NULL) {
		jobs[i++] = atoi(row[0]);
	}
	ret = i; //要评测jobs末端 如 0 1 2 有数据，则i=3代表数据
	while (i <= max_running * 2)
		jobs[i++] = 0; //设定的最大工作数目为max_running*2，将0-8置位0共9个 max_running*2+1数组开这么大 
	return ret;
	return ret;
}
int get_jobs(int * jobs) {
	if (http_judge) {	//web和core默认连接方式：数据库，web插入solution,core轮训/更新solution-result，web轮训solution-result
		return _get_jobs_http(jobs);
	} else
		return _get_jobs_mysql(jobs);//读取要判题的任务数量
 
}
 
//更新初始化solution表格
//更新成功返回1；否则0
// 疑问：OJ_CI为2，and result < 2这句怎么都是不成立，这个Sql语句怎么都不会执行成功才对啊 
//用limit 1加了一层保障。避免where 条件出现异常时，错误更新影响太多。 
//不知道php初始写多少，但是调用给的参数为2啊，不懂！！！！ 
bool _check_out_mysql(int solution_id, int result) {
	char sql[BUFFER_SIZE]; //sql语句保存 
	sprintf(sql,
			"UPDATE solution SET result=%d,time=0,memory=0,judgetime=NOW() WHERE solution_id=%d and result<2 LIMIT 1",
			result, solution_id);
//执行sql语句，成功返回0；否则非0 
	if (mysql_real_query(conn, sql, strlen(sql))) {
		syslog(LOG_ERR | LOG_DAEMON, "%s", mysql_error(conn));
		return false;
	} else {
		//影响行数，更新数大于0，执行成功，返回1，否则0 
		if (mysql_affected_rows(conn) > 0ul)
			return true;
		else
			return false;
	}
 
}
 
bool _check_out_http(int solution_id, int result) {
	login();
	const char * cmd =
			"wget --post-data=\"checkout=1&sid=%d&result=%d\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	int ret = 0;
	FILE * fjobs = read_cmd_output(cmd, solution_id, result, http_baseurl);
	fscanf(fjobs, "%d", &ret);
	pclose(fjobs);
 
	return ret;
}
 
//初始更新solution表
//依据参数不同执行不同的更新函数 
bool check_out(int solution_id, int result) {
 
	if (http_judge) {
		return _check_out_http(solution_id, result);
	} else
		return _check_out_mysql(solution_id, result);
 
}
int work() {
//      char buf[1024];
	static int retcnt = 0;//统计 已经 完成评测次数  
	int i = 0;
	static pid_t ID[100];  //short类型的宏定义，进程表中的索引项，进程号；保存正在执行的子进程pid 
	static int workcnt = 0;//统计 现用 judge_client进程数量 
	int runid = 0;			//solution_id，测试运行编号
	int jobs[max_running * 2 + 1];//max_running 从judge.conf获取，一般为4，这里设置为工作目录：9
	pid_t tmp_pid = 0;
 
	//for(i=0;i<max_running;i++){
	//      ID[i]=0;
	//}
 
	//sleep_time=sleep_tmp;
	/* get the database info */
	if (!get_jobs(jobs)) //如果读取失败或者要评测题目数量为0，jobs[]被置为：1001，1002，0，...0；默认9位 
		retcnt = 0;
	/* exec the submit *///遍历评测每个solution_id的题目，只负责把所以题目全部投入到新的评判进程里
	//不管是否评测完成 
	for (int j = 0; jobs[j] > 0; j++) {
		runid = jobs[j]; //读取solution_id，待评测提交题目id 
		//老式并发处理中，默认oj_tot 为 1 oj_mod 为0，在init_sql_conf中设置 所以无用 
		if (runid % oj_tot != oj_mod)  
			continue;
		if (DEBUG) //调试用默认0 无用 
			write_log("Judging solution %d", runid);
		//workcnt 为static 变量，相当于死锁，统计现用run_client进程 数目 
		//本if 等待可用 子进程，并且用 i 腾出保存 新子进程的位置 
		if (workcnt >= max_running) {           // if no more client can running
		    //如果达到了可用最大进程数目，那么等待一个子进程结束
			//waitpid，参考linux 下 c 语言编程下的 进程管理 
			//waitpid()会暂时停止目前进程的执行，直到有信号来到或子进程结束
			//pid_t waitpid(pid_t pid,int * status,int options);
			//pid=-1 代表任意子进程；status 取回子进程识别码，这里不需要所以NULL; 
			//参数options提供了一些额外的选项来控制waitpid，比如不等待继续执行，这里0代表不使用，进程挂起
			//如果 有子进程已经结束，那么执行到这里的时候会直接跳过，子进程也会由僵尸进程释放	
			//返回结束的子进程pid	 
			tmp_pid = waitpid(-1, NULL, 0);     // wait 4 one child exit
			workcnt--;//子进程结束了个，那么现用judge_client数量减一  
			retcnt++;//评测完成数加1 
			//清除保存在 ID[]里的已经结束的子进程信息 
			for (i = 0; i < max_running; i++)     // get the client id
				if (ID[i] == tmp_pid)
					break; // got the client id
			ID[i] = 0;
		} else {                                             // have free client
 
			for (i = 0; i < max_running; i++)     // find the client id
				if (ID[i] == 0)
					break;    // got the client id
		}
		
		//其实这里worknct<max_running 一定成立，除非waitpid()出错 
		//check_out:更新初始化表，但是怎么都不该执行成功才对的啊，为什么还能成功呢
		//如果可以开始新的子进程进行评测 
		if (workcnt < max_running && check_out(runid, OJ_CI)) {
			workcnt++;//正运行子进程数目加1----这里是不是太早了，子进程创建一定能成功？？？？？
						//应该在子进程里更新这个数值吧 
			ID[i] = fork();   //创建子进程 ，将子进程pid返回给父进程，将0返回给子进程  // start to fork
			                //这句写的觉得难理解，父进程会将其更新为新进程pid
							//子进程呢，创建之初会更新为0，那到底是多少？？？？？？？
							//按照程序，子进程会完整复制父进程的代码，数据，堆栈
							//那么如果是父进程在执行那么ID[i] 不为0而是子进程pid
							//如果是子进程的在执行，那么数据段又是ID[i]为0？？？？
							//那static 的作用呢 
			if (ID[i] == 0) {//如果成立，那么代表是在执行子进程代码，执行run_judge_client 
				if (DEBUG)
					write_log("<<=sid=%d===clientid=%d==>>\n", runid, i);
				run_client(runid, i);  //在子进程里更新ID[0]=pid  // if the process is the son, run it
				exit(0);//子进程执行完毕退出0，父进程不会执行这段if ，在run_client里进程会跳转到execl(judge_client)
				        //执行成功不返回，不成功返回非0，保存在erro里，那么这里又是怎么执行到的，子进程如何退出的？？？？？？ 
			}
 
		} else {//理论上，在上个if里已经保证了这里为ID[i] = 0，这里估计是为了进一步保证 
			ID[i] = 0;
		}
	}
 
	//把本次轮训到的代评测题目全部投入评测后 
	//在非挂起等待子进程的结束，如果有子进程评测完成结束 
	//在上个的for里，当可用进程没有的时候，那么就必须等其中一个进程结束，那么才能继续执行，哪怕在for里已经有 
	// 子进程结束是僵尸进程了，只要workcnt<max_running,那么就也不处理子僵尸进程的回收问题，而是优先投入新的子进程
	//进行评测
	//那么子僵尸进程 谁来回收，何时回收，怎么回收，总不能等可用的全成了僵尸进程，在for里用到的时候在进行回收吧 
	//如果可用进程数开的特别大，而一直没有用户提交，那岂不是，运行一段时间后，系统肯定会一直有max_running个进程的
	//资源被占用，而且大大大99%部分都是死的子僵尸进程，for只是用几个收几个，而不管也没法管其他的，因为for只有当
	//有评测任务的时候才会执行到，大部分没有用户提交程序评测的轮询时间段里，不顺手回收下，岂不可惜！！！ 
	 
	//所以就是while()要完成的任务，父进程执行到这里的时候，扫一眼是否有待回收子僵尸进程，有就 顺手回收一个；
	// 因为不知道有多少待回收的，什么时候要回收；所以只且只能在这个轮询时间段里回收一个 
	//这个while，纯粹是顺手牵羊行为，当然也有更新评测完成数量的重要任务~~~ 
	/*
	如果使用了WNOHANG参数调用waitpid，即使没有子进程退出，它也会立即返回，不会像wait那样永远等下去
	1、当正常返回的时候，waitpid返回收集到的子进程的进程ID；
          2、如果设置了选项WNOHANG，而调用中waitpid发现没有已退出的子进程可收集，则返回0；
          3、如果调用中出错，则返回-1，这时errno会被设置成相应的值以指示错误所在；
	*/
	while ((tmp_pid = waitpid(-1, NULL, WNOHANG)) > 0) {
		workcnt--;
		retcnt++;
		for (i = 0; i < max_running; i++)     // get the client id
			if (ID[i] == tmp_pid)
				break; // got the client id
		ID[i] = 0;
		printf("tmp_pid = %d\n", tmp_pid);
	}
	//释放数据库资源 
	//这里commit的调用，不知道是为了关闭conn，还是数据库不支持自动commit
	//还是彻底缩小日志，不给机会rollback，待学习？？？？？？ 
	if (!http_judge) {
		mysql_free_result(res);                         // free the memory
		executesql("commit");
	}
	if (DEBUG && retcnt)
		write_log("<<%ddone!>>", retcnt);
	//free(ID);
	//free(jobs);
	//返回已经评测的次数 
	return retcnt;
}
 
int lockfile(int fd) {
	struct flock fl;
	fl.l_type = F_WRLCK;
	fl.l_start = 0;
	fl.l_whence = SEEK_SET;
	fl.l_len = 0;
	return (fcntl(fd, F_SETLK, &fl));
}
 
int already_running() {
	int fd;
	char buf[16];
	fd = open(LOCKFILE, O_RDWR | O_CREAT, LOCKMODE);
	if (fd < 0) {
		syslog(LOG_ERR | LOG_DAEMON, "can't open %s: %s", LOCKFILE,
				strerror(errno));
		exit(1);
	}
	if (lockfile(fd) < 0) {
		if (errno == EACCES || errno == EAGAIN) {
			close(fd);
			return 1;
		}
		syslog(LOG_ERR | LOG_DAEMON, "can't lock %s: %s", LOCKFILE,
				strerror(errno));
		exit(1);
	}
	ftruncate(fd, 0);
	sprintf(buf, "%d", getpid());
	write(fd, buf, strlen(buf) + 1);
	return (0);
}
int daemon_init(void)
 
{
	pid_t pid;
 
	if ((pid = fork()) < 0)
		return (-1);
 
	else if (pid != 0)
		exit(0); /* parent exit */
 
	/* child continues */
 
	setsid(); /* become session leader */
 
	chdir(oj_home); /* change working directory */
 
	umask(0); /* clear file mode creation mask */
 
	close(0); /* close stdin */
 
	close(1); /* close stdout */
 
	close(2); /* close stderr */
 
	return (0);
}
 
int main(int argc, char** argv) {
	DEBUG = (argc > 2);
	if (argc > 1)
		strcpy(oj_home, argv[1]);
	else
		strcpy(oj_home, "/home/judge");
	chdir(oj_home);    // change the dir
 
	if (!DEBUG)
		daemon_init();//创建一个daemon守护进程 
	if (strcmp(oj_home, "/home/judge") == 0 && already_running()) {
		syslog(LOG_ERR | LOG_DAEMON,
				"This daemon program is already running!\n");
		return 1;
	}
//	struct timespec final_sleep;
//	final_sleep.tv_sec=0;
//	final_sleep.tv_nsec=500000000;
	init_mysql_conf();	// set the database info
	signal(SIGQUIT, call_for_exit);
	signal(SIGKILL, call_for_exit);
	signal(SIGTERM, call_for_exit);
	int j = 1;
	while (1) {			// start to run
		// 这个 while 的好处在于，只要一有任务就抓紧占用系统优先把所以任务处理完成，哪怕会空循环几次的可能存在
		// 但是没有任务后，就会进入到"懒散"的 休息sleep(time)后再轮询是不是有任务，释放系统的资源，避免 Damon 一直死循环占用系统 
		while (j && (http_judge || !init_mysql())) {
 
			j = work();//如果读取失败或者没有要评测的数据，那么返回0，利用那么有限的几个进程来评测无限的任务量 
 
		}
		sleep(sleep_time);
		j = 1;
	}
	return 0;
}
```


### 第二部分

> 读的痛苦又快乐。。。


```c

//
// File:   main.cc
// Author: sempr
// refacted by zhblue
 /*
 * Copyright 2008 sempr <iamsempr@gmail.com>
 *
 * Refacted and modified by zhblue<newsclan@gmail.com>
 * Bug report email newsclan@gmail.com
 *
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
#include <assert.h>
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
#define OJ_TR 13
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
 
//目录分布
//home/judge
 
//home/judge/data
//home/judge/data/1000			题目编号1000 
//home/judge/data/1000/sample.in 样例数据输入 
//home/judge/data/1000/sample.out 样例数据输出 
//home/judge/data/1000/test.in	测试数据输入 
//home/judge/data/1000/test.out	测试数据输出 
 
//home/judge/etc
//home/judge/etc/java0.policy Java编译的配置 
//home/judge/etc/judge.conf 配置文件，core与web为轮询数据库方式下 
 
//home/judge/log 如果启用调试，日志保存目录 
//home/judge/run0	可以启用的调试进程0 -3共4个默认的 也就是max_ruuning 默认值 
//home/judge/run1
//home/judge/run2
//home/judge/run3
 
 
 
static int DEBUG = 0;	//是否启用调试默认否 
static char host_name[BUFFER_SIZE];//主机地址 
static char user_name[BUFFER_SIZE];//用户名 
static char password[BUFFER_SIZE];//密码 
static char db_name[BUFFER_SIZE];//数据库名称 
static char oj_home[BUFFER_SIZE];//盼题目录 默认/home/judge 
static int port_number; //端口 
static int max_running; //最大的进程数 
static int sleep_time;  //轮询时间间隔 
static int java_time_bonus = 5;
static int java_memory_bonus = 512;
static char java_xms[BUFFER_SIZE];
static char java_xmx[BUFFER_SIZE];
static int sim_enable = 0; //是否启用相似度查重 
static int oi_mode = 0; //编译模式 ,在update_solution中用到了 
static int use_max_time = 0; //设置的最大运行时间 
 
static int http_judge = 0; //core与web链接方式，默认，轮询数据库 
static char http_baseurl[BUFFER_SIZE]; 
 
static char http_username[BUFFER_SIZE]; //网络用户名？ 
static char http_password[BUFFER_SIZE];
static int shm_run = 0; //这个事什么意思？？？？ 
 
static char record_call = 0;
 
//static int sleep_tmp;
#define ZOJ_COM
MYSQL *conn; //数据库链接，开始初始化，最终释放资源 
 
static char lang_ext[13][8] = { "c", "cc", "pas", "java", "rb", "sh", "py",
		"php", "pl", "cs", "m", "bas", "scm" }; //测试语言列表 0 c 1 c++ 
//static char buf[BUFFER_SIZE];
 
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
	//      time_t          t = time(NULL);
	//int l;
	sprintf(buffer, "%s/log/client.log", oj_home);
	FILE *fp = fopen(buffer, "a+");
	if (fp == NULL) {
		fprintf(stderr, "openfile error!\n");
		system("pwd");
	}
	va_start(ap, fmt);
	//l = 
	vsprintf(buffer, fmt, ap);
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
 
const int call_array_size = 512;
int call_counter[call_array_size] = { 0 };
static char LANG_NAME[BUFFER_SIZE];
void init_syscalls_limits(int lang) {
	int i;
	memset(call_counter, 0, sizeof(call_counter));
	if (DEBUG)
		write_log("init_call_counter:%d", lang);
	if (record_call) { // C & C++
		for (i = 0; i < call_array_size; i++) {
			call_counter[i] = 0;
		}
	} else if (lang <= 1) { // C & C++
		for (i = 0; i==0||LANG_CV[i]; i++) {
			call_counter[LANG_CV[i]] = HOJ_MAX_LIMIT;
		}
	} else if (lang == 2) { // Pascal
		for (i = 0; i==0||LANG_PV[i]; i++)
			call_counter[LANG_PV[i]] = HOJ_MAX_LIMIT;
	} else if (lang == 3) { // Java
		for (i = 0; i==0||LANG_JV[i]; i++)
			call_counter[LANG_JV[i]] = HOJ_MAX_LIMIT;
	} else if (lang == 4) { // Ruby
		for (i = 0; i==0||LANG_RV[i]; i++)
			call_counter[LANG_RV[i]] = HOJ_MAX_LIMIT;
	} else if (lang == 5) { // Bash
		for (i = 0; i==0||LANG_BV[i]; i++)
			call_counter[LANG_BV[i]] = HOJ_MAX_LIMIT;
	} else if (lang == 6) { // Python
		for (i = 0; i==0||LANG_YV[i]; i++)
			call_counter[LANG_YV[i]] = HOJ_MAX_LIMIT;
	} else if (lang == 7) { // php
		for (i = 0; i==0||LANG_PHV[i]; i++)
			call_counter[LANG_PHV[i]] = HOJ_MAX_LIMIT;
	} else if (lang == 8) { // perl
		for (i = 0; i==0||LANG_PLV[i]; i++)
			call_counter[LANG_PLV[i]] = HOJ_MAX_LIMIT;
	} else if (lang == 9) { // mono c#
		for (i = 0; i==0||LANG_CSV[i]; i++)
			call_counter[LANG_CSV[i]] = HOJ_MAX_LIMIT;
	} else if (lang == 10) { //objective c
		for (i = 0; i==0||LANG_OV[i]; i++)
			call_counter[LANG_OV[i]] = HOJ_MAX_LIMIT;
	} else if (lang == 11) { //free basic
		for (i = 0; i==0||LANG_BASICV[i]; i++)
			call_counter[LANG_BASICV[i]] = HOJ_MAX_LIMIT;
	} else if (lang == 12) { //scheme guile
		for (i = 0; i==0||LANG_SV[i]; i++)
			call_counter[LANG_SV[i]] = HOJ_MAX_LIMIT;
	}
 
}
 
int after_equal(char * c) {
	int i = 0;
	for (; c[i] != '\0' && c[i] != '='; i++)
		;
	return ++i;
}
void trim(char * c) {
	char buf[BUFFER_SIZE];
	char * start, *end;
	strcpy(buf, c);
	start = buf;
	while (isspace(*start))
		start++;
	end = start;
	while (!isspace(*end))
		end++;
	*end = '\0';
	strcpy(c, start);
}
bool read_buf(char * buf, const char * key, char * value) {
	if (strncmp(buf, key, strlen(key)) == 0) {
		strcpy(value, buf + after_equal(buf));
		trim(value);
		if (DEBUG)
			printf("%s\n", value);
		return 1;
	}
	return 0;
}
void read_int(char * buf, const char * key, int * value) {
	char buf2[BUFFER_SIZE];
	if (read_buf(buf, key, buf2))
		sscanf(buf2, "%d", value);
 
}
// read the configue file
void init_mysql_conf() {
	FILE *fp = NULL;
	char buf[BUFFER_SIZE];
	host_name[0] = 0;
	user_name[0] = 0;
	password[0] = 0;
	db_name[0] = 0;
	port_number = 3306;
	max_running = 3;
	sleep_time = 3;
	strcpy(java_xms, "-Xms32m");
	strcpy(java_xmx, "-Xmx256m");
	sprintf(buf, "%s/etc/judge.conf", oj_home);
	fp = fopen("./etc/judge.conf", "r");
	if (fp != NULL) {
		while (fgets(buf, BUFFER_SIZE - 1, fp)) {
			read_buf(buf, "OJ_HOST_NAME", host_name);
			read_buf(buf, "OJ_USER_NAME", user_name);
			read_buf(buf, "OJ_PASSWORD", password);
			read_buf(buf, "OJ_DB_NAME", db_name);
			read_int(buf, "OJ_PORT_NUMBER", &port_number);
			read_int(buf, "OJ_JAVA_TIME_BONUS", &java_time_bonus);
			read_int(buf, "OJ_JAVA_MEMORY_BONUS", &java_memory_bonus);
			read_int(buf, "OJ_SIM_ENABLE", &sim_enable);
			read_buf(buf, "OJ_JAVA_XMS", java_xms);
			read_buf(buf, "OJ_JAVA_XMX", java_xmx);
			read_int(buf, "OJ_HTTP_JUDGE", &http_judge);
			read_buf(buf, "OJ_HTTP_BASEURL", http_baseurl);
			read_buf(buf, "OJ_HTTP_USERNAME", http_username);
			read_buf(buf, "OJ_HTTP_PASSWORD", http_password);
			read_int(buf, "OJ_OI_MODE", &oi_mode);
			read_int(buf, "OJ_SHM_RUN", &shm_run);
			read_int(buf, "OJ_USE_MAX_TIME", &use_max_time);
 
		}
		//fclose(fp);
	}
}
 
//功能：判断是否是输入文件
//输入：/home/judge/data/1000下的文件全名 sample.in sample.out test.in test.out
//输出：如果文件长度<=3或者不是以.in结尾，则返回0；
//      否则返回文件主名长度sample 6 test 4 
int isInFile(const char fname[]) {
	int l = strlen(fname);
	if (l <= 3 || strcmp(fname + l - 3, ".in") != 0)
		return 0;
	else
		return l - 3;//返回文件名长度 sample 6 test 4 
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
			} else if ((c2 == '\r' && c1 == '\n')) {
				c2 = fgetc(f2);
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
const char * getFileNameFromPath(const char * path) {
	for (int i = strlen(path); i >= 0; i--) {
		if (path[i] == '/')
			return &path[i];
	}
	return path;
}
void make_diff_out(FILE *f1, FILE *f2, int c1, int c2, const char * path) {
	FILE *out;
	char buf[45];
	out = fopen("diff.out", "a+");
	fprintf(out, "=================%s\n", getFileNameFromPath(path));
	fprintf(out, "Right:\n%c", c1);
	if (fgets(buf, 44, f1)) {
		fprintf(out, "%s", buf);
	}
	fprintf(out, "\n-----------------\n");
	fprintf(out, "Your:\n%c", c2);
	if (fgets(buf, 44, f2)) {
		fprintf(out, "%s", buf);
	}
	fprintf(out, "\n=================\n");
	fclose(out);
}
 
/*
 * translated from ZOJ judger r367
 * http://code.google.com/p/zoj/source/browse/trunk/judge_client/client/text_checker.cc#25
 *
 */
int compare_zoj(const char *file1, const char *file2) {
	int ret = OJ_AC;
	int c1, c2;
	FILE * f1, *f2;
	f1 = fopen(file1, "r");
	f2 = fopen(file2, "r");
	if (!f1 || !f2) {
		ret = OJ_RE;
	} else
		for (;;) {
			// Find the first non-space character at the beginning of line.
			// Blank lines are skipped.
			c1 = fgetc(f1);
			c2 = fgetc(f2);
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
	end: if (ret == OJ_WA)
		make_diff_out(f1, f2, c1, c2, file1);
	if (f1)
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
 
FILE * read_cmd_output(const char * fmt, ...) {
	char cmd[BUFFER_SIZE];
 
	FILE * ret = NULL;
	va_list ap;
 
	va_start(ap, fmt);
	vsprintf(cmd, fmt, ap);
	va_end(ap);
	if (DEBUG)
		printf("%s\n", cmd);
	ret = popen(cmd, "r");
 
	return ret;
}
bool check_login() {
	const char * cmd =
			" wget --post-data=\"checklogin=1\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	int ret = 0;
	FILE * fjobs = read_cmd_output(cmd, http_baseurl);
	fscanf(fjobs, "%d", &ret);
	pclose(fjobs);
 
	return ret;
}
void login() {
	if (!check_login()) {
		const char * cmd =
				"wget --post-data=\"user_id=%s&password=%s\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/login.php\"";
		FILE * fjobs = read_cmd_output(cmd, http_username, http_password,
				http_baseurl);
		//fscanf(fjobs,"%d",&ret);
		pclose(fjobs);
	}
 
}
/* write result back to database */
void _update_solution_mysql(int solution_id, int result, int time, int memory,
		int sim, int sim_s_id, double pass_rate) {
	char sql[BUFFER_SIZE];
	if (oi_mode) {
		sprintf(sql,
				"UPDATE solution SET result=%d,time=%d,memory=%d,judgetime=NOW(),pass_rate=%f WHERE solution_id=%d LIMIT 1%c",
				result, time, memory, pass_rate, solution_id, 0);
	} else {
		sprintf(sql,
				"UPDATE solution SET result=%d,time=%d,memory=%d,judgetime=NOW() WHERE solution_id=%d LIMIT 1%c",
				result, time, memory, solution_id, 0);
	}
	//      printf("sql= %s\n",sql);
	if (mysql_real_query(conn, sql, strlen(sql))) {
		//              printf("..update failed! %s\n",mysql_error(conn));
	}
	if (sim) {
		sprintf(sql,
				"insert into sim(s_id,sim_s_id,sim) values(%d,%d,%d) on duplicate key update  sim_s_id=%d,sim=%d",
				solution_id, sim_s_id, sim, sim_s_id, sim);
		//      printf("sql= %s\n",sql);
		if (mysql_real_query(conn, sql, strlen(sql))) {
			//              printf("..update failed! %s\n",mysql_error(conn));
		}
 
	}
 
}
void _update_solution_http(int solution_id, int result, int time, int memory,
		int sim, int sim_s_id, double pass_rate) {
	const char * cmd =
			" wget --post-data=\"update_solution=1&sid=%d&result=%d&time=%d&memory=%d&sim=%d&simid=%d&pass_rate=%f\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	FILE * fjobs = read_cmd_output(cmd, solution_id, result, time, memory, sim,
			sim_s_id, pass_rate, http_baseurl);
	//fscanf(fjobs,"%d",&ret);
	pclose(fjobs);
}
void update_solution(int solution_id, int result, int time, int memory, int sim,
		int sim_s_id, double pass_rate) {
	if (result == OJ_TL && memory == 0)
		result = OJ_ML;
	if (http_judge) {
		_update_solution_http(solution_id, result, time, memory, sim, sim_s_id,
				pass_rate);
	} else {
		_update_solution_mysql(solution_id, result, time, memory, sim, sim_s_id,
				pass_rate);
	}
}
/* write compile error message back to database */
void _addceinfo_mysql(int solution_id) {
	char sql[(1 << 16)], *end;
	char ceinfo[(1 << 16)], *cend;
	FILE *fp = fopen("ce.txt", "r");
	snprintf(sql, (1 << 16) - 1, "DELETE FROM compileinfo WHERE solution_id=%d",
			solution_id);
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
	//      printf("%s\n",ceinfo);
	if (mysql_real_query(conn, sql, end - sql))
		printf("%s\n", mysql_error(conn));
	fclose(fp);
}
// urlencoded function copied from http://www.geekhideout.com/urlcode.shtml
/* Converts a hex character to its integer value */
char from_hex(char ch) {
	return isdigit(ch) ? ch - '0' : tolower(ch) - 'a' + 10;
}
 
/* Converts an integer value to its hex character*/
char to_hex(char code) {
	static char hex[] = "0123456789abcdef";
	return hex[code & 15];
}
 
/* Returns a url-encoded version of str */
/* IMPORTANT: be sure to free() the returned string after use */
char *url_encode(char *str) {
	char *pstr = str, *buf = (char *) malloc(strlen(str) * 3 + 1), *pbuf = buf;
	while (*pstr) {
		if (isalnum(*pstr) || *pstr == '-' || *pstr == '_' || *pstr == '.'
				|| *pstr == '~')
			*pbuf++ = *pstr;
		else if (*pstr == ' ')
			*pbuf++ = '+';
		else
			*pbuf++ = '%', *pbuf++ = to_hex(*pstr >> 4), *pbuf++ = to_hex(
					*pstr & 15);
		pstr++;
	}
	*pbuf = '\0';
	return buf;
}
 
void _addceinfo_http(int solution_id) {
 
	char ceinfo[(1 << 16)], *cend;
	char * ceinfo_encode;
	FILE *fp = fopen("ce.txt", "r");
 
	cend = ceinfo;
	while (fgets(cend, 1024, fp)) {
		cend += strlen(cend);
		if (cend - ceinfo > 40000)
			break;
	}
	fclose(fp);
	ceinfo_encode = url_encode(ceinfo);
	FILE * ce = fopen("ce.post", "w");
	fprintf(ce, "addceinfo=1&sid=%d&ceinfo=%s", solution_id, ceinfo_encode);
	fclose(ce);
	free(ceinfo_encode);
 
	const char * cmd =
			" wget --post-file=\"ce.post\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	FILE * fjobs = read_cmd_output(cmd, http_baseurl);
	//fscanf(fjobs,"%d",&ret);
	pclose(fjobs);
 
}
void addceinfo(int solution_id) {
	if (http_judge) {
		_addceinfo_http(solution_id);
	} else {
		_addceinfo_mysql(solution_id);
	}
}
/* write runtime error message back to database */
void _addreinfo_mysql(int solution_id, const char * filename) {
	char sql[(1 << 16)], *end;
	char reinfo[(1 << 16)], *rend;
	FILE *fp = fopen(filename, "r");
	snprintf(sql, (1 << 16) - 1, "DELETE FROM runtimeinfo WHERE solution_id=%d",
			solution_id);
	mysql_real_query(conn, sql, strlen(sql));
	rend = reinfo;
	while (fgets(rend, 1024, fp)) {
		rend += strlen(rend);
		if (rend - reinfo > 40000)
			break;
	}
	rend = 0;
	end = sql;
	strcpy(end, "INSERT INTO runtimeinfo VALUES(");
	end += strlen(sql);
	*end++ = '\'';
	end += sprintf(end, "%d", solution_id);
	*end++ = '\'';
	*end++ = ',';
	*end++ = '\'';
	end += mysql_real_escape_string(conn, end, reinfo, strlen(reinfo));
	*end++ = '\'';
	*end++ = ')';
	*end = 0;
	//      printf("%s\n",ceinfo);
	if (mysql_real_query(conn, sql, end - sql))
		printf("%s\n", mysql_error(conn));
	fclose(fp);
}
 
void _addreinfo_http(int solution_id, const char * filename) {
 
	char reinfo[(1 << 16)], *rend;
	char * reinfo_encode;
	FILE *fp = fopen(filename, "r");
 
	rend = reinfo;
	while (fgets(rend, 1024, fp)) {
		rend += strlen(rend);
		if (rend - reinfo > 40000)
			break;
	}
	fclose(fp);
	reinfo_encode = url_encode(reinfo);
	FILE * re = fopen("re.post", "w");
	fprintf(re, "addreinfo=1&sid=%d&reinfo=%s", solution_id, reinfo_encode);
	fclose(re);
	free(reinfo_encode);
 
	const char * cmd =
			" wget --post-file=\"re.post\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	FILE * fjobs = read_cmd_output(cmd, http_baseurl);
	//fscanf(fjobs,"%d",&ret);
	pclose(fjobs);
 
}
void addreinfo(int solution_id) {
	if (http_judge) {
		_addreinfo_http(solution_id, "error.out");
	} else {
		_addreinfo_mysql(solution_id, "error.out");
	}
}
 
void adddiffinfo(int solution_id) {
 
	if (http_judge) {
		_addreinfo_http(solution_id, "diff.out");
	} else {
		_addreinfo_mysql(solution_id, "diff.out");
	}
}
void addcustomout(int solution_id) {
 
	if (http_judge) {
		_addreinfo_http(solution_id, "user.out");
	} else {
		_addreinfo_mysql(solution_id, "user.out");
	}
}
 
void _update_user_mysql(char * user_id) {
	char sql[BUFFER_SIZE];
	sprintf(sql,
			"UPDATE `users` SET `solved`=(SELECT count(DISTINCT `problem_id`) FROM `solution` WHERE `user_id`=\'%s\' AND `result`=\'4\') WHERE `user_id`=\'%s\'",
			user_id, user_id);
	if (mysql_real_query(conn, sql, strlen(sql)))
		write_log(mysql_error(conn));
	sprintf(sql,
			"UPDATE `users` SET `submit`=(SELECT count(*) FROM `solution` WHERE `user_id`=\'%s\') WHERE `user_id`=\'%s\'",
			user_id, user_id);
	if (mysql_real_query(conn, sql, strlen(sql)))
		write_log(mysql_error(conn));
}
void _update_user_http(char * user_id) {
 
	const char * cmd =
			" wget --post-data=\"updateuser=1&user_id=%s\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	FILE * fjobs = read_cmd_output(cmd, user_id, http_baseurl);
	//fscanf(fjobs,"%d",&ret);
	pclose(fjobs);
}
void update_user(char * user_id) {
	if (http_judge) {
		_update_user_http(user_id);
	} else {
		_update_user_mysql(user_id);
	}
}
 
void _update_problem_http(int pid) {
	const char * cmd =
			" wget --post-data=\"updateproblem=1&pid=%d\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	FILE * fjobs = read_cmd_output(cmd, pid, http_baseurl);
	//fscanf(fjobs,"%d",&ret);
	pclose(fjobs);
}
void _update_problem_mysql(int p_id) {
	char sql[BUFFER_SIZE];
	sprintf(sql,
			"UPDATE `problem` SET `accepted`=(SELECT count(*) FROM `solution` WHERE `problem_id`=\'%d\' AND `result`=\'4\') WHERE `problem_id`=\'%d\'",
			p_id, p_id);
	if (mysql_real_query(conn, sql, strlen(sql)))
		write_log(mysql_error(conn));
	sprintf(sql,
			"UPDATE `problem` SET `submit`=(SELECT count(*) FROM `solution` WHERE `problem_id`=\'%d\') WHERE `problem_id`=\'%d\'",
			p_id, p_id);
	if (mysql_real_query(conn, sql, strlen(sql)))
		write_log(mysql_error(conn));
}
void update_problem(int pid) {
	if (http_judge) {
		_update_problem_http(pid);
	} else {
		_update_problem_mysql(pid);
	}
}
 
 
//核心源码之一，编译程序
//输入：程序语言类型编码lang 
//返回值：编译成功返回0；失败返回ce.txt文件大小 
int compile(int lang) {
	int pid;
	//设置编译命令 
	const char * CP_C[] = { "gcc", "Main.c", "-o", "Main", "-fno-asm", "-Wall",
			"-lm", "--static", "-std=c99", "-DONLINE_JUDGE", NULL };
	const char * CP_X[] = { "g++", "Main.cc", "-o", "Main", "-fno-asm", "-Wall",
			"-lm", "--static", "-std=c++0x", "-DONLINE_JUDGE", NULL };
	const char * CP_P[] =
			{ "fpc", "Main.pas", "-O2", "-Co", "-Ct", "-Ci", NULL };
//      const char * CP_J[] = { "javac", "-J-Xms32m", "-J-Xmx256m","-encoding","UTF-8", "Main.java",NULL };
 
	const char * CP_R[] = { "ruby", "-c", "Main.rb", NULL };
	const char * CP_B[] = { "chmod", "+rx", "Main.sh", NULL };
	const char * CP_Y[] = { "python", "-c",
			"import py_compile; py_compile.compile(r'Main.py')", NULL };
	const char * CP_PH[] = { "php", "-l", "Main.php", NULL };
	const char * CP_PL[] = { "perl", "-c", "Main.pl", NULL };
	const char * CP_CS[] = { "gmcs", "-warn:0", "Main.cs", NULL };
	const char * CP_OC[] = { "gcc", "-o", "Main", "Main.m",
			"-fconstant-string-class=NSConstantString", "-I",
			"/usr/include/GNUstep/", "-L", "/usr/lib/GNUstep/Libraries/",
			"-lobjc", "-lgnustep-base", NULL };
	const char * CP_BS[] = { "fbc", "Main.bas", NULL };
	char javac_buf[7][16];
	char *CP_J[7];
 
	for (int i = 0; i < 7; i++)
		CP_J[i] = javac_buf[i];
 
	sprintf(CP_J[0], "javac");
	sprintf(CP_J[1], "-J%s", java_xms);
	sprintf(CP_J[2], "-J%s", java_xmx);
	sprintf(CP_J[3], "-encoding");
	sprintf(CP_J[4], "UTF-8");
	sprintf(CP_J[5], "Main.java");
	CP_J[6] = (char *) NULL;
 
	//判题进程中又创建子进程	 
	pid = fork();
	if (pid == 0) {//如果是子进程在运行
	//设置运行资源限制 
		struct rlimit LIM;
		LIM.rlim_max = 60;
		LIM.rlim_cur = 60;
		setrlimit(RLIMIT_CPU, &LIM);
		alarm(60);
		LIM.rlim_max = 100 * STD_MB;
		LIM.rlim_cur = 100 * STD_MB;
		setrlimit(RLIMIT_FSIZE, &LIM);
 
		if(lang==3){
		   LIM.rlim_max = STD_MB << 11;
		   LIM.rlim_cur = STD_MB << 11;	
                }else{
		   LIM.rlim_max = STD_MB << 10;
		   LIM.rlim_cur = STD_MB << 10;
		}
		setrlimit(RLIMIT_AS, &LIM);
		//实现重定向，把预定义的标准流文件定向到由path指定的文件中。
		//标准流文件具体是指stdin、stdout和stderr 
		if (lang != 2 && lang != 11) {//不是pas也不是bas
			freopen("ce.txt", "w", stderr);
			//freopen("/dev/null", "w", stdout);
		} else {//如果是bas或者pas,那么编译信息输出重定向到ce.txt  
			freopen("ce.txt", "w", stdout);
		}
		//将/home/judge/run0下所有文件拥有者改为判题用户judge可能为了安全考虑？？？？？？ 
		/*	
		可以这样使用 stuid() 函数：
开始时，某个程序需要 root 权限玩成一些工作，但后续的工作不需要 root 权限。
可以将该可执行程序文件设置 set_uid 位，并使得该文件的属主为 root。
这样，普通用户执行这个程序时，进程就具有了 root 权限，当不再需要 root 权限时，
调用 setuid( getuid() ) 恢复进程的实际用户 ID 和有效用户 ID 为执行该程序的普通用户的 ID 。
对于一些提供网络服务的程序，这样做是非常有必要的，否则就可能被攻击者利用，使攻击者控制整个系统。
对于设置了 set_uid 位的可执行程序也要注意，尤其是对那些属主是 root 的更要注意。因为 Linux 系统中 
root 用户拥有最高权力。黑客们往往喜欢寻找设置了 set_uid 位的可执行程序的漏洞。这样的程序如果存在缓冲区溢出
漏洞，并且该程序是一个网络程序，那么黑客就可以从远程的地方轻松地利用该漏洞获得运行该漏洞程序的主机的 root
 权限。即使这样的成不是网络程序，那么也可以使本机上的恶意普通用户提升为 root 权限。
 		*/ 
		execute_cmd("chown judge *");
		while(setgid(1536)!=0) sleep(1);
        while(setuid(1536)!=0) sleep(1);
        while(setresuid(1536, 1536, 1536)!=0) sleep(1);
 
		//执行编译命令，并且输出到ce.txt中
		//默认c:0-c++:1 
		/*
		execvp()会从PATH 环境变量所指的目录中查找符合参数file 的文件名，找到后便执行该文件，
		然后将第二个参数argv传给该欲执行的文件。
		返回值：如果执行成功则函数不会返回，执行失败则直接返回-1，失败原因存于errno中。
		*/
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
		case 7:
			execvp(CP_PH[0], (char * const *) CP_PH);
			break;
		case 8:
			execvp(CP_PL[0], (char * const *) CP_PL);
			break;
		case 9:
			execvp(CP_CS[0], (char * const *) CP_CS);
			break;
 
		case 10:
			execvp(CP_OC[0], (char * const *) CP_OC);
			break;
		case 11:
			execvp(CP_BS[0], (char * const *) CP_BS);
			break;
		default:
			printf("nothing to do!\n");
		}
		//如果调试，在这里输出编译信息，
		if (DEBUG)
			printf("compile end!\n");
		
		//并终止编译子进程的执行 ，这里提供了两种返回父进程的方式
		//一种是查看ce文件，是否进行分析？？？？
		//另一种是直接exit(0);这里可能默认编译子进程一定成功？？？？？ 
		//exit(!system("cat ce.txt"));		
		exit(0);
	} else {//父进程，等待编译子进程的执行 结束，正常结束带回0，为什么采取这种形式？？？难道是不知道什么时候
	//编译结束？？？？不知道什么时候去读取ce.txt进行解析？？？所以采用父子进程的方式？？？ 
	//如果子进程编译有语法错误，那么会写入ce.txt，如果ce.txt为0，并且是Exit(0)，代表子进程正常退出，编译成功 
		int status = 0;
		//一直等，直到编译子进程结束 
		waitpid(pid, &status, 0);
		if (lang > 3 && lang < 7)//"rb", "sh", "py"这三种语言状态特殊？？？？ 
			status = get_file_size("ce.txt"); //那c如果有错误写入ce.txt呢？？？？ 
		if (DEBUG)
			printf("status=%d\n", status);
		return status;//默认返回0 
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
 
//根据情况读取待评测程序源码
//并在默认目录work_dir : /home/judge/run0下建立 Main.c 
void _get_solution_mysql(int solution_id, char * work_dir, int lang) {
	char sql[BUFFER_SIZE], src_pth[BUFFER_SIZE];
	// get the source code
	MYSQL_RES *res;
	MYSQL_ROW row;
	sprintf(sql, "SELECT source FROM source_code WHERE solution_id=%d",
			solution_id);
	mysql_real_query(conn, sql, strlen(sql));
	res = mysql_store_result(conn);
	row = mysql_fetch_row(res);
 
	// create the src file
	sprintf(src_pth, "Main.%s", lang_ext[lang]);
	if (DEBUG)
		printf("Main=%s", src_pth);
	FILE *fp_src = fopen(src_pth, "w");
	fprintf(fp_src, "%s", row[0]);
	mysql_free_result(res);
	fclose(fp_src);
}
void _get_solution_http(int solution_id, char * work_dir, int lang) {
	char src_pth[BUFFER_SIZE];
 
	// create the src file
	sprintf(src_pth, "Main.%s", lang_ext[lang]);
	if (DEBUG)
		printf("Main=%s", src_pth);
 
	//login();
 
	const char * cmd2 =
			"wget --post-data=\"getsolution=1&sid=%d\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O %s \"%s/admin/problem_judge.php\"";
	FILE * pout = read_cmd_output(cmd2, solution_id, src_pth, http_baseurl);
 
	pclose(pout);
 
}
void get_solution(int solution_id, char * work_dir, int lang) {
	if (http_judge) {
		_get_solution_http(solution_id, work_dir, lang);
	} else {
		_get_solution_mysql(solution_id, work_dir, lang);
	}
 
}
 
void _get_custominput_mysql(int solution_id, char * work_dir) {
	char sql[BUFFER_SIZE], src_pth[BUFFER_SIZE];
	// get the source code
	MYSQL_RES *res;
	MYSQL_ROW row;
	sprintf(sql, "SELECT input_text FROM custominput WHERE solution_id=%d",
			solution_id);
	mysql_real_query(conn, sql, strlen(sql));
	res = mysql_store_result(conn);
	row = mysql_fetch_row(res);
	if (row != NULL) {
 
		// create the src file
		sprintf(src_pth, "data.in");
		FILE *fp_src = fopen(src_pth, "w");
		fprintf(fp_src, "%s", row[0]);
		fclose(fp_src);
 
	}
	mysql_free_result(res);
}
void _get_custominput_http(int solution_id, char * work_dir) {
	char src_pth[BUFFER_SIZE];
 
	// create the src file
	sprintf(src_pth, "data.in");
 
	//login();
 
	const char * cmd2 =
			"wget --post-data=\"getcustominput=1&sid=%d\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O %s \"%s/admin/problem_judge.php\"";
	FILE * pout = read_cmd_output(cmd2, solution_id, src_pth, http_baseurl);
 
	pclose(pout);
 
}
void get_custominput(int solution_id, char * work_dir) {
	if (http_judge) {
		_get_custominput_http(solution_id, work_dir);
	} else {
		_get_custominput_mysql(solution_id, work_dir);
	}
}
 
void _get_solution_info_mysql(int solution_id, int & p_id, char * user_id,
		int & lang) {
 
	MYSQL_RES *res;
	MYSQL_ROW row;
 
	char sql[BUFFER_SIZE];
	// get the problem id and user id from Table:solution
	sprintf(sql,
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
 
void _get_solution_info_http(int solution_id, int & p_id, char * user_id,
		int & lang) {
 
	login();
 
	const char * cmd =
			"wget --post-data=\"getsolutioninfo=1&sid=%d\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	FILE * pout = read_cmd_output(cmd, solution_id, http_baseurl);
	fscanf(pout, "%d", &p_id);
	fscanf(pout, "%s", user_id);
	fscanf(pout, "%d", &lang);
	pclose(pout);
 
}
void get_solution_info(int solution_id, int & p_id, char * user_id,
		int & lang) {
 
	if (http_judge) {
		_get_solution_info_http(solution_id, p_id, user_id, lang);
	} else {
		_get_solution_info_mysql(solution_id, p_id, user_id, lang);
	}
}
 
void _get_problem_info_mysql(int p_id, int & time_lmt, int & mem_lmt,
		int & isspj) {
	// get the problem info from Table:problem
	char sql[BUFFER_SIZE];
	MYSQL_RES *res;
	MYSQL_ROW row;
	sprintf(sql,
			"SELECT time_limit,memory_limit,spj FROM problem where problem_id=%d",
			p_id);
	mysql_real_query(conn, sql, strlen(sql));
	res = mysql_store_result(conn);
	row = mysql_fetch_row(res);
	time_lmt = atoi(row[0]);
	mem_lmt = atoi(row[1]);
	isspj = (row[2][0] == '1');
	mysql_free_result(res);
}
 
void _get_problem_info_http(int p_id, int & time_lmt, int & mem_lmt,
		int & isspj) {
	//login();
 
	const char * cmd =
			"wget --post-data=\"getprobleminfo=1&pid=%d\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	FILE * pout = read_cmd_output(cmd, p_id, http_baseurl);
	fscanf(pout, "%d", &time_lmt);
	fscanf(pout, "%d", &mem_lmt);
	fscanf(pout, "%d", &isspj);
	pclose(pout);
}
 
void get_problem_info(int p_id, int & time_lmt, int & mem_lmt, int & isspj) {
	if (http_judge) {
		_get_problem_info_http(p_id, time_lmt, mem_lmt, isspj);
	} else {
		_get_problem_info_mysql(p_id, time_lmt, mem_lmt, isspj);
	}
}
 
/*
功能：
	1、把评测的输入数据复制到/home/judge/run0/data.in
	2、给outfile 赋值； /home/judge/data/1000/fname.out
	3、给userfile 赋值： /home/judge/ruun0/user.out 
输入：
	filename: 输入数据文件名称 不包括扩展名.in 如sample / test
	namelen:  输入数据文件主名长度 sample:6 test:4
	infile : char * infile[] 在main()中定义，保存完整测试数据路径：/home/judge/data/1000/sample.in 或 /home/judge/data/1000/test.in
	p_id   : 问题编号
	work_dir: 默认的评测进程路径 /home/judge/run0
	outfile: char * outfile[] 在main()中定义，保存完整正确结果数据路径：/home/judge/data/1000/ sample.out或/home/judge/data/1000/test.out
	userfile:char* userfile[] 在main()中定义，保存完整 用户程序结果数据路径：/home/judge/run0/user.out
	runner_id: 判题进程编号run0 run1 run2 run3 取值0-max_running-1 
	 
输出：
    无 
注释：
    2014-11-4 17:00 by ghf in HNSSYZX ZhengZhou  
*/ 
/*
在 int main()中调用： 
prepare_files(dirp->d_name, namelen, infile, p_id, work_dir, outfile,
				userfile, runner_id);
*/
void prepare_files(char * filename, int namelen, char * infile, int & p_id,
		char * work_dir, char * outfile, char * userfile, int runner_id) {
	//              printf("ACflg=%d %d check a file!\n",ACflg,solution_id);
 
	char fname[BUFFER_SIZE];
	strncpy(fname, filename, namelen);//保存测试数据主名 
	fname[namelen] = 0;//c字符串末尾\0结尾 
	sprintf(infile, "%s/data/%d/%s.in", oj_home, p_id, fname);//测试数据完整路径 
	execute_cmd("/bin/cp %s %s/data.in", infile, work_dir);//复制测试数据到run0目录下 
	execute_cmd("/bin/cp %s/data/%d/*.dic %s/", oj_home, p_id, work_dir);//dic数据复制？？？？ 
 
	sprintf(outfile, "%s/data/%d/%s.out", oj_home, p_id, fname);
	sprintf(userfile, "%s/run%d/user.out", oj_home, runner_id);
}
 
void copy_shell_runtime(char * work_dir) {
 
	execute_cmd("/bin/mkdir %s/lib", work_dir);
	execute_cmd("/bin/mkdir %s/lib64", work_dir);
	execute_cmd("/bin/mkdir %s/bin", work_dir);
	execute_cmd("/bin/cp /lib/* %s/lib/", work_dir);
	execute_cmd("/bin/cp -a /lib/i386-linux-gnu %s/lib/", work_dir);
	execute_cmd("/bin/cp -a /lib/x86_64-linux-gnu %s/lib/", work_dir);
	execute_cmd("/bin/cp /lib64/* %s/lib64/", work_dir);
	execute_cmd("/bin/cp -a /lib32 %s/", work_dir);
	execute_cmd("/bin/cp /bin/busybox %s/bin/", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/sh", work_dir);
	execute_cmd("/bin/cp /bin/bash %s/bin/bash", work_dir);
 
}
void copy_objc_runtime(char * work_dir) {
	copy_shell_runtime(work_dir);
	execute_cmd("/bin/mkdir -p %s/proc", work_dir);
	execute_cmd("/bin/mount -o bind /proc %s/proc", work_dir);
	execute_cmd("/bin/mkdir -p %s/lib/", work_dir);
	execute_cmd(
			"/bin/cp -aL /lib/libdbus-1.so.3                          %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /lib/libgcc_s.so.1                           %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /lib/libgcrypt.so.11                         %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /lib/libgpg-error.so.0                       %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /lib/libz.so.1                               %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /lib/tls/i686/cmov/libc.so.6                 %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /lib/tls/i686/cmov/libdl.so.2                %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /lib/tls/i686/cmov/libm.so.6                 %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /lib/tls/i686/cmov/libnsl.so.1               %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /lib/tls/i686/cmov/libpthread.so.0           %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /lib/tls/i686/cmov/librt.so.1                %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /usr/lib/libavahi-client.so.3                %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /usr/lib/libavahi-common.so.3                %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /usr/lib/libdns_sd.so.1                      %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /usr/lib/libffi.so.5                         %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /usr/lib/libgnustep-base.so.1.19             %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /usr/lib/libgnutls.so.26                     %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /usr/lib/libobjc.so.2                        %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /usr/lib/libtasn1.so.3                       %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /usr/lib/libxml2.so.2                        %s/lib/ ",
			work_dir);
	execute_cmd(
			"/bin/cp -aL /usr/lib/libxslt.so.1                        %s/lib/ ",
			work_dir);
 
}
void copy_bash_runtime(char * work_dir) {
	//char cmd[BUFFER_SIZE];
	//const char * ruby_run="/usr/bin/ruby";
	copy_shell_runtime(work_dir);
	execute_cmd("/bin/cp `which bc`  %s/bin/", work_dir);
	execute_cmd("busybox dos2unix Main.sh", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/grep", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/awk", work_dir);
	execute_cmd("/bin/cp /bin/sed %s/bin/sed", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/cut", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/sort", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/join", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/wc", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/tr", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/dc", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/dd", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/cat", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/tail", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/head", work_dir);
	execute_cmd("/bin/ln -s /bin/busybox %s/bin/xargs", work_dir);
	execute_cmd("chmod +rx %s/Main.sh", work_dir);
 
}
void copy_ruby_runtime(char * work_dir) {
 
	copy_shell_runtime(work_dir);
	execute_cmd("/bin/mkdir %s/usr", work_dir);
	execute_cmd("/bin/mkdir %s/usr/lib", work_dir);
	execute_cmd("/bin/cp /usr/lib/libruby* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp -a /usr/lib/ruby %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/bin/ruby* %s/", work_dir);
 
}
void copy_guile_runtime(char * work_dir) {
 
	copy_shell_runtime(work_dir);
	execute_cmd("/bin/mkdir -p %s/proc", work_dir);
	execute_cmd("/bin/mount -o bind /proc %s/proc", work_dir);
	execute_cmd("/bin/mkdir -p %s/usr/lib", work_dir);
	execute_cmd("/bin/mkdir -p %s/usr/share", work_dir);
	execute_cmd("/bin/cp -a /usr/share/guile %s/usr/share/", work_dir);
	execute_cmd("/bin/cp /usr/lib/libguile* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/libgc* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/i386-linux-gnu/libffi* %s/usr/lib/",
			work_dir);
	execute_cmd("/bin/cp /usr/lib/i386-linux-gnu/libunistring* %s/usr/lib/",
			work_dir);
	execute_cmd("/bin/cp /usr/lib/*/libgmp* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/libgmp* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/*/libltdl* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/libltdl* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/bin/guile* %s/", work_dir);
 
}
 
void copy_python_runtime(char * work_dir) {
 
	copy_shell_runtime(work_dir);
	execute_cmd("/bin/mkdir -p %s/usr/include", work_dir);
	execute_cmd("/bin/mkdir -p %s/usr/lib", work_dir);
	execute_cmd("/bin/cp /usr/bin/python* %s/", work_dir);
	execute_cmd("/bin/cp -a /usr/lib/python* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp -a /usr/include/python* %s/usr/include/", work_dir);
	execute_cmd("/bin/cp -a /usr/lib/libpython* %s/usr/lib/", work_dir);
 
}
void copy_php_runtime(char * work_dir) {
 
	copy_shell_runtime(work_dir);
	execute_cmd("/bin/mkdir %s/usr", work_dir);
	execute_cmd("/bin/mkdir %s/usr/lib", work_dir);
	execute_cmd("/bin/cp /usr/lib/libedit* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/libdb* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/libgssapi_krb5* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/libkrb5* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/libk5crypto* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/*/libedit* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/*/libdb* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/*/libgssapi_krb5* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/*/libkrb5* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/*/libk5crypto* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/libxml2* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/lib/x86_64-linux-gnu/libxml2.so* %s/usr/lib/",
			work_dir);
	execute_cmd("/bin/cp /usr/bin/php* %s/", work_dir);
	execute_cmd("chmod +rx %s/Main.php", work_dir);
 
}
void copy_perl_runtime(char * work_dir) {
 
	copy_shell_runtime(work_dir);
	execute_cmd("/bin/mkdir %s/usr", work_dir);
	execute_cmd("/bin/mkdir %s/usr/lib", work_dir);
	execute_cmd("/bin/cp /usr/lib/libperl* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /usr/bin/perl* %s/", work_dir);
 
}
void copy_freebasic_runtime(char * work_dir) {
 
	copy_shell_runtime(work_dir);
	execute_cmd("/bin/mkdir -p %s/usr/local/lib", work_dir);
	execute_cmd("/bin/mkdir -p %s/usr/local/bin", work_dir);
	execute_cmd("/bin/cp /usr/local/lib/freebasic %s/usr/local/lib/", work_dir);
	execute_cmd("/bin/cp /usr/local/bin/fbc %s/", work_dir);
	execute_cmd("/bin/cp -a /lib32/* %s/lib/", work_dir);
 
}
void copy_mono_runtime(char * work_dir) {
 
	copy_shell_runtime(work_dir);
	execute_cmd("/bin/mkdir %s/usr", work_dir);
	execute_cmd("/bin/mkdir %s/proc", work_dir);
	execute_cmd("/bin/mkdir -p %s/usr/lib/mono/2.0", work_dir);
	execute_cmd("/bin/cp -a /usr/lib/mono %s/usr/lib/", work_dir);
	execute_cmd("/bin/mkdir -p %s/usr/lib64/mono/2.0", work_dir);
	execute_cmd("/bin/cp -a /usr/lib64/mono %s/usr/lib64/", work_dir);
 
	execute_cmd("/bin/cp /usr/lib/libgthread* %s/usr/lib/", work_dir);
 
	execute_cmd("/bin/mount -o bind /proc %s/proc", work_dir);
	execute_cmd("/bin/cp /usr/bin/mono* %s/", work_dir);
 
	execute_cmd("/bin/cp /usr/lib/libgthread* %s/usr/lib/", work_dir);
	execute_cmd("/bin/cp /lib/libglib* %s/lib/", work_dir);
	execute_cmd("/bin/cp /lib/tls/i686/cmov/lib* %s/lib/tls/i686/cmov/",
			work_dir);
	execute_cmd("/bin/cp /lib/libpcre* %s/lib/", work_dir);
	execute_cmd("/bin/cp /lib/ld-linux* %s/lib/", work_dir);
	execute_cmd("/bin/cp /lib64/ld-linux* %s/lib64/", work_dir);
	execute_cmd("/bin/mkdir -p %s/home/judge", work_dir);
	execute_cmd("/bin/chown judge %s/home/judge", work_dir);
	execute_cmd("/bin/mkdir -p %s/etc", work_dir);
	execute_cmd("/bin/grep judge /etc/passwd>%s/etc/passwd", work_dir);
 
}
 
 
/*
功能：
	1、设置资源限制，运行时间、内存
	2、设定子进程运行用户
	3、修改子进程运行根目录 / 为 run0/
	4、重定向标准输入输出为文档
	5、执行程序，生成结果 
输入：
    lang:       程序语言类型编码 c:0 c++:1
	work_dir:   判题进程工作目录：/home/judge/runn0,为当前默认目录
	time_lmt:   时间限制
	used_time:  运行时间
	mem_lmt:    运行内存限制 
输出：
    无 
调用：
    在main()中创建新的执行子进程中调用 
    run_solution(lang, work_dir, time_lmt, usedtime, mem_lmt);
注释： 2014-11-4 17:30 by ghf in HNSSYZX ZhengZhou 
*/
void run_solution(int & lang, char * work_dir, int & time_lmt, int & usedtime,
		int & mem_lmt) {
	/*
	在当前程序运行优先级基础之上调整指定值得到新的程序运行优先级，
	用新的程序运行优先级运行命令行"command [arguments...]"。优先级的范围为-20 ～ 19 等40个等级，
	其中数值越小优先级越高，数值越大优先级越低，既-20的优先级最高， 19的优先级最低。
	若调整后的程序运行优先级高于-20，则就以优先级-20来运行命令行；若调整后的程序运行优先级低于19，
	则就以优先级19来运行命令行。若 nice命令未指定优先级的调整值，则以缺省值10来调整程序运行优先级，
	既在当前程序运行优先级基础之上增加10。
	
	调低运行级，基本用户都能执行成功，将这个执行子进程的优先级降到最低，为了安全？？？？？？？？？ 
	*/
	nice(19);
	// now the user is "judger"
	//这时的工作目录分布： 
	///home/judge/run0/data.in
	///home/judge/run0/Main.exe
	///home/judge/run0/ce.txt
	///home/judge/run0/main.c
	///home/judge/run0/user.out
	///home/judge/run0/error.out
	chdir(work_dir);
	// open the files
	//使输入输出重定向到文件里，方便最后的评判 
	freopen("data.in", "r", stdin);
	freopen("user.out", "w", stdout);
	freopen("error.out", "a+", stderr);
	// trace me
	/*
	ptrace系统函数。 ptrace提供了一种使父进程得以监视和控制其它进程的方式，
	它还能够改变子进程中的寄存器和内核映像，因而可以实现断点调试和系统调用的跟踪。
	使用ptrace，你可以在用户层拦截和修改系统调用(sys call).
    形式：ptrace(PTRACE_TRACEME,0 ,0 ,0)
    描述：本进程被其父进程所跟踪。其父进程应该希望跟踪子进程。
	*/
	ptrace(PTRACE_TRACEME, 0, NULL, NULL);
	// run me	
	/*
	chroot是内核中的一个系统调用，软件可以通过调用库函数chroot，来更改某个进程所能见到的根目录
	1.限制CHROOT环境下的使用者所能行的程式，如SetUid的程式，或是造成 Load 的 Compiler等等
2.防止使用者存取某些特定档案及配置文件，如/etc/passwd
3.防止入侵者/bin/rm -rf /
4.提供Guest服务及限制不守规矩的使用者。
5.增强系系统的安全。 
安全机制？？？？？？？？？？？？？？？？？
可是chroot 需要root权限运行啊，不是已经将该进程权限降低的最低的19了啊 ？？？？？？？？？？？？？？？？ 
	*/
	if (lang != 3) //如果不是java 
		chroot(work_dir);
/*
？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？ 
这附近的代码涉及到的用户角色和权限的转换不是很理解，判题进程创建的执行子进程，难道有root权限？？？
这里又把权限设置到了judge用户1536 
 ？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？？ 
*/
	while (setgid(1536) != 0)
		sleep(1);
	while (setuid(1536) != 0)
		sleep(1);
	while (setresuid(1536, 1536, 1536) != 0)
		sleep(1);
 
//      char java_p1[BUFFER_SIZE], java_p2[BUFFER_SIZE];
	// child
	// set the limit
	struct rlimit LIM; // time limit, file limit& memory limit
	// time limit
	//难道oi_mode是秒和毫秒的区别？？？？？？？？？？？？？？？？ 
	//看不懂什么意思 
	
	//设置运行时间、内存限制 
	if (oi_mode)
		LIM.rlim_cur = time_lmt + 1;
	else
		LIM.rlim_cur = (time_lmt - usedtime / 1000) + 1;
	LIM.rlim_max = LIM.rlim_cur;
	//if(DEBUG) printf("LIM_CPU=%d",(int)(LIM.rlim_cur));
	setrlimit(RLIMIT_CPU, &LIM);
	alarm(0);
	alarm(time_lmt * 10);
 
	// file limit
	LIM.rlim_max = STD_F_LIM + STD_MB;
	LIM.rlim_cur = STD_F_LIM;
	setrlimit(RLIMIT_FSIZE, &LIM);
	// proc limit
	switch (lang) {
	case 3:  //java
	case 12:
		LIM.rlim_cur = LIM.rlim_max = 50;
		break;
	case 5: //bash
		LIM.rlim_cur = LIM.rlim_max = 3;
		break;
	case 9: //C#
		LIM.rlim_cur = LIM.rlim_max = 50;
		break;
	default:
		LIM.rlim_cur = LIM.rlim_max = 1;
	}
 
	setrlimit(RLIMIT_NPROC, &LIM);
 
	// set the stack
	LIM.rlim_cur = STD_MB << 6;
	LIM.rlim_max = STD_MB << 6;
	setrlimit(RLIMIT_STACK, &LIM);
	// set the memory
	LIM.rlim_cur = STD_MB * mem_lmt / 2 * 3;
	LIM.rlim_max = STD_MB * mem_lmt * 2;
	if (lang < 3)
		setrlimit(RLIMIT_AS, &LIM);
 
	//开始真正的执行
	 
	switch (lang) {
	case 0:
	case 1:
	case 2:
	case 10:
	case 11:
		execl("./Main", "./Main", (char *) NULL);//因为已经chroot(/home/judge/run0所以可以./Main) 
		break;
	case 3:
//              sprintf(java_p1, "-Xms%dM", mem_lmt / 2);
//              sprintf(java_p2, "-Xmx%dM", mem_lmt);
 
		execl("/usr/bin/java", "/usr/bin/java", java_xms, java_xmx,
				"-Djava.security.manager",
				"-Djava.security.policy=./java.policy", "Main", (char *) NULL);
		break;
	case 4:
		//system("/ruby Main.rb<data.in");
		execl("/ruby", "/ruby", "Main.rb", (char *) NULL);
		break;
	case 5: //bash
		execl("/bin/bash", "/bin/bash", "Main.sh", (char *) NULL);
		break;
	case 6: //Python
		execl("/python", "/python", "Main.py", (char *) NULL);
		break;
	case 7: //php
		execl("/php", "/php", "Main.php", (char *) NULL);
		break;
	case 8: //perl
		execl("/perl", "/perl", "Main.pl", (char *) NULL);
		break;
	case 9: //Mono C#
		execl("/mono", "/mono", "--debug", "Main.exe", (char *) NULL);
		break;
	case 12: //guile
		execl("/guile", "/guile", "Main.scm", (char *) NULL);
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
	comp_res = execute_cmd("/bin/grep 'Exception'  %s/error.out", work_dir);
	if (!comp_res) {
		printf("Exception reported\n");
		ACflg = OJ_RE;
	}
 
	comp_res = execute_cmd(
			"/bin/grep 'java.lang.OutOfMemoryError'  %s/error.out", work_dir);
 
	if (!comp_res) {
		printf("JVM need more Memory!");
		ACflg = OJ_ML;
		topmemory = mem_lmt * STD_MB;
	}
	comp_res = execute_cmd(
			"/bin/grep 'java.lang.OutOfMemoryError'  %s/user.out", work_dir);
 
	if (!comp_res) {
		printf("JVM need more Memory or Threads!");
		ACflg = OJ_ML;
		topmemory = mem_lmt * STD_MB;
	}
	comp_res = execute_cmd("/bin/grep 'Could not create'  %s/error.out",
			work_dir);
	if (!comp_res) {
		printf("jvm need more resource,tweak -Xmx(OJ_JAVA_BONUS) Settings");
		ACflg = OJ_RE;
		//topmemory=0;
	}
	return comp_res;
}
int special_judge(char* oj_home, int problem_id, char *infile, char *outfile,
		char *userfile) {
 
	pid_t pid;
	printf("pid=%d\n", problem_id);
	pid = fork();
	int ret = 0;
	if (pid == 0) {
 
		while (setgid(1536) != 0)
			sleep(1);
		while (setuid(1536) != 0)
			sleep(1);
		while (setresuid(1536, 1536, 1536) != 0)
			sleep(1);
 
		struct rlimit LIM; // time limit, file limit& memory limit
 
		LIM.rlim_cur = 5;
		LIM.rlim_max = LIM.rlim_cur;
		setrlimit(RLIMIT_CPU, &LIM);
		alarm(0);
		alarm(10);
 
		// file limit
		LIM.rlim_max = STD_F_LIM + STD_MB;
		LIM.rlim_cur = STD_F_LIM;
		setrlimit(RLIMIT_FSIZE, &LIM);
 
		ret = execute_cmd("%s/data/%d/spj %s %s %s", oj_home, problem_id,
				infile, outfile, userfile);
		if (DEBUG)
			printf("spj1=%d\n", ret);
		if (ret)
			exit(1);
		else
			exit(0);
	} else {
		int status;
 
		waitpid(pid, &status, 0);
		ret = WEXITSTATUS(status);
		if (DEBUG)
			printf("spj2=%d\n", ret);
	}
	return ret;
 
}
void judge_solution(int & ACflg, int & usedtime, int time_lmt, int isspj,
		int p_id, char * infile, char * outfile, char * userfile, int & PEflg,
		int lang, char * work_dir, int & topmemory, int mem_lmt,
		int solution_id, double num_of_test) {
	//usedtime-=1000;
	int comp_res;
	if (!oi_mode)
		num_of_test = 1.0;
	if (ACflg == OJ_AC
			&& usedtime > time_lmt * 1000 * (use_max_time ? 1 : num_of_test))
		ACflg = OJ_TL;
	if (topmemory > mem_lmt * STD_MB)
		ACflg = OJ_ML; //issues79
	// compare
	if (ACflg == OJ_AC) {
		if (isspj) {
			comp_res = special_judge(oj_home, p_id, infile, outfile, userfile);
 
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
	if (lang == 3) {
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
void print_runtimeerror(char * err) {
	FILE *ferr = fopen("error.out", "a+");
	fprintf(ferr, "Runtime Error:%s\n", err);
	fclose(ferr);
}
void clean_session(pid_t p) {
	//char cmd[BUFFER_SIZE];
	const char *pre = "ps awx -o \"\%p \%P\"|grep -w ";
	const char *post = " | awk \'{ print $1  }\'|xargs kill -9";
	execute_cmd("%s %d %s", pre, p, post);
	execute_cmd("ps aux |grep \\^judge|awk '{print $2}'|xargs kill");
}
 
 
/*
功能：
	1、ACflg初始为OJ_AC，在这里各种跟踪调试，时刻判断各种可能的不合理情况
	修改标志位，结束执行子进程 ---这段好底层。。。。调试器原理？？？高端 
输入：
    pidApp: 执行子进程的pid
	infile: char * infile[] 在main()中定义，保存完整测试数据路径：/home/judge/data/1000/sample.in 或 /home/judge/data/1000/test.in
	ACflg : 程序执行结果标志，初始OJ_AC
	isspj : 不知什么意思？？？？？？？？？？？
	solution_id: 代评测题目id
	lang : 程序语言类型 c 0 c++ 1
	topmemory: 在main()中定义
	mem_lmt : 内存限制
	usedtime : 执行所耗时间
	time_lmt : 时间限制
	p_id : 问题id
	PEFlg : 未知 初始为OJ_AC
	work_dir : /home/judge/run0
输出：
    无 
调用：
    在main()中调用 
    watch_solution(pidApp, infile, ACflg, isspj, userfile, outfile,
					solution_id, lang, topmemory, mem_lmt, usedtime, time_lmt,
					p_id, PEflg, work_dir);
注释：2014-11-04 18:30 by ghf in HNSSYZX ZhengZhou 
*/
void watch_solution(pid_t pidApp, char * infile, int & ACflg, int isspj,
		char * userfile, char * outfile, int solution_id, int lang,
		int & topmemory, int mem_lmt, int & usedtime, int time_lmt, int & p_id,
		int & PEflg, char * work_dir) {
	// parent
	int tempmemory;
 
	if (DEBUG)
		printf("pid=%d judging %s\n", pidApp, infile);
 
	int status, sig, exitcode;
	//与ptrace 相互配合，来进行跟踪调试执行子进程 
	struct user_regs_struct reg; 
	struct rusage ruse;
	while (1) {
		// check the usage
		//跟踪调试 
		wait4(pidApp, &status, 0, &ruse);
 
//jvm gc ask VM before need,so used kernel page fault times and page size
		if (lang == 3) {
			tempmemory = get_page_fault_mem(ruse, pidApp);
		} else {        //other use VmPeak
			tempmemory = get_proc_status(pidApp, "VmPeak:") << 10;
		}
		if (tempmemory > topmemory)
			topmemory = tempmemory;
		//内存超了就退出，并修改ACflg 
		if (topmemory > mem_lmt * STD_MB) {
			if (DEBUG)
				printf("out of memory %d\n", topmemory);
			if (ACflg == OJ_AC)
				ACflg = OJ_ML;
			ptrace(PTRACE_KILL, pidApp, NULL, NULL);//杀死子进程，停止执行 
			break;
		}
		//sig = status >> 8;/*status >> 8 脙楼脗路脗庐脙陇脗赂脗聧脙楼脗陇脜隆脙娄脣聹脗炉EXITCODE*/
 
		if (WIFEXITED(status))
			break;
		if ((lang < 4 || lang == 9) && get_file_size("error.out") && !oi_mode) {
			ACflg = OJ_RE;
			//addreinfo(solution_id);
			ptrace(PTRACE_KILL, pidApp, NULL, NULL);
			break;
		}
 
		if (!isspj
				&& get_file_size(userfile)
						> get_file_size(outfile) * 2 + 1024) {
			ACflg = OJ_OL;
			ptrace(PTRACE_KILL, pidApp, NULL, NULL);
			break;
		}
 
		exitcode = WEXITSTATUS(status);
		/*exitcode == 5 waiting for next CPU allocation          * ruby using system to run,exit 17 ok
		 *  */
		if ((lang >= 3 && exitcode == 17) || exitcode == 0x05 || exitcode == 0)
			//go on and on
			;
		else {
 
			if (DEBUG) {
				printf("status>>8=%d\n", exitcode);
 
			}
			//psignal(exitcode, NULL);
 
			if (ACflg == OJ_AC) {
				switch (exitcode) {
				case SIGCHLD:
				case SIGALRM:
					alarm(0);
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
				print_runtimeerror(strsignal(exitcode));
			}
			ptrace(PTRACE_KILL, pidApp, NULL, NULL);
 
			break;
		}
		if (WIFSIGNALED(status)) {
			/*  WIFSIGNALED: if the process is terminated by signal
			 *
			 *  psignal(int sig, char *s)锛宭ike perror(char *s)锛宲rint out s, with error msg from system of sig  
			 * sig = 5 means Trace/breakpoint trap
			 * sig = 11 means Segmentation fault
			 * sig = 25 means File size limit exceeded
			 */
			sig = WTERMSIG(status);
 
			if (DEBUG) {
				printf("WTERMSIG=%d\n", sig);
				psignal(sig, NULL);
			}
			if (ACflg == OJ_AC) {
				switch (sig) {
				case SIGCHLD:
				case SIGALRM:
					alarm(0);
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
				print_runtimeerror(strsignal(sig));
			}
			break;
		}
		/*     comment from http://www.felix021.com/blog/read.php?1662
		 WIFSTOPPED: return true if the process is paused or stopped while ptrace is watching on it
		 WSTOPSIG: get the signal if it was stopped by signal
		 */
 
		// check the system calls
		ptrace(PTRACE_GETREGS, pidApp, NULL, &reg);
		if (call_counter[reg.REG_SYSCALL] ){
			//call_counter[reg.REG_SYSCALL]--;
		}else if (record_call) {
			call_counter[reg.REG_SYSCALL] = 1;
		
		}else { //do not limit JVM syscall for using different JVM
			ACflg = OJ_RE;
			char error[BUFFER_SIZE];
			sprintf(error,
					"[ERROR] A Not allowed system call: runid:%d callid:%ld\n TO FIX THIS , ask admin to add the CALLID into corresponding LANG_XXV[] located at okcalls32/64.h ,and recompile judge_client",
					solution_id, (long)reg.REG_SYSCALL);
			write_log(error);
			print_runtimeerror(error);
			ptrace(PTRACE_KILL, pidApp, NULL, NULL);
		}
		
 
		ptrace(PTRACE_SYSCALL, pidApp, NULL, NULL);
	}
	usedtime += (ruse.ru_utime.tv_sec * 1000 + ruse.ru_utime.tv_usec / 1000);
	usedtime += (ruse.ru_stime.tv_sec * 1000 + ruse.ru_stime.tv_usec / 1000);
 
	//clean_session(pidApp);
}
 
//清空目录 
void clean_workdir(char * work_dir) {
	//卸载 /home/judge/run0 下的文件系统 /proc 
	execute_cmd("/bin/umount %s/proc", work_dir);
	if (DEBUG) {//如果调试则删除日志文件 
		execute_cmd("/bin/mv %s/* %slog/", work_dir, work_dir);
	} else {//没调试则删除/home/judge/run0 下所有文件 -rf 递归强制删除所有目录与文件，不提示 
		execute_cmd("/bin/rm -Rf %s/*", work_dir);
 
	}
 
}
 
 
//在judge.cc中调用参数 
//runidstr  : solution_id 的字符串 参数1
//buf		: clientid   也就是进程id字符串
//oj_home	: /home/judge 
//execl("/usr/bin/judge_client", "/usr/bin/judge_client", runidstr, buf,
//				oj_home, (char *) NULL);
//argv[0] 指向程序运行的全路径名
//argv[1] 指向在DOS命令行中执行程序名后的第一个字符串
//argv[2] 指向执行程序名后的第二个字符串
void init_parameters(int argc, char ** argv, int & solution_id,
		int & runner_id) {
	if (argc < 3) {//如果参数小于3个，则报错退出 
		fprintf(stderr, "Usage:%s solution_id runner_id.\n", argv[0]);
		fprintf(stderr, "Multi:%s solution_id runner_id judge_base_path.\n",
				argv[0]);
		fprintf(stderr,
				"Debug:%s solution_id runner_id judge_base_path debug.\n",
				argv[0]);
		exit(1);
	}
	//参数大于4个则启用调试？？？？ ，默认4个所以0 
	DEBUG = (argc > 4);
	record_call = (argc > 5);//这个不懂？？？ 
	if (argc > 5) {//第6个参数，评测语言 
		strcpy(LANG_NAME, argv[5]);
	}
	if (argc > 3) //第4个参数，评测目录 
		strcpy(oj_home, argv[3]);
	else//否则默认目录设置为/home/judge 
		strcpy(oj_home, "/home/judge");
	//切换当前默认目录为/home/judge 
	chdir(oj_home); // change the dir// init our work
 
	solution_id = atoi(argv[1]);
	runner_id = atoi(argv[2]);
}
int get_sim(int solution_id, int lang, int pid, int &sim_s_id) {
	char src_pth[BUFFER_SIZE];
	//char cmd[BUFFER_SIZE];
	sprintf(src_pth, "Main.%s", lang_ext[lang]);
 
	int sim = execute_cmd("/usr/bin/sim.sh %s %d", src_pth, pid);
	if (!sim) {
		execute_cmd("/bin/mkdir ../data/%d/ac/", pid);
 
		execute_cmd("/bin/cp %s ../data/%d/ac/%d.%s", src_pth, pid, solution_id,
				lang_ext[lang]);
		//c cpp will
		if (lang == 0)
			execute_cmd("/bin/ln ../data/%d/ac/%d.%s ../data/%d/ac/%d.%s", pid,
					solution_id, lang_ext[lang], pid, solution_id,
					lang_ext[lang + 1]);
		if (lang == 1)
			execute_cmd("/bin/ln ../data/%d/ac/%d.%s ../data/%d/ac/%d.%s", pid,
					solution_id, lang_ext[lang], pid, solution_id,
					lang_ext[lang - 1]);
 
	} else {
 
		FILE * pf;
		pf = fopen("sim", "r");
		if (pf) {
			fscanf(pf, "%d%d", &sim, &sim_s_id);
			fclose(pf);
		}
 
	}
	if (solution_id <= sim_s_id)
		sim = 0;
	return sim;
}
void mk_shm_workdir(char * work_dir) {
	char shm_path[BUFFER_SIZE];
	sprintf(shm_path, "/dev/shm/hustoj/%s", work_dir);
	execute_cmd("/bin/mkdir -p %s", shm_path);
	execute_cmd("/bin/rm -rf %s", work_dir);
	execute_cmd("/bin/ln -s %s %s/", shm_path, oj_home);
	execute_cmd("/bin/chown judge %s ", shm_path);
	execute_cmd("chmod 755 %s ", shm_path);
	//sim need a soft link in shm_dir to work correctly
	sprintf(shm_path, "/dev/shm/hustoj/%s/", oj_home);
	execute_cmd("/bin/ln -s %s/data %s", oj_home, shm_path);
 
}
int count_in_files(char * dirpath) {
	const char * cmd = "ls -l %s/*.in|wc -l";
	int ret = 0;
	FILE * fjobs = read_cmd_output(cmd, dirpath);
	fscanf(fjobs, "%d", &ret);
	pclose(fjobs);
 
	return ret;
}
 
int get_test_file(char* work_dir, int p_id) {
	char filename[BUFFER_SIZE];
	char localfile[BUFFER_SIZE];
	int ret = 0;
	const char * cmd =
			" wget --post-data=\"gettestdatalist=1&pid=%d\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O - \"%s/admin/problem_judge.php\"";
	FILE * fjobs = read_cmd_output(cmd, p_id, http_baseurl);
	while (fgets(filename, BUFFER_SIZE - 1, fjobs) != NULL) {
		sscanf(filename, "%s", filename);
		sprintf(localfile, "%s/data/%d/%s", oj_home, p_id, filename);
		if (DEBUG)
			printf("localfile[%s]\n", localfile);
 
		const char * check_file_cmd =
				" wget --post-data=\"gettestdatadate=1&filename=%d/%s\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O -  \"%s/admin/problem_judge.php\"";
		FILE * rcop = read_cmd_output(check_file_cmd, p_id, filename,
				http_baseurl);
		time_t remote_date, local_date;
		fscanf(rcop, "%ld", &remote_date);
		fclose(rcop);
		struct stat fst;
		stat(localfile, &fst);
		local_date = fst.st_mtime;
 
		if (access(localfile, 0) == -1 || local_date < remote_date) {
 
			if (strcmp(filename, "spj") == 0)
				continue;
			execute_cmd("/bin/mkdir -p %s/data/%d", oj_home, p_id);
			const char * cmd2 =
					" wget --post-data=\"gettestdata=1&filename=%d/%s\" --load-cookies=cookie --save-cookies=cookie --keep-session-cookies -q -O \"%s\"  \"%s/admin/problem_judge.php\"";
			execute_cmd(cmd2, p_id, filename, localfile, http_baseurl);
			ret++;
 
			if (strcmp(filename, "spj.c") == 0) {
				//   sprintf(localfile,"%s/data/%d/spj.c",oj_home,p_id);
				if (access(localfile, 0) == 0) {
					const char * cmd3 = "gcc -o %s/data/%d/spj %s/data/%d/spj.c";
					execute_cmd(cmd3, oj_home, p_id, oj_home, p_id);
				}
 
			}
			if (strcmp(filename, "spj.cc") == 0) {
				//     sprintf(localfile,"%s/data/%d/spj.cc",oj_home,p_id);
				if (access(localfile, 0) == 0) {
					const char * cmd4 =
							"g++ -o %s/data/%d/spj %s/data/%d/spj.cc";
					execute_cmd(cmd4, oj_home, p_id, oj_home, p_id);
				}
			}
		}
 
	}
	pclose(fjobs);
 
	return ret;
}
void print_call_array() {
	printf("int LANG_%sV[256]={", LANG_NAME);
	int i = 0;
	for (i = 0; i < call_array_size; i++) {
		if (call_counter[i]) {
			printf("%d,", i);
		}
	}
	printf("0};\n");
 
	printf("int LANG_%sC[256]={", LANG_NAME);
	for (i = 0; i < call_array_size; i++) {
		if (call_counter[i]) {
			printf("HOJ_MAX_LIMIT,");
		}
	}
	printf("0};\n");
 
}
 
//在judge.cc中调用参数 
//runidstr  : solution_id 的字符串 参数1
//buf		: clientid   也就是进程id字符串
//oj_home	: /home/judge 
//execl("/usr/bin/judge_client", "/usr/bin/judge_client", runidstr, buf,
//				oj_home, (char *) NULL);
//argv[0] 指向程序运行的全路径名
//argv[1] 指向在DOS命令行中执行程序名后的第一个字符串
//argv[2] 指向执行程序名后的第二个字符串
int main(int argc, char** argv) {
 
	char work_dir[BUFFER_SIZE]; //工作目录 
	//char cmd[BUFFER_SIZE];
	char user_id[BUFFER_SIZE]; //用户id 
	int solution_id = 1000; //题目id 
	int runner_id = 0;  //进程id 
	int p_id, time_lmt, mem_lmt, lang, isspj, sim, sim_s_id, max_case_time = 0;
//初始化参数，代评测id， 进程id ，评测目录 ,DEBUG,RECORD_CALL 
	init_parameters(argc, argv, solution_id, runner_id);
//初始化数据库链接信息，读取/home/judge/etc/judge.conf，初始化conn 
	init_mysql_conf();
//如果是轮询数据库，并且数据库链接失败，那么退出 
	if (!http_judge && !init_mysql_conn()) {
		exit(0); //exit if mysql is down
	}
	//set work directory to start running & judging
	//work_dir : /home/judge/run0 
	sprintf(work_dir, "%s/run%s/", oj_home, argv[2]);
 
    //shm_run默认0 不知道什么作用还？？？？ 
	if (shm_run)
		mk_shm_workdir(work_dir);
	//进入/home/judge/run0 并设置为当前工作 目录 
	chdir(work_dir);
	if (!DEBUG)//因为DEBUG = (argc>4) :0 所以工作前先清除下该目录 
		clean_workdir(work_dir);
 
	if (http_judge)
		system("/bin/ln -s ../cookie ./");
	//读取数据库solution表依据solution_id,初始化p_id问题id,user_id用户id，lang编程语言编码 
	get_solution_info(solution_id, p_id, user_id, lang);
	//get the limit
	//读取运行时间、内存限制，如果是test则默认值 
	if (p_id == 0) {
		time_lmt = 5;
		mem_lmt = 128;
		isspj = 0;
	} else {
		get_problem_info(p_id, time_lmt, mem_lmt, isspj);
	}
	//copy source file
    //根据情况读取源程序代码 
    //默认是将源码从数据库中读取到/home/judge/run0/ 建立Main.c 
	get_solution(solution_id, work_dir, lang);
 
    //独立处理java 
	//java is lucky
	if (lang >= 3) {
		// the limit for java
		time_lmt = time_lmt + java_time_bonus;
		mem_lmt = mem_lmt + java_memory_bonus;
		// copy java.policy
		execute_cmd("/bin/cp %s/etc/java0.policy %s/java.policy", oj_home,
				work_dir);
 
	}
	//对时间内存做出最大上限 
	//never bigger than judged set value;
	if (time_lmt > 300 || time_lmt < 1)
		time_lmt = 300;
	if (mem_lmt > 1024 || mem_lmt < 1)
		mem_lmt = 1024;
 
	if (DEBUG)
		printf("time: %d mem: %d\n", time_lmt, mem_lmt);
 
	// compile
	//      printf("%s\n",cmd);
	// set the result to compiling
	//编译程序 
	int Compile_OK;
    
	Compile_OK = compile(lang);//编译是否完成，成功默认返回0；否则返回错误文件ce.txt的大小 
	if (Compile_OK != 0) {//编译失败则推出判题进程不需后续执行了 
		addceinfo(solution_id);
		update_solution(solution_id, OJ_CE, 0, 0, 0, 0, 0.0);
		update_user(user_id);
		update_problem(p_id);
		if (!http_judge)
			mysql_close(conn);
		if (!DEBUG)
			clean_workdir(work_dir);
		else
			write_log("compile error");
		exit(0);
	} else {//如果是除了"rb", "sh", "py",这三种以外的语言，更新表solution 
		update_solution(solution_id, OJ_RI, 0, 0, 0, 0, 0.0);
	}
	//exit(0);
	// run
	//执行编译后程序 
	char fullpath[BUFFER_SIZE];///home/judge/data/1000 完整的测试数据目录 
	char infile[BUFFER_SIZE];
	char outfile[BUFFER_SIZE];
	char userfile[BUFFER_SIZE];
	sprintf(fullpath, "%s/data/%d", oj_home, p_id); // the fullpath of data dir
 
	// open DIRs
	DIR *dp;
	dirent *dirp;
	// using http to get remote test data files
	if (p_id > 0 && http_judge)
		get_test_file(work_dir, p_id);
	//默认采用的这种，读取目录文件失败则判题子程序退出，-1 
	if (p_id > 0 && (dp = opendir(fullpath)) == NULL) {
 
		write_log("No such dir:%s!\n", fullpath);
		if (!http_judge)
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
	if (lang == 7)
		copy_php_runtime(work_dir);
	if (lang == 8)
		copy_perl_runtime(work_dir);
	if (lang == 9)
		copy_mono_runtime(work_dir);
	if (lang == 10)
		copy_objc_runtime(work_dir);
	if (lang == 11)
		copy_freebasic_runtime(work_dir);
	if (lang == 12)
		copy_guile_runtime(work_dir);
	// read files and run
	// read files and run
	// read files and run
	double pass_rate = 0.0;
	int num_of_test = 0;
	int finalACflg = ACflg;
	//网页点击的测试， 
	if (p_id == 0) {}  //custom input runnin
		printf("running a custom input...\n");
		get_custominput(solution_id, work_dir);
		init_syscalls_limits(lang);
		pid_t pidApp = fork();
 
		if (pidApp == 0) {
			run_solution(lang, work_dir, time_lmt, usedtime, mem_lmt);
		} else {
			watch_solution(pidApp, infile, ACflg, isspj, userfile, outfile,
					solution_id, lang, topmemory, mem_lmt, usedtime, time_lmt,
					p_id, PEflg, work_dir);
 
		}
		if (ACflg == OJ_TL) {
			usedtime = time_lmt * 1000;
		}
		if (ACflg == OJ_RE) {
			if (DEBUG)
				printf("add RE info of %d..... \n", solution_id);
			addreinfo(solution_id);
		} else {
			addcustomout(solution_id);
		}
		update_solution(solution_id, OJ_TR, usedtime, topmemory >> 10, 0, 0, 0);
 
		exit(0);
	}
	//真正的submit执行测试 
	for (; (oi_mode || ACflg == OJ_AC) && (dirp = readdir(dp)) != NULL;) {
		//遍历/home/judge/data/1000下的sample.in sample.out test.in test.out 
		namelen = isInFile(dirp->d_name); // check if the file is *.in or not
		if (namelen == 0)
			continue;
		//准备好测试数据，初始化，outfile,userfile 
		prepare_files(dirp->d_name, namelen, infile, p_id, work_dir, outfile,
				userfile, runner_id);
		//这是什么限制？？？？？？？ 
		init_syscalls_limits(lang);
		//又要创建执行子进程了。。。。 
		pid_t pidApp = fork();
		
		if (pidApp == 0) {//如果是子进程在执行 
			//执行程序，在/run0/下生成user.out结果文件 
			run_solution(lang, work_dir, time_lmt, usedtime, mem_lmt);
		} else {
			//父进程，创建的执行子进程数量+1，这里是不是没有处理如果子进程创建失败该如何？？？？？？？？？ 
			num_of_test++;
			//这里没有采用 waitpid()方式，而是采用监视子进程方式ptrace()
			//为什么这样用呢？？？？？？？？？？ 
			//监视子进程，看齐是否能完整无误执行下来，随时修改ACflg 
			watch_solution(pidApp, infile, ACflg, isspj, userfile, outfile,
					solution_id, lang, topmemory, mem_lmt, usedtime, time_lmt,
					p_id, PEflg, work_dir);
			//到这里执行子进程应该是结束了，开始进行结果的判断匹配 
			judge_solution(ACflg, usedtime, time_lmt, isspj, p_id, infile,
					outfile, userfile, PEflg, lang, work_dir, topmemory,
					mem_lmt, solution_id, num_of_test);
			if (use_max_time) {
				max_case_time =
						usedtime > max_case_time ? usedtime : max_case_time;
				usedtime = 0;
			}
			//clean_session(pidApp);
		}
		if (oi_mode) {
			if (ACflg == OJ_AC) {
				++pass_rate;
			}
			if (finalACflg < ACflg) {
				finalACflg = ACflg;
			}
 
			ACflg = OJ_AC;
		}
	}
	if (ACflg == OJ_AC && PEflg == OJ_PE)
		ACflg = OJ_PE;
	if (sim_enable && ACflg == OJ_AC && (!oi_mode || finalACflg == OJ_AC)
			&& lang < 5) { //bash don't supported
		sim = get_sim(solution_id, lang, p_id, sim_s_id);
	} else {
		sim = 0;
	}
	//if(ACflg == OJ_RE)addreinfo(solution_id);
 
	if ((oi_mode && finalACflg == OJ_RE) || ACflg == OJ_RE) {
		if (DEBUG)
			printf("add RE info of %d..... \n", solution_id);
		addreinfo(solution_id);
	}
	if (use_max_time) {
		usedtime = max_case_time;
	}
	if (ACflg == OJ_TL) {
		usedtime = time_lmt * 1000;
	}
	if (oi_mode) {
		if (num_of_test > 0)
			pass_rate /= num_of_test;
		update_solution(solution_id, finalACflg, usedtime, topmemory >> 10, sim,
				sim_s_id, pass_rate);
	} else {
		update_solution(solution_id, ACflg, usedtime, topmemory >> 10, sim,
				sim_s_id, 0);
	}
	if ((oi_mode && finalACflg == OJ_WA) || ACflg == OJ_WA) {
		if (DEBUG)
			printf("add diff info of %d..... \n", solution_id);
		if (!isspj)
			adddiffinfo(solution_id);
	}
	update_user(user_id);
	update_problem(p_id);
	clean_workdir(work_dir);
 
	if (DEBUG)
		write_log("result=%d", oi_mode ? finalACflg : ACflg);
	if (!http_judge)
		mysql_close(conn);
	if (record_call) {
		print_call_array();
	}
	closedir(dp);
	return 0;
}
```

