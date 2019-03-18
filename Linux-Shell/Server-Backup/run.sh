# 默认参数

basePath="/volume1/ServerBackup"

projectStore="$basePath/project"

configPath="$basePath/config"

runQueue="$basePath/queue"

tryQueue="$basePath/try"

logPath="$basePath/log"

runLog="$basePath/run.log"

dbBackupTimeout=6000

downloadTimeout=6000

mkdir -p $projectStore

mkdir -p $configPath

mkdir -p $logPath

mkdir -p "$logPath/queue"

mkdir -p $runQueue

mkdir -p $tryQueue

echo "$(date +"%Y-%m-%d %H:%M:%S") scritp start " >> $runLog

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

        echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] Server DB Backup start" >> $runLog

        echo -e "$(date +"%Y-%m-%d %H:%M:%S") Server DB Backup start \n" >> $logFile

        wget --timeout=3600 --spider "$(trim $dbBackupUrl)"

        echo -e "$(date +"%Y-%m-%d %H:%M:%S") Server DB Backup finish \n" >> $logFile

        echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] Server DB Backup finish" >> $runLog

    fi

    # 下载服务器的文件（FTP）
    
    if [ ! -z "$ftpProgram" ] && [ "$(trim $ftpProgram)" = "wget" ] ; then
    
        if [ "$ftpFolder" = "/" ] ;then
            ftpFolder=""
        fi 

        if [ ! -z "$ftpMode" ] && [ "$(trim $ftpMode)" = "port" ] ; then
            ftpPassiveMode="--no-passive-ftp"
        else
            ftpPassiveMode=""
        fi

        echo "wget" > $processFile

        echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] Wget start" >> $runLog

        echo -e "$(date +"%Y-%m-%d %H:%M:%S") Wget start \n" >> $logFile

        wget -m -nH $ftpPassiveMode --ftp-user=$ftpUser --ftp-password=$ftpPassword "ftp://$ftpHost$ftpFolder/*" -P $projectPath -o $getFileLog

        echo -e "$(date +"%Y-%m-%d %H:%M:%S") Wget finish \n" >> $logFile

        echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] Wget finish" >> $runLog

    else

        if [ ! -z "$ftpMode" ] && [ "$(trim $ftpMode)" = "port" ] ; then

            ftpPassiveMode=0
            
        else

            ftpPassiveMode=1
        fi 

        if [ -z "$ftpParallel" ] ; then
            ftpParallel=3
        fi   

        if [ ! -z "$ftpProtocol" ] && [ "$(trim $ftpProtocol)" = "sftp" ] ; then

            ftpProtocol='sftp://'

            sftpSetting='
                set ssl:verify-certificate no
                set sftp:auto-confirm yes
            '
        else

            ftpProtocol=''

            sftpSetting=''

        fi 

        if [ -z "$lftpSetting" ] ; then
            lftpSetting=""
        fi   

        echo "lftp" > $processFile

        echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] lftp start" >> $runLog

        echo -e "$(date +"%Y-%m-%d %H:%M:%S") lftp start \n" >> $logFile

        lftp -f "
            set ftp:passive-mode $ftpPassiveMode
            set ftp:list-options -a
            set mirror:use-pget-n 2 
            $lftpSetting
            $sftpSetting 
            open $ftpProtocol$ftpHost
            user $ftpUser '${ftpPassword}'
            mirror --delete --verbose --continue --parallel=$ftpParallel --log=$getFileLog '${ftpFolder}' '$projectPath'
            bye
        "
        echo -e "$(date +"%Y-%m-%d %H:%M:%S") lftp finish\n" >> $logFile

        echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] lftp finish" >> $runLog
        
    fi

    finishTime=$(date +%Y-%m-%d-%H-%M-%S)

    rm -rf $lastBackupTimeFile

    echo $finishTime > $lastBackupTimeFile

    echo -e "$(date +"%Y-%m-%d %H:%M:%S") Backup finish \n" >> $logFile

    cd $logPath

    rm -f ${projectName}_*.tar.gz 

    tar -czvf "${projectName}_$(date +%Y-%m-%d-%H-%M-%S).tar.gz" "${projectName}.file.log" "${projectName}.log" --remove-files

    # 备份完成，从队列中删除

    rm $processFile 

    rm "${runQueue}/${configFile}"

    if [[ -f "$waitFile" ]]; then
        rm $waitFile
    fi

    echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] Backup finish" >> $runLog
}

errorExit () {

    mkdir -p "$logPath/error"

    errorLogFile="$logPath/error/${projectName}_$(date +%Y%m%d).log"

    echo "at $(date +"%Y-%m-%d %H:%M:%S")" >> $errorLogFile

    echo -e $1"\n" >> $errorLogFile 

    if [[ -f "$logFile" ]]; then
        echo "$logFile" >> $errorLogFile
        echo "================================" >> $errorLogFile
        catFile=`cat $logFile`
        echo -e "${catFile}" >> $errorLogFile
        echo "================================" >> $errorLogFile
        rm $logFile
    fi

    if [[ -f "$getFileLog" ]]; then
        echo "$getFileLog" >> $errorLogFile
        echo "================================" >> $errorLogFile
        catFile=`cat $getFileLog`
        echo -e "${catFile}" >> $errorLogFile
        echo "================================" >> $errorLogFile
        rm $getFileLog
    fi

    rm $processFile
    
    rm $waitFile

    cp -rf "${runQueue}/${configFile}" $tryQueue

    rm "${runQueue}/${configFile}"

    if [ "$1" != "" ] ; then

        echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] error exit" >> $runLog

        exit 1
    fi
}

#每天需要备份的任务

queueLogFile="$logPath/queue/$(date +%Y%m%d).log"

if [[ ! -f "$queueLogFile" ]]; then

    echo "$(date +"%Y-%m-%d %H:%M:%S") queueLogFile" >> $runLog

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

    logFile="$logPath/${projectName}.log"

    getFileLog="$logPath/${projectName}.file.log"

    #processFile="$logPath/${projectName}.process"
    processFile="$logPath/process"

    waitFile="$logPath/${projectName}.wait"

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

    if [[ ! -f "$processFile" ]]; then

        echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] backup start" >> $runLog

        echo "start" > $processFile

        echo -e "$(date +"%Y-%m-%d %H:%M:%S") Backup start \n" > $logFile

        # 打包上次备份

        if [ ! -z "$archiveKeep" ] && [ $archiveKeep -gt 0 ]; then

        	historyPath="$basePath/history"

        	if [[ -f "$lastBackupTimeFile" ]]; then

                echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] archive last backup start" >> $runLog
                
        	    echo "archive" > $processFile

        	    echo -e "$(date +"%Y-%m-%d %H:%M:%S") Archive last backup start \n" >> $logFile

        	    lastBackupTime=`cat $lastBackupTimeFile`

        	    mkdir -p $historyPath

        	    cd $projectPath

        	    tar -zcvf "${historyPath}/${projectName}_${lastBackupTime}.tar.gz" .

        	    echo -e "$(date +"%Y-%m-%d %H:%M:%S") Archive last backup finish\n" >> $logFile

                echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] archive last backup finish" >> $runLog
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

        echo "$(date +"%Y-%m-%d %H:%M:%S") project [ ${projectName} ] processFile is exit" >> $runLog

        nowTime=$(date +%s)

        process=`cat $processFile`

        case $process in
            archive);&

            dbBackup)
                if [[ -f "$logFile" ]]; then

                    logFileModifiedTime=$(date -r $logFile +%s)

                    if [ $((nowTime - logFileModifiedTime)) -ge $dbBackupTimeout ]; then
                        errorExit "$process error"
                    fi
                fi
                ;;

            lftp);&
            wget)

                if [[ -f "$getFileLog" ]]; then

                    logTime=$(date -r $getFileLog +%s)

                else

                    logTime=$(date -r $logFile +%s)
 
                fi

                if [ $((nowTime - logTime)) -ge $downloadTimeout ]; then
                    
                    if [[ -f "$waitFile" ]]; then
                        retries=`cat $waitFile`
                    else
                        retries=0
                    fi

                    if [ $retries -ge 2 ]; then

                        errorExit

                        echo "$(date +"%Y-%m-%d %H:%M:%S") kill process" >> $runLog

                        sleep 2

                        ps -ef | grep $process | grep -v grep | cut -c 9-15 | xargs kill -s 9 
                        
                    else

                        echo "$(date +"%Y-%m-%d %H:%M:%S") wait again" >> $runLog

                        echo `expr $retries + 1` > $waitFile
                    fi 
                fi
                ;;
            *) rm $processFile ;;
        esac

    fi

else

    cd $tryQueue

    files=$(ls *.cfg 2> /dev/null | wc -l)

    if [ "$files" != "0" ] ; then

        tryCfg=`ls *.cfg -tr | head -1`

        cp -rf "${tryQueue}/${tryCfg}" $runQueue

        rm "${tryQueue}/${tryCfg}"

    fi

fi

# 每月1号20点20分，删除30天前的queue log
if [ "$(date +"%d%H%M")" == "012020" ] ; then

    find "${logPath}/queue" -mmin +43200 -type f | xargs rm -f

fi