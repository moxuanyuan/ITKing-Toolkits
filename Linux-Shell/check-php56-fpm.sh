CHECK_URL="https://www.igift.hk" 

LOGFILE="/var/log/check-php56-fpm.log"

RESULT=`curl -s -o /dev/null -w "%{http_code}" ${CHECK_URL} | grep -e '^5[0-9][0-9]$'` 
 
if [ ! "$RESULT" = "" ] ; then

    echo 'php-fpm process num is '`ps aux | grep 'php-fpm' | wc -l`" at $(date +%Y-%m-%d-%H-%M-%S)" >> $LOGFILE 

    ps aux | grep 'php-fpm' >> $LOGFILE

    echo -e "-----------------------------------------------------------------------------\n" >> $LOGFILE
    
    killall php56-fpm

fi

