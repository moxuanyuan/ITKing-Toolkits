# 备份指南

## 备份方法
- Server Backup Script
- OneDrive
- 手动

## Server Backup Script

### 使用方法
1. 数据库备份

    方法请看<https://github.com/moxuanyuan/ITKing-Toolkits/tree/master/PHP-Mysql-Dump>

1. 配置
    - 创建项目配置文件，以项目名称作为配置文件名，内容参考 [sample.cfg](https://github.com/moxuanyuan/ITKing-Toolkits/blob/master/Linux-Shell/Server-Backup/config/sample.cfg)，必须注意，配置文件必须使用linux 换行符
    - 登录Synology管理后台
    - 打开 File Station，进入目录"ServerBackup" -> "config"，把项目配置文件上传到目录"config"。后台脚本就会自动读取，定期执行备份

1. 测试
    - 复制或上传一份项目配置文件到目录"ServerBackup" -> "queue"，请确保此时目录"queue"没有其它项目配置文件
    - 打开*Synology -> Control Panel ->Task Scheduler*
    - Run一次备份脚本"Server Backup"
    - 进入目录"ServerBackup" -> "project"，检查项目文件夹是否已生成，
    - 再进入"ServerBackup" -> "log"，查看是否有对应该项目log , **xxxx.log** , **xxxx.wget.log** , **xxxx.process**
    - 如果有上述log文件，则说明项目正在备份中
    - 如果备份完成，上述log文件将会打包成 **xxxx.tar**

### 检查