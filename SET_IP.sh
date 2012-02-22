#!/bin/sh
ip=`/sbin/ifconfig ppp0 | /bin/grep inet | /usr/bin/awk '{print substr($2,6)}'`
/usr/bin/wget http://www.YOURSERVER.de/ipsite.php?ip=$ip --timeout=20 --delete-after > /dev/null 2>&1
