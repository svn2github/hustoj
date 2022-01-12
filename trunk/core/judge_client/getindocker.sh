#!/bin/bash
/usr/bin/docker container run --pids-limit 100 --rm --cap-add SYS_PTRACE --net=host -v /home/judge:/home/judge -it hustoj
