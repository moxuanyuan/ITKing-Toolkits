<?php

if(isset($_GET['act']))
{
	switch ($_GET['act']) {
		case 'phpinfo':
			phpinfo();
			exit();

		case 'function':
			$arr = get_defined_functions();
			echo "<pre>";
			Echo "这里显示系统所支持的所有函数,和自定义函数\n";
			print_r($arr);
			echo "</pre>";
			exit();

		case 'clean':
 			session_destroy();
			exit;

		case 'check':

			$time=date('Y-m-d H:i:s');

			$data=array();

			foreach ($checkFormFields  as $value) {
				$data[$value]=isset($_POST[$value])?$_POST[$value]:'';
			}

			$data['email']||($data['email']=$defEmail);

			//$title='Local mail test from [ '.$urlSelf.' ]';
			$title="Local mail test from ` {$urlSelf} ` at {$time}";
			$mailContent="<a href='{$urlSelf}'>{$urlSelf}</a>";
			$_SESSION['localMail']=@mail($data['email'], $mailContent, $title);
			$_SESSION['post']=$_POST;

			if($data['mysqlHost'])
			{

				if($PHP_VERSION_mini < '5.5')
				{
					$connect = @mysql_connect($data['mysqlHost'], $data['mysqlUsername'],$data['mysqlPassword']) or die("Unable to Connect to '{$data['mysqlHost']}'");

					$test_query = "SHOW TABLES FROM $dbname";
					$result = mysql_query($test_query);
					$tblCnt = 0;
					while($tbl = mysql_fetch_array($result)) {
					  $tblCnt++;
					  #echo $tbl[0]."<br />\n";
					}
					if (!$tblCnt) {
					  echo "There are no tables<br />\n";
					} else {
					  echo "There are $tblCnt tables<br />\n";
					}
				}else
				{
					if(function_exists('mysqli_close')==1)
					{
						$db = @new mysqli($data['mysqlHost'], $data['mysqlUsername'],$data['mysqlPassword']);

						if ($db->connect_error) {
						   $_SESSION['mysqlConnect']=false;
						   $_SESSION['mysqlError']=$db->connect_error;
						}else
						{
							$_SESSION['mysqlConnect']=true;

							$result=$db->query('SHOW GRANTS FOR CURRENT_USER');

							if($result){

								$_SESSION['mysqlPrivileges']=array();

							    while ($row = $result->fetch_array()){
							        $_SESSION['mysqlPrivileges'][] = $row;
							    }

							     $result->close();

							}

							$result=$db->query('SHOW DATABASES');

							if($result){

								$_SESSION['mysqlDatabases']=array();

							    while ($row = $result->fetch_array()){
							        $_SESSION['mysqlDatabases'][] = $row;
							    }

							     $result->close();

							}

							$db->close();
						}

					}
				}

			}

			if($data['smtpHost'])
			{

				$mail = new PHPMailer();

				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Host = $data['smtpHost'];
				$mail->Port = $data['smtpPort'];
				//Whether to use SMTP authentication
				$mail->SMTPAuth = true;

				$data['smtpSSL']=='Yes' && ( $mail->SMTPSecure = 'ssl');

				//Username to use for SMTP authentication
				$mail->Username = $data['smtpUsername'];
				//Password to use for SMTP authentication
				$mail->Password = $data['smtpPassword'];

				$mail->setFrom($data['smtpUsername']);
				//Set who the message is to be sent to
				$mail->addAddress($data['email'], '');
				//Set the subject line
				$mail->Subject = "Remote Smtp test from ` {$urlSelf} ` at {$time}";
				$mail->msgHTML($mailContent);
				$mail->AltBody = 'This is a plain-text message body';

				if (!$mail->send()) {
				    $_SESSION['remoteSMTP']=false;
				} else {
				    $_SESSION['remoteSMTP']=true;

				}
			}
			echo json_encode($_SESSION);
			exit();
		default:
			# code...
			break;
	}
}




