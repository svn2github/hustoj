all: judge_client.cc
	g++ -c -I/usr/local/mysql/include/mysql -I/usr/include/mysql judge_client.cc
	g++ -o judge_client judge_client.o -L/usr/local/mysql/lib/mysql -L/usr/lib/mysql -lmysqlclient
