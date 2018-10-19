CHECK_URL="https://igift.hk" 

RESULT=`curl -s -o /dev/null -w "%{http_code}" ${CHECK_URL} | grep -e '^5[0-9][0-9]$'` 

if [ ! "$RESULT" = "" ] ; then
    killall php56-fpm
fi

