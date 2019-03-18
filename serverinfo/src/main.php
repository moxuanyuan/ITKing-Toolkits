<?php


session_start();

@header("content-Type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Shanghai');


$checkFormFields=array(
		'mysqlHost',
		'mysqlPort',
		'mysqlUsername',
		'mysqlPassword',
		'email',
		'smtpHost',
		'smtpPort',
		'smtpSSL',
		'smtpUsername',
		'smtpPassword'
);

$defEmail='it@hknow.net';

$PHP_VERSION_whole = PHP_VERSION;

$PHP_VERSION_mini = substr($PHP_VERSION_whole,0,3);

$max_execution_time=get_cfg_var('max_execution_time');

$max_execution_time=$max_execution_time=='0'?'unlimited':"{$max_execution_time} 秒";

$default_socket_timeout=get_cfg_var('default_socket_timeout');

$default_socket_timeout=$default_socket_timeout=='0'?'unlimited':"{$default_socket_timeout} 秒";

if($_SERVER['SERVER_PORT']==80)
{
	$urlSelf = "http://".$_SERVER['SERVER_NAME'].($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
}else{
	$urlSelf = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
}



