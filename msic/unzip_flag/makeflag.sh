#!/bin/bash
echo 'SKCTF{'`cat flag`'}' > flag.txt
zip -e --password=`perl -e "print time()"` flag.zip flag.txt