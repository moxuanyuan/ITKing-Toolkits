basePath="/volume1/ServerBackup"

projectStore="$basePath/project" 

webPath="/volume1/web"

backupReport="$basePath/backup_report.txt"

DBbackupFolder=('DBbackup' 'backupDB')

columnNames=('Last Backup' 'Project' 'Folder Size' 'DB File Size' 'DB Backup Time')

varNames=('lastBackupTime' 'projectName' 'folderSize' 'DBfileSize' 'DBfileTime')
 
index=1

for item in "${columnNames[@]}"
do
    declare column${index}Length=${#item}

    ((index++))
done

cd $projectStore

projectNum=$(ls -d */ | wc -l)

projectIndex=1

for i in $(ls -d */ -Rt)
do 

    projectName=${i%%/}

    projectPath="$projectStore/$projectName"

    lastBackupTime=$(date -r "$projectPath/_lastBackupTime" +"%Y-%m-%d %H:%M:%S")

    folderSize=$(du -hs $projectPath  | awk '{print $1}')

    DBfile=''

    DBfileSize=''

    DBfileTime=''

    for item in ${DBbackupFolder[@]}
    do 
        if [ -d "$projectPath/$item" ]; then
    
            DBfilesNum=$(ls $projectPath/$item/*.sql* | wc -l)

            if [ "$DBfilesNum" != "0" ] ; then

                DBfile=`ls $projectPath/$item/*.sql* -Rt | head -1`
                
                DBfileSize=$(du -h "$DBfile" | awk '{print $1}')

                DBfileTime=$(date -r "$DBfile" "+%Y-%m-%d %H:%M:%S")

                break
                
            fi
        fi
    done

    index=1

    for item in "${varNames[@]}"
    do
        var=${!item} 

        column=column${index}Length 

        if [ ${#var} -ge ${!column} ]; then

            declare column${index}Length=${#var}

        fi

        declare project${projectIndex}[${index}]="$var"

        ((index++))

    done

    ((projectIndex++))
 
done

rm -rf $backupReport

index=1

columnTotalLen=0

for item in "${columnNames[@]}"
do 
    column=column${index}Length

    eval ${column}'=$['${column}'+4]' 
 
    len=${!column}

    columnTotalLen=$[columnTotalLen+len]

    printf "%-${len}s" "$item" >> $backupReport

    ((index++))
done

echo -e "\r" >> $backupReport

eval "printf '=%.0s' {1.."$columnTotalLen"} >> "$backupReport

echo -e "\r" >> $backupReport

projectIndex=1

while [ $projectIndex -le $projectNum ]
do

    index=1

    for item in "${columnNames[@]}"
    do 
        column=column${index}Length 
    
        len=${!column}

        varName=project${projectIndex}[${index}]

        var=${!varName}

        printf "%-${len}s" "$var" >> $backupReport

        ((index++))

    done
    echo -e "\n" >> $backupReport
    ((projectIndex++))

done

cp $backupReport $webPath





 
