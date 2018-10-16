# 备份指南

## 备份方法
- Server Backup Script
- OneDrive
- 手动

## Server Backup Script

### 使用方法
1. 设置数据库备份

    方法请看<https://github.com/moxuanyuan/ITKing-Toolkits/tree/master/PHP-Mysql-Dump>

1. 创建script cfg文件
    - 创建项目配置文件，以项目名称作为配置文件名，内容参考[sample.cfg](https://github.com/moxuanyuan/ITKing-Toolkits/blob/master/Linux-Shell/Server-Backup/config/sample.cfg)，必须注意，配置文件必须使用linux 换行符
    - 登录Synology管理后台
    - 打开 File Station，进入目录"ServerBackup" -> "config"，把项目配置文件上传到目录"config"。后台脚本就会自动读取，定期执行备份

1. 测试
    - 复制或上传一份项目配置文件到目录"ServerBackup" -> "queue"，请确保此时目录"queue"没有其它项目配置文件
    - 打开*Synology -> Control Panel ->Task Scheduler*
    - Run一次备份脚本"Server Backup"
    - 进入目录"ServerBackup" -> "project"，检查项目文件夹是否已生成
    - 再进入"ServerBackup" -> "log"，查看是否有对应该项目log , **xxxx.log** 
    - 如果有上述log文件，则说明项目正在备份中
    - 如果备份完成，会生成备分记录 **xxxx_YYYY-mm-dd-HH-MM-SS.tar**

### 检查
- 进入数据库备份的目录，解压备份文件，打开其中的sql文件，检查最后一行是否为 : `-- Dump completed on: .............`，则表示数据库备份成功
- 再进入备份服务器的folder **"ServerBackup" -> "log"**
- 在log folder 目录查有 **xxxx.log** ， **xxxx.wget.log** ， **xxxx.process** ， 说明正在执行备份中
- **xxxx_YYYY-mm-dd-HH-MM-SS.tar** 文件是项目的备分记录，从文件名可得知最近备份时间
- 打开 **xxxx_YYYY-mm-dd-HH-MM-SS.tar** ，里面会有两个log文件 ， **xxxx.log** ， **xxxx.wget.log** ，**xxxx.log** 是备份流程的简单记录，**xxxx.wget.log**是文件下载的记录。
- 打开 **xxxx.wget.log** 检查最后一行是否为 : `Downloaded: ..........` ，则表示文件备份成功