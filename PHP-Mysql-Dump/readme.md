# PHP Mysql Dump
使用第三方php类库MySQLDump将数据库导出为sql文件存在服务器上

## 使用说明
- 下载所需要文件Mysqldump.php , index.php , .htaccess。
- 在项目服务器根目录新建目录"DBbackup"，将Mysqldump.php , index.php , .htaccess上传到"DBbackup"。
- 编辑index.php，设定好access_key，修改数据库参数。
- 假设服务器domain为yourdomain.com，打开http://yourdomain.com/DBbackup?access_key=****** 。
- 检查是否在目录"DBbackup"生成了db_dbname_时间.sql.gz，如果是则备份数据库功能正常。