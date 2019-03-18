<?php

function yes_no($flag)
{
	return $flag?'<i data-feather="check" class="color-green"></i>':'<i data-feather="x" class="color-red"></i>';
}

function echo_yes_no($flag)
{
	echo yes_no($flag);
}


function serverIp()
{
	$text=$_SERVER['SERVER_NAME'];

	$ip='/'==DIRECTORY_SEPARATOR?file_get_contents('http://ipecho.net/plain'):@gethostbyname($_SERVER['SERVER_NAME']);

	return $_SERVER['SERVER_NAME'].' ( '.$ip.' )';
}


//检测PHP设置参数

function show($varName)
{
	$result = get_cfg_var($varName);
	switch($result)
	{

		case '':
		case '0':

			return yes_no(0);

		break;


		case '1':

			return yes_no(1);

		break;


		default:

			return $result;

		break;

	}

}


function isfun($funName = '')
{
	if($funName && !trim($funName) == '' && !preg_match('~[^a-z0-9\_]+~i', $funName, $tmp) && function_exists($funName))
	{
		return true;
	}else
	{
		return false;
	}
}

function showIsFun($funName = '')
{
     echo_yes_no(isfun($funName));
}


function mysql_version()
{
	if(function_exists("mysql_get_server_info")) {

	    $s = @mysql_get_server_info();

	    $s = $s ? 'mysql_server 版本：'.$s : '';

	  $c = '&nbsp; mysql_client 版本：'.@mysql_get_client_info();

	    return $s;

	}
	if(function_exists("mysqli_get_server_info")) {

	    return explode(' - ', mysqli_get_client_info() )[0];

	}
}

function server_software()
{
	$data=$_SERVER['SERVER_SOFTWARE'];

	$data=='Apache' && function_exists('apache_get_version') && ($data=apache_get_version());

	return $data;
}


function sessionPostData()
{
	global $checkFormFields;
	$data=array();
	foreach ($checkFormFields as $value) {
		$data[$value]=isset($_SESSION['post'][$value])?$_SESSION['post'][$value]:'';
	}
	return $data;
}
