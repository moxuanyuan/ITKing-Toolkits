## 0. Main
使用第三方php类库[MySQLDump](https://github.com/ifsnop/mysqldump-php)将数据库导出为sql文件存在服务器上，然后在专用备份机上运行linux bash script 定时执行备份任务，以ftp方式将服务器上的文件备份到专用备份机上。

## 1. 流程
### 1.1 数据库备份
- 到这里<https://github.com/moxuanyuan/ServerBackup/> 下载所需要文件**Mysqldump.php** , **index.php** , **.htaccess** , **sample.cfg**。
- 在项目服务器根目录新建目录"DBbackup"，将**Mysqldump.php** , **index.php** , **.htaccess**上传到"DBbackup"。
- 编辑**index.php**，设定好access_key，修改数据库参数。
- 假设服务器domain为yourdomain.com，打开<http://yourdomain.com/DBbackup?access_key=******> 。
- 检查是否在目录"DBbackup"生成了**db_dbname_xxxx-xx-xx.sql.gz**，如果是则备份数据库功能正常。
### 1.2 专用备份机配置
预设专用备份机为Synology
- 创建项目配置文件，以项目名称作为配置文件名，内容参考**sample.cfg**，必须注意，配置文件必须使用linux 换行符
- 登录Synology管理后台
- 打开 File Station，进入目录"ServerBackup" -> "config"，把项目配置文件上传到目录"config"。后台脚本就会自动读取，定期执行备份
### 1.3 测试
- 复制或上传一份项目配置文件到目录"ServerBackup" -> "queue"，请确保此时目录"queue"没有其它项目配置文件
- 打开*Synology -> Control Panel ->Task Scheduler*
- Run一次备份脚本"Server Backup"
- 进入目录"ServerBackup" -> "project"，检查项目文件夹是否已生成，
- 再进入"ServerBackup" -> "log"，查看是否有对应该项目log , **xxxx.log** , **xxxx.wget.log** , **xxxx.process**
- 如果有上述log文件，则说明项目正在备份中
- 如果备份完成，上述log文件将会打包成 **xxxx.tar**