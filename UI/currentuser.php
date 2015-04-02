<?php 
			session_start();
			$iscon= mysql_connect("localhost","root","");
			if(isset($_SESSION['suser']))
			{
				$touser=$_SESSION['username'];
				$fromuser=$_SESSION['suser'];
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

		?>