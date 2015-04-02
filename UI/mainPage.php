<html>
<head>
<link rel="stylesheet" href="mainPage.css"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<?php
session_start();
if( isset($_SESSION['username']))
{
$uname= $_SESSION['username'];
$iscon= mysql_connect("localhost", "root", "");
if($iscon)
{
	mysql_select_db("chatdb") or die('connection error');
	$query= "select * from user_details where uname='".$uname."' ";
	$result= mysql_query($query);
	mysql_close($iscon);
	if($result)
	{
	//header("Content-type: img/jpeg");
	$_SESSION['img']=mysql_result($result,0,2);
	$_SESSION['desc']=mysql_result($result,0,3);
	}
	
}
else
{
	echo '<script language="javascript"> alert("Application under maintanene");</script>';
}
}
else
{
	echo '<script language="javascript"> alert("You must be to logged in to view this page");</script>';
	header("Location: login.php");
}


?>
<body>
<!--Displays the user profile-->
<div class="profile">
	<!--to display the user profile-->
	<?php echo '<img style="margin:10px 0 0 10px; float:left;border-radius:50%;" src="data:image/jpeg;base64,'.base64_encode( $_SESSION['img'] ).'" height="120px" width="120px"/>'; 
	echo '<p style="float:left;margin:20px 0 0 10px;  font-weight: bold; font-size:30px">'.$_SESSION['username'].'</p>'; 
	echo '<p style="float:left;margin:70px 0 0 -50px; font-size:18px;">'.$_SESSION['desc'].'</p>';
	?>
</div>
<!-- Displays the list of people -->
<div class="ppl_list">
	<div style="margin:10px 0 0 30px; font-size:30px; height:25px; border:1px">Chats</div>
	<div style="margin:45px 0 0 -90px;">
	<form method="GET" action=""<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >
	<table ><tr><td width="250px" >
		<input class="tb" type="text" name="unameT" id="unameT" size="25" value="Enter a username to start chat"/>
		</td>
		<td ><input class="butBlue" type="submit" name="addU" value="+"/>
		</td>
	</table>
	</form>
	</div>
	<div style="overflow:scroll;float:left;margin:110px 0 0 -300px;width:300px;">
		
		<?php
			$iscon= mysql_connect("localhost", "root", "");
			if(isset($_GET['addU']))
			{
				if($_GET['unameT']!== "")
				{
					
					if($iscon)
					{
					mysql_select_db("chatdb") or die('connection error');
					$query= "insert into chat_tab(user1,user2,message,islast) values ('".$_SESSION['username']."','".$_GET['unameT']."','Hello, You there?I have joined StartChat!!',1)";
					//echo $query;
					$result=mysql_query($query);	
					if($result)
					{
						$_SESSION['suser']=$_GET['addU'];
						echo '<script language="javascript"> alert("User added to your list");</script>';
						//echo "User added to your list";
					}
					else
					{
						echo '<script language="javascript"> alert("User could not be added. Please try again");</script>';
						//echo "User could not be added. Please try again";
					}
					}
				}
				else
				{
					
					echo '<script language="javascript"> alert("Enter the Username");</script>';
				}		
			}
			
			if($iscon)
			{
				mysql_select_db("chatdb") or die('connection error');
				$query= "SELECT * FROM `user_details` WHERE uname in (select user1 from chat_tab where user2='".$_SESSION['username']."' union select user2 from chat_tab where user1='".$_SESSION['username']."' )";
				$result= mysql_query($query);
				if($result)
				{
				//echo '<br>';
				$topsp=0;
				while($r= mysql_fetch_array($result))
				{
						
						if($topsp==0)
						{
							echo '<input style="margin-left:10px;margin-top:'.$topsp.';height:30px;" type="radio" name="suser" value="'.$r['uname'].'"  onClick="getRadioValue(this)" checked/>&nbsp;&nbsp;<label for="'.$r['uname'].'"><img class="picround" src="data:image/jpeg;base64,'.base64_encode( $r['uimage'] ).'" height="50px" width="50px"/></label>&nbsp;&nbsp;&nbsp;&nbsp;'.$r["uname"].'<br>';
							$_SESSION['suser']=$r['uname'];
						}
						else
							echo '<input style="margin-left:10px;margin-top:'.$topsp.';height:30px;" type="radio" name="suser"  value="'.$r['uname'].'" onClick="getRadioValue(this);" />&nbsp;&nbsp;<label for="'.$r['uname'].'"><img class="picround"  src="data:image/jpeg;base64,'.base64_encode( $r['uimage'] ).'" height="50px" width="50px"/></label>&nbsp;&nbsp;&nbsp;&nbsp;'.$r["uname"].'<br>';
						$topsp= $topsp+10;
				}
				}
				
			}	
			else
			{
				echo "DB Connection failed due to some technical error";
			}	
		?>
		<script>
			function getRadioValue(nradio)
			{
				//alert("Function called");
				/*var rad= document.getElementsByName("suser");
				var val="";
				var xmlhttp;
				for(int i=0; i< rad.length; i++)
				{
					if(rad[i].checked)
					{
						val= rad[i].value;
						alert(val);
						break;
					}
				}*/
				var val=nradio.value;
				//alert(val);
				if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} 
				else {
				// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange= function()
				{
					if(xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						//document.getElementById("chatbox").innerHTML=xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET","ppl.php?suser="+val,true);
				xmlhttp.send();
			
		}
		</script>
	</div>
	
			
</div>
<div class="mess">
	<div id="chatwithuser" class="chatwith" >
		<?php 
			/*if(isset($_SESSION['suser']))
			{
			if($iscon)
			{
				mysql_select_db("chatdb") or die('connection error');
				$query= "select * from user_details where uname='".$_SESSION['suser']."' ";
				$result= mysql_query($query);
				//mysql_close($iscon);
				if($result)
				{
					$suserimg=mysql_result($result,0,2);
					echo '<table > <tr><td><img class="picround"  src="data:image/jpeg;base64,'.base64_encode( $suserimg ).'" height="60px" width="60px"/></td>';
					echo '<td style="width:100px;align:center;font-size:25px; padding-left:20px">'.$_SESSION['suser'].'</td><td> </tr></table>';
				}
				
			}
			else
				die('Connection failed');
			}
			else
			{
				echo "Select a person to chat with";
			}
*/
		?>
		<script>
			var xmlhttp;
			function loadXMLDoc(url,cfunc)
			{
				if (window.XMLHttpRequest)
				{// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}
				else
				{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=cfunc;
				xmlhttp.open("GET",url,true);
				xmlhttp.send();
			}
			function loaduser()
			{
					loadXMLDoc("currentuser.php",function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							document.getElementById("chatwithuser").innerHTML=xmlhttp.responseText;
						}
					});
			}
			var myVar=setInterval(function () {loaduser()}, 500);
		</script>
	</div>
	<div id="chatbox" class="chathis" style="">
		<script>
			var xmlhttp;
			/*function loadXMLDoc(url,cfunc)
			{
				if (window.XMLHttpRequest)
				{// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}
				else
				{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=cfunc;
				xmlhttp.open("GET",url,true);
				xmlhttp.send();
			}*/
			function getMess()
			{
					loadXMLDoc("getMessages.php",function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							document.getElementById("chatbox").innerHTML="";
							document.getElementById("chatbox").innerHTML=xmlhttp.responseText;
						}
					});
			}
			var myVar=setInterval(function () {getMess()}, 2000);
		</script>
	</div>
	<div id="typemess" class="message" >
		Type your message here 
		<!--<form method="GET" action=""<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >-->
		<form>
		<table  ><tr ><td width="250px"  >
		<input class="tb" type="text" name="smess" id="smess" size="40"/>
		</td>
		<td ><input class="butSend" type="button" id="sendbut" name="sendbut" value="Send" onClick="inputMessage()" />
		</td>
		<script>
		function inputMessage()
		{
			
			var xmlhttp;
			if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
			} else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					//document.getElementById("chatbox").innerHTML=xmlhttp.responseText;
					document.getElementById("smess").value="";
				}
			}
			if(document.getElementById("smess").value!= null && document.getElementById("smess").value!="")
			{
			xmlhttp.open("GET","insMessage.php?smess="+document.getElementById("smess").value,true);
			xmlhttp.send();
			}
			else	
				alert("Type in some message");
			
		}
	</script>
	</table>
	</form>&nbsp;&nbsp;
	<form method="GET" >
		<input style="border:solid 1px" class="butLogout" type="submit" id="logoutbut" name="logoutbut" value="Logout"  />
	</form>
	<?php
		if(isset($_GET['logoutbut']))
		{
			session_unset();
			session_destroy();
			header('Location:startPage.php');
		}
	?>
	</div>
</div>


</body>
</html>