<?php
/* access_key用作简单的访问控制 */
$access_key='';

/* 备份保留天数，整数，默认15天 */
$backup_keep_day=15;

/* 数据库参数 */
$db_user='';
$db_password='';

// $db_name 可以是字符串(单个数据库)，也可以是数组(多个数据库)，如果为空，则备份所有数据库
$db_name='';
 
/* 以下非必要参数 */

//$db_host='';

/* 只需要备份的Tables */
//$include_tables=array();

/* 不需要备份的Tables */
// $exclude_tables = array();