DIR=/volume1/web/backupDB/
DATESTAMP=$(date +%Y%m%d%H%M%S)
DB_USER=admin
DB_PASS=91279893 

mkdir -p ${DIR}
 
cd $DIR 

dumpFileNum=`find -name "mysqldump-*.sql.gz" | wc -l | sed 's/\ //g'`

if [ "$dumpFileNum" != "0" ] ; then 

    if [[ -f _lastImport ]]; then 
        lastImportFile=`cat _lastImport`
    else 
        lastImportFile=""
    fi

    file=`ls -t1 mysqldump-*.sql.gz | head -n 1`

    dumpFile="${file:0:-3}"

    if [ "$dumpFile" != "$lastImportFile" ]; then  
    
        gunzip -c $file >> $dumpFile

        /usr/local/mariadb10/bin/mysql -u${DB_USER} -p${DB_PASS} -e "set global max_allowed_packet=268435456"

        /usr/local/mariadb10/bin/mysql -u${DB_USER} -p${DB_PASS} < $dumpFile

        echo "$dumpFile" > _lastImport

        rm $dumpFile

    fi
fi
 


 