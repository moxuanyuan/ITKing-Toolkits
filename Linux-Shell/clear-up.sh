#删除多少分钟前的文件
timeInt=40

echo "$(date +"%Y-%m-%d %H:%M:%S") start " >> "/var/log/clear-up.log"

folders=(`cat './clear-up.conf'`)

len=${#folders[@]}

for ((i=0;i<$len;i++));do
	
    if [ -d "${folders[$i]}" ]; then

        find ${folders[$i]} -mmin +${timeInt} -type f | xargs rm -f

    fi
done

echo "$(date +"%Y-%m-%d %H:%M:%S") finish " >> "/var/log/clear-up.log"
