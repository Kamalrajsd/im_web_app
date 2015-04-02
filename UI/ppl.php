<?php
	session_start();
	$suser=$_REQUEST['suser'];
	$_SESSION['suser']=$suser;
	echo $_SESSION['suser'];
?>