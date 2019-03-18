<?php
	$filename='serverinfo.php';

	$files=array(
		'PHPMailer.php',
		'SMTP.php',
		'main.php',
		'function.php',
		'action.php'
	);


	$content='<?php ';

	foreach ($files as $key => $value) {
		$content.=substr(file_get_contents("./src/{$value}"),5);
	}

	$content.=' ?> '.file_get_contents('./src/tpl.php').' <?php session_write_close(); ?>';


	$f=fopen($filename,"w");
	fwrite($f, pack('CCC',0xef,0xbb,0xbf));
	fwrite($f,$content);
	fclose($f);

	echo "{$filename} has been successfully builded.";
?>
