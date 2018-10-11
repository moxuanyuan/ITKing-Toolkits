<?php
use Ifsnop\Mysqldump as IMysqldump;
@error_reporting(0);
@date_default_timezone_set('Asia/Shanghai');
@set_time_limit(0);

/* access_key用作简单的访问控制 */
$access_key='';

/* 备份保留天数，整数，默认15天 */
$backup_keep_day=15;

/* 数据库参数 */
$db_user='';
$db_password='';

// $db_name 可以是字符串(单个数据库)，也可以是数组(多个数据库)
$db_name='';
 
/* 以下非必要参数 */

//$db_host='';

/* 只需要备份的Tables */
//$include_tables=array();

/* 不需要备份的Tables */
// $exclude_tables = array();
 

if(isset($_GET['access_key']) && $_GET['access_key']==$access_key)
{
    $directory=dirname(__FILE__); 

    $gzs=glob("*.sql.gz");

    if(is_array($gzs))
    {
        $nowtime=time();

        foreach($gzs as $v)
        {
            $filepath="{$directory}/$v"; 
            if(($nowtime-filemtime($filepath)) >= $backup_keep_day*24*60*60)
            {
               @unlink($filepath); 
            }
        }
    } 

    include_once($directory."/Mysqldump.php"); 
    
    $dumpSettings = array( 
        'compress' => IMysqldump\Mysqldump::GZIP,
        'add-drop-table'=>true
    );

    empty($db_host) && ($db_host='localhost');

    !empty($include_tables) && ($$dumpSettings['include-tables']=$include_tables);

    !empty($exclude_tables) && ($$dumpSettings['exclude-tables']=$exclude_tables);

    try {

        !is_array($db_name) && ($db_name=array($db_name));

        foreach($db_name as $v)
        {
            $filename='db_'.$v.'_'.date('YmdHis');
            $dump = new IMysqldump\Mysqldump(
                "mysql:host={$db_host};dbname={$v}",
                $db_user,
                $db_password,
                $dumpSettings
            );
            $dump->start($filename.'.sql.gz');
        }
    } catch (\Exception $e) {
        echo 'mysqldump-php error: ' . $e->getMessage();
    }
}
