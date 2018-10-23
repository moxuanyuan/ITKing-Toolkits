# 默认参数

basePath="/volume1/ServerBackup"

projectStore="$basePath/project"

configPath="$basePath/config"

runQueue="$basePath/queue"

logPath="$basePath/log"

mkdir -p $projectStore

mkdir -p $configPath

mkdir -p $logPath

mkdir -p "$logPath/queue"

mkdir -p $runQueue

# Base Function

trim() {
    local var="$*"
    # remove leading whitespace characters
    var="${var#"${var%%[![:space:]]*}"}"
    # remove trailing whitespace characters
    var="${var%"${var##*[![:space:]]}"}"
    echo -n "$var"
}

containsElement () {
  local e match="$1"
  shift
  for e; do [[ "$e" == "$match" ]] && return 0; done
  return 1
}

# 备份Function

runBackup () {
    # 在服务器端备份数据库
    if [ ! -z "$dbBackupUrl" ] && [ ! "$(trim $dbBackupUrl)" = "" ] ; then

        echo "dbBackup" > $processFile

        echo -e "Server DB Backup start at $(date +%Y-%m-%d-%H-%M-%S) \n" >> $logFile

        wget --timeout=3600 --spider "$(trim $dbBackupUrl)"

        echo -e "Server DB Backup finish at $(date +%Y-%m-%d-%H-%M-%S) \n" >> $logFile

    fi

    # 下载服务器的文件（FTP）

    if [ "$ftpFolder" = "/" ] ;then
        ftpFolder=""
    fi


    if [ ! -z "$ftpMode" ] && [ "$(trim $ftpMode)" = "port" ] ; then
        ftpPassiveMode="--no-passive-ftp"
    else
      
        ftpPassiveMode=""
    fi

    if [ ! -z "$ftpProgram" ] && [ "$(trim $ftpProgram)" = "lftp" ] ; then
        echo "lftp" > $processFile

        echo -e "lftp start at $(date +%Y-%m-%d-%H-%M-%S) \n" >> $logFile

        lftp -f "
        open $ftpHost
        user $ftpUser $ftpPassword
        lcd $ftpFolder
        mirror --delete --verbose $ftpFolder $projectPath
        bye
        "
        echo -e "lftp finish at $(date +%Y-%m-%d-%H-%M-%S) \n" >> $logFile

    else

        echo "wget" > $processFile

        echo -e "Wget start at $(date +%Y-%m-%d-%H-%M-%S) \n" >> $logFile

        wget -m -nH $ftpPassiveMode --ftp-user=$ftpUser --ftp-password=$ftpPassword "ftp://$ftpHost$ftpFolder/*" -P $projectPath -o $wgetLogFile

        echo -e "Wget finish at $(date +%Y-%m-%d-%H-%M-%S) \n" >> $logFile
        
    fi


    finishTime=$(date +%Y-%m-%d-%H-%M-%S)

    echo $finishTime > $lastBackupTimeFile

    echo -e "Backup finish at $finishTime \n" >> $logFile

    cd $logPath

    rm -f ${projectName}_*.tar.gz

    tar -czvf "${projectName}_$(date +%Y-%m-%d-%H-%M-%S).tar.gz" "${projectName}.log" "${projectName}.wget.log" --remove-files

    # 备份完成，从队列中删除

    rm $processFile

    rm "${runQueue}/${configFile}"
}

errorExit () {

    mkdir -p "$logPath/error"

    errorLogFile="$logPath/error/${projectName}_$(date +%Y%m%d).log"

    echo "at $(date +%Y-%m-%d-%H-%M-%S)" >> $errorLogFile

    echo -e $1"\n" >> $errorLogFile

    logFile="$logPath/${projectName}.log"

    wgetLogFile="$logPath/${projectName}.wget.log"

    if [[ -f "$logFile" ]]; then
        echo "$logFile" >> $errorLogFile
        echo "================================" >> $errorLogFile
        catFile=`cat $logFile`
        echo -e "${catFile}" >> $errorLogFile
        echo "================================" >> $errorLogFile
        rm $logFile
    fi

    if [[ -f "$wgetLogFile" ]]; then
        echo "$wgetLogFile" >> $errorLogFile
        echo "================================" >> $errorLogFile
        catFile=`cat $wgetLogFile`
        echo -e "${catFile}" >> $errorLogFile
        echo "================================" >> $errorLogFile
        rm $wgetLogFile
    fi

    rm $processFile

    rm "${runQueue}/${configFile}"

    exit 1
}

#每天需要备份的任务

queueLogFile="$logPath/queue/$(date +%Y%m%d).log"

if [[ ! -f "$queueLogFile" ]]; then

    cd $configPath

    files=$(ls *.cfg 2> /dev/null | wc -l)

    if [ "$files" != "0" ] ; then

        today=$(date +%a)

        cfgFiles=$(ls -d *.cfg)

        for f in $cfgFiles
        do
            source "${configPath}/${f}"

            # 判断配置是否正确

            if [ ! -z "$backupDay" ] && [ ! -z "$ftpHost" ] && [ ! -z "$ftpUser" ] && [ ! -z "$ftpPassword" ] && [ ! -z "$ftpFolder" ] ; then

                ftpHost="$(trim $ftpHost)"

                ftpUser="$(trim $ftpUser)"

                ftpPassword="$(trim $ftpPassword)"

                ftpFolder="$(trim $ftpFolder)"

                if [ ! "$ftpHost" = "" ] && [ ! "$ftpUser" = "" ] && [ ! "$ftpPassword" = "" ] && [ ! "$ftpFolder" = "" ] ; then

                    containsElement "$today" "${backupDay[@]}"

                    if [ $? = "0"  ] ; then

                        cp "${configPath}/${f}" $runQueue

                        echo $f >> $queueLogFile

                    fi

                fi

            fi

        done

    fi

    echo "" >> $queueLogFile
fi

# 则执行任务

cd $runQueue

files=$(ls *.cfg 2> /dev/null | wc -l)

# 执行队列中存在任务config文件，则进行备份
if [ "$files" != "0" ] ; then

    configFile=`ls *.cfg | head -1`

    projectName="${configFile:0:-4}"

    # 加载配置文件
    source "${runQueue}/${configFile}"

    # 判断配置是否正确
    cfgIsOk=false

    if [ ! -z "$ftpHost" ] && [ ! -z "$ftpUser" ] && [ ! -z "$ftpPassword" ] && [ ! -z "$ftpFolder" ] ; then

        ftpHost="$(trim $ftpHost)"

        ftpUser="$(trim $ftpUser)"

        ftpPassword="$(trim $ftpPassword)"

        ftpFolder="$(trim $ftpFolder)"

        if [ ! "$ftpHost" = "" ] && [ ! "$ftpUser" = "" ] && [ ! "$ftpPassword" = "" ] && [ ! "$ftpFolder" = "" ] ; then
            cfgIsOk=true
        fi

    fi

    if [ "$cfgIsOk" = false ] ; then

        errorExit "Config format is wrong."

    fi

    projectPath="$projectStore/$projectName"

    mkdir -p $projectPath

    lastBackupTimeFile="$projectPath/_lastBackupTime";

    logFile="$logPath/${projectName}.log"

    wgetLogFile="$logPath/${projectName}.wget.log"

    processFile="$logPath/${projectName}.process"

    if [[ ! -f "$processFile" ]]; then

        echo "start" > $processFile

        echo -e "Backup start at $(date +%Y-%m-%d-%H-%M-%S) \n" > $logFile

        # 打包上次备份

        if [ ! -z "$archiveKeep" ] && [ $archiveKeep -gt 0 ]; then

        	historyPath="$basePath/history"

        	if [[ -f "$lastBackupTimeFile" ]]; then

        	    echo "archive" > $processFile

        	    echo -e "Archive last backup start at $(date +%Y-%m-%d-%H-%M-%S) \n" >> $logFile

        	    lastBackupTime=`cat $lastBackupTimeFile`

        	    mkdir -p $historyPath

        	    cd $projectPath

        	    tar -zcvf "${historyPath}/${projectName}_${lastBackupTime}.tar.gz" .

        	    echo -e "Archive last backup finish at $(date +%Y-%m-%d-%H-%M-%S) \n" >> $logFile
        	fi

        	archiveNum=`find ${historyPath} -name "${projectName}_*.tar.gz" | wc -l | sed 's/\ //g'`

        	while [ $archiveNum -gt $archiveKeep ]
        	do
        	  ls -tr1 ${historyPath}/${projectName}_*.tar.gz | head -n 1 | xargs rm -f
        	  archiveNum=`expr $archiveNum - 1`
        	done

        fi

        runBackup

    else
        nowTime=$(date +%s)

        process=`cat $processFile`

        case $process in
            archive);&

            dbBackup)
                if [[ -f "$logFile" ]]; then

                    logFileModifiedTime=$(date -r $logFile +%s)

                    if [ $((nowTime - logFileModifiedTime)) -ge 1800 ]; then
                        errorExit "$process error"
                    fi
                fi
                ;;

            wget)
                if [[ -f "$wgetLogFile" ]]; then

                    wgetLogFileModifiedTime=$(date -r $wgetLogFile +%s)

                    if [ $((nowTime - wgetLogFileModifiedTime)) -ge 1800 ]; then
                        errorExit "wget error"
                    fi
                else

                    logFileModifiedTime=$(date -r $logFile +%s)

                    if [ $((nowTime - logFileModifiedTime)) -ge 1800 ]; then
                        errorExit "wget error"
                    fi
                fi
                ;;
            *) rm $processFile;;
        esac

    fi
fi