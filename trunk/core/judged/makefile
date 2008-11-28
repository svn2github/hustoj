all: judged.cc
	g++ -c -I/usr/local/mysql/include/mysql judged.cc
	g++ -o judged judged.o -L/usr/local/mysql/lib/mysql -lmysqlclient
