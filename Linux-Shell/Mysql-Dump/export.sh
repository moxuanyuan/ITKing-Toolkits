DIR=/volume1/web/backupDB/
DATESTAMP=$(date +%Y%m%d%H%M%S)
DB_USER=root
DB_PASS=
 
# create backup dir if it does not exist
mkdir -p ${DIR}
 
# remove backups older than $DAYS_KEEP
#DAYS_KEEP=30
#find ${DIR}* -mtime +$DAYS_KEEP -exec rm -f {} \; 2&gt; /dev/null
 
# remove all backups except the $KEEP latest
KEEP=10
BACKUPS=`find ${DIR} -name "mysqldump-*.sql.gz" | wc -l | sed 's/\ //g'`
while [ $BACKUPS -ge $KEEP ]
do
  ls -tr1 ${DIR}mysqldump-*.sql.gz | head -n 1 | xargs rm -f
  BACKUPS=`expr $BACKUPS - 1`
done
 
#
# create backups securely
#umask 006
 
# dump all the databases in a gzip file
FILENAME=${DIR}mysqldump-${DATESTAMP}.sql.gz
/usr/local/mariadb10/bin/mysqldump --user=$DB_USER --password=$DB_PASS --opt --all-databases --flush-logs | gzip > $FILENAME