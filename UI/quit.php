<? php
	session_start();
	if($_SERVER['REQUEST_METHOD']=='GET')
	{
		session_unset();
		session_destroy();
		echo '<script>window.location="http://localhost/brag_test/startPage.php";</script>
	
		header('Location:startPage.php');	
	}
?>