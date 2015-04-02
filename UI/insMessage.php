<?php
	error_reporting(E_ALL);
	session_start();
	$iscon = mysql_connect('localhost', 'root', '');
	if($iscon)
	{
		mysql_select_db("chatdb") or mysql_error();
		$mess= $_REQUEST['smess'];
		$touser=$_SESSION['suser'];
		$fromuser=$_SESSION['username'];
		//echo $mess.$touser.$fromuser;
		//$query="update chat_tab set islast=0 where user1='".$fromuser."' and user2='".$touser."'";
		//$result=mysql_query($query);
		//if($result)
		//{
			$query1= "insert into `chat_tab`(user1,user2,message,islast) values('".$fromuser."','".$touser."','".$mess."',1)";
			$result1=mysql_query($query1);
			if($result1)
			{
				$query1="update chat_tab set islast=0 where ( user1='".$touser."' and user2='".$fromuser."')";
				$result=mysql_query($query1);
				echo "Message sent";
			}
		//}
			else
			{
				//die("DB Error, page inMessage.php");
				echo "Message not sent1";
			}
		mysql_close($iscon);
		
	}
	else
	{
		echo "Message not sent";
		//die("DB Error, page inMessage.php");
	}
?>