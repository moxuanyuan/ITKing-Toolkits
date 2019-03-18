basePath="/volume1/ServerBackup"

configPath="$basePath/config"

listFile="$basePath/day_list.txt"

# Base Function

trim() {
    local var="$*"
    # remove leading whitespace characters
    var="${var#"${var%%[![:space:]]*}"}"
    # remove trailing whitespace characters
    var="${var%"${var##*[![:space:]]}"}"
    echo -n "$var"
}

dayNames=('Mon' 'Tue' 'Wed' 'Thu' 'Fri' 'Sat' 'Sun')

for item in ${dayNames[@]}
do 
    declare day${item}Index=0
done
 
cd $configPath

files=$(ls *.cfg 2> /dev/null | wc -l)

if [ "$files" != "0" ] ; then

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

                projectName="${f:0:-4}"

                for item in ${backupDay[@]}
                do

                    indexName=day${item}Index 

                    index=${!indexName} 

                    declare day${item}[${index}]=$projectName

                    let $indexName++

                done

            fi

        fi

    done

fi

rm -rf $listFile

for item in ${dayNames[@]}
do 
    echo "[ $item ]">> $listFile 

    eval 'nEntries=${day'${item}'[@]}' 
    for i in ${nEntries[@]}
    do 

        echo $i >> $listFile 

    done

    echo '' >> $listFile 
done 
