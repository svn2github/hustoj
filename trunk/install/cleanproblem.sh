#!/bin/bash
cd /home/judge/src/install
rm -rf ../../data/*
echo "delete from problem ;" |./mysql.sh
echo "ALTER TABLE problem AUTO_INCREMENT = 1000 ;"|./mysql.sh
