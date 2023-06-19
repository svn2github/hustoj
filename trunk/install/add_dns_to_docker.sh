#!/bin/bash
DNS=`cat /etc/resolv.conf |grep nameserver|awk '{print $2}' | tail -1 `
cd /etc/docker
if grep 'dns' daemon.json > /dev/null ; then
        echo "has dns"
else

        head -`wc -l daemon.json |awk '{print $1-1}'` daemon.json > new.json
        echo ",    \"dns\": [\"$DNS\", \"8.8.8.8\", \"114.114.114.114\"] " >> new.json
        echo '}' >> new.json

        mv daemon.json old.json
        mv new.json daemon.json

fi
