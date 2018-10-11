# PHP Mysql Dump
使用第三方php类库[ifsnop/mysqldump-php](https://github.com/ifsnop/mysqldump-php)将数据库导出为sql文件存在服务器上

## 首选方案
- 下载所需要文件Mysqldump.php , index.php , .htaccess。
- 在项目服务器根目录新建目录"DBbackup"，将Mysqldump.php , index.php , .htaccess上传到"DBbackup"。
- 编辑index.php，设定好access_key，修改数据库参数。
- 假设服务器domain为yourdomain.com，打开http://yourdomain.com/DBbackup?access_key=****** 。
- 检查是否在目录"DBbackup"生成了db_dbname_时间.sql.gz，则备份成功。

## 备用方案
如果首选方案不能用，例如php 版本低于5.3、数据库太大导出超时等等，可以试试备用方案，在第三方php类库[2createStudio/shuttle-export](https://github.com/2createStudio/shuttle-export)基础上，进行了小部分修改。下载alternative目录下 dumper.php , index.php , .htaccess，使用方法跟首选方案一样

## 检查备份文件是否正确
