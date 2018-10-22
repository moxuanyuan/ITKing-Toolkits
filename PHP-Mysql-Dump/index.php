<?php
use Ifsnop\Mysqldump as IMysqldump;
@error_reporting(0);
@date_default_timezone_set('Asia/Shanghai');
@set_time_limit(0);

$directory=dirname(__FILE__); 

include_once("{$directory}/config.php"); 

if(isset($_GET['access_key']) && $_GET['access_key']==$access_key)
{
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
    
    empty($db_host) && ($db_host='localhost');

    if(empty($db_name))
    {
        $db_name=array();

        $exclude_dbs=array('mysql','performance_schema','information_schema');

        if (class_exists('mysqli')) { 

            $conn = @new MySQLi($db_host, $db_user, $db_password);

            $res = $conn->query('SHOW DATABASES');

            if($res->num_rows > 0)
            {
                while($row = $res->fetch_assoc())
                {
                    $db_name[]=$row['Database'];
                }
            }

            $conn->close();

		} else {

            $conn = @mysql_connect($db_host, $db_user, $db_password);

            $res = mysql_query('SHOW DATABASES');

            if(mysql_num_rows($res) > 0)
            {
                while($row = mysql_fetch_assoc($res))
                {
                    $db_name[]=$row['Database'];
                }
            }

            mysql_close($conn);
        }
        
        if(empty($db_name)) exit;

        $db_name=array_diff($db_name,$exclude_dbs);

    }else
    {
        !is_array($db_name) && ($db_name=array($db_name));
    }

    include_once("{$directory}/Mysqldump.php"); 
    
    $dumpSettings = array( 
        'compress' => IMysqldump\Mysqldump::GZIP,
        'add-drop-table'=>true
    );

    !empty($include_tables) && ($$dumpSettings['include-tables']=$include_tables);

    !empty($exclude_tables) && ($$dumpSettings['exclude-tables']=$exclude_tables);

    try {
 
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
        
        echo 'success as '.date('Y-m-d H:i:s');

    } catch (\Exception $e) {
        echo 'mysqldump-php error: ' . $e->getMessage();
    }
}
