<html>
<head>
	<link rel="stylesheet" href="login.css">
	<link rel="stylesheet" href="signup.css">
</head>
<body>
<div class="cent1" >
<div class="topleft" style="font-size:30px;">Come join us!!</div>
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  >
			<table class="cent1" style="font-size:25px;">
				<tr height="60" ">
				<td width="150" >User Name</td>
				<td  ><input class="tb" type="text" name="unameS" id="unameS" size="26"/></td>
				</tr>
				
				<tr  height="60">
				<td >Password</td>
				<td ><input class="tb" type="password" name="passS" id="passS" size="26"/></td>
				</tr>
				
				<tr  height="60">
				<td >Confirm Pass</td>
				<td ><input class="tb" type="password" name="cpassS" id="cpassS" size="26"/></td>
				</tr>

				<tr  height="60">
				<td >Describe You</td>
				<td ><input class="tb" type="text" name="descS" id="descS" size="26"/></td>
				</tr>
			<tr  height="60">
				<td >Display Pic</td>
				<td ><input class="tb" type="text" name="urlS" id="urlS" size="26"/></td>
				</tr>
			</table>
			<input type="submit" value="Join!!" class="butC1" name="sig_but_sub"/>
		</form>
		<div class="botleft" id="mess">
	


</div>
</div>
<?php
	error_reporting(E_ALL);
	session_start();
	if( $_SERVER['REQUEST_METHOD']== "POST")
	{
		if( ($_POST['passS']==$_POST['cpassS']) and isset($_POST['unameS']) and isset($_POST['passS']) and isset($_POST['descS']) and isset($_POST['urlS']))
		{

			$iscon= mysql_connect("localhost","root","");
			if($iscon)
			{
				mysql_select_db("chatdb") or mysql_error();
				$uname= mysql_real_escape_string($_POST['unameS']);
				$pass = mysql_real_escape_string($_POST['passS']);
				$desc = mysql_real_escape_string($_POST['descS']);
				$url = mysql_real_escape_string($_POST['urlS']);
				$query= "insert into user_table(uname,pass) values('".$uname."','".$pass."')";
				$query1= "insert into user_details(uname,uimage,description) values('".$uname."',LOAD_FILE('".$url."'),'".$desc."')";
				$result=mysql_query($query);
				$result1= mysql_query($query1);	
				if($result and $result1)
				{
					echo "<script type='text/javascript'>alert('Welcome!! Login to continue');</script>";
					header('Location:login.php');
				}
				else
				{
					echo "<script type='text/javascript'>alert('Encountered some problem while adding you. Please try again');</script>";
					header('Location:signup.php');
				}	
			}
		}
		else
		{
			echo '<script language="javascript"> alert("Passwords dont match");</script>';
		}
	}
?>
</body>
</html>