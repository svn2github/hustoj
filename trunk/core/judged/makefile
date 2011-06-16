all: judged.cc
	g++ -c -I/usr/local/mysql/include/mysql -I/usr/include/mysql  judged.cc
	g++ -o judged judged.o -L/usr/local/mysql/lib/mysql -L/usr/lib/mysql  -lmysqlclient
