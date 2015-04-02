<html>
<head>
	<link rel="stylesheet" href="login.css">
</head>
<body>
<?php
	error_reporting(E_ALL);
	session_start();
	//isset($_POST['log_but_sub'])
	if($_SERVER['REQUEST_METHOD']== "POST")
	{
		$iscon= mysql_connect("localhost","root","");
		if($iscon)
		{
			mysql_select_db("chatdb") or mysql_error();
			$uname= mysql_real_escape_string($_POST['unameT']);
			$pass = mysql_real_escape_string($_POST['passT']);
			$query= "select * from user_table where uname='".$uname. "' and pass='".$pass."'  ";			
			//$query="SELECT * FROM user_table WHERE uname='raj' and pass='raj'";
			//echo $query;
			$result= mysql_query($query);
			$numrow= mysql_num_rows($result);
			if( $numrow == 1)
			{
				
				$_SESSION['username']=$_POST['unameT'];
				header('Location: mainPage.php');

			}
			else
			{
				//echo "<script type='text/javascript' language='javascript'> document.getElementById('mess').innerHTML='Incorrect username or password';</script>";
				echo "<script type='text/javascript'>alert(' Incorrect username or password');</script>";
				//echo " Incorrect username or password";
				header('Location:login.php');
			}
		
			
		}
		else
		{
			echo '<script language="javascript"> alert("Application under maintanene");</script>';
		}
		mysql_close($iscon);
	}
	
?>
	<div class="cent">
		<div class="topleft" style="font-size:30px">Login</div>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  >
			<table class="cent" style="font-size:25px">
				<tr height="80">
				<td width="150" >User Name</td>
				<td  ><input class="tb" type="text" name="unameT" id="unameT" size="26"/></td>
				</tr>
				
				<tr  height="80">
				<td >Password</td>
				<td ><input class="tb" type="password" name="passT" id="passT" size="26"/></td>
				</tr>
			</table>
			<input type="submit" value="Lets chat" class="butC" name="log_but_sub"/>
		</form><br>
		<div class="botleft" id="mess">Login to continue!!
	


</div>
</div>
</body>
</html>