<html>
<head>
<link rel="stylesheet" href="getMessages.css"/>
</head>
<body>
<?php
	//error_reporting(E_ALL);
	session_start();
	$iscon = mysql_connect('localhost', 'root', '');
	if($iscon)
	{
		if(isset($_SESSION['username']) and isset($_SESSION['suser']))
		{
			mysql_select_db("chatdb") or mysql_error();
			$touser=$_SESSION['username'];
			$fromuser=$_SESSION['suser'];
			$query= "select * from chat_tab where ((user1='".$fromuser."' and user2='".$touser."') or (user2='".$fromuser."' and user1='".$touser."')) order by islast,stime ";
			$result= mysql_query($query);
			$previslast=0;
			while( $r=mysql_fetch_array($result))
			{
				if( ($previslast==0 and $r['islast']==1) and $r['user1']!==$touser )
				{
					echo '<br><div class="unread" align="center">Unread messages</div>';
				}
				$previslast=$r['islast'];
				
				if($r['user1']==$fromuser and $r['user2']==$touser)
				{
					echo '<div class="receiv" style="float:left">'.$r['message'].'<div class="time">'.relativeTime($r['stime']).'</div></div><br><br>';
				}
				elseif($r['user1']==$touser and $r['user2']==$fromuser)
				{
					echo '<div class="sent" align="right" style="float:right">'.$r['message'].'<div class="time">'.relativeTime($r['stime']).'</div></div><br><br>';
				}
			}
			
		}
		else
		{
			echo "No messages for you for now!!";
		}
		
	}
	else
		die('Could not load messages');
	function relativeTime($time) 
	{
    $d[0] = array(1,"second");
    $d[1] = array(60,"minute");
    $d[2] = array(3600,"hour");
    $d[3] = array(86400,"day");
    $d[4] = array(604800,"week");
    $d[5] = array(2592000,"month");
    $d[6] = array(31104000,"year");

    $w = array();

    $return = "";
    $now = time();
	$time1=$time;
	$time= strtotime($time);
    $diff = ($now-$time);
    $secondsLeft = $diff;
    if($secondsLeft >86400)
	{
		return $time1;
	}
	else
	{
    for($i=6;$i>-1;$i--)
    {
         $w[$i] = intval($secondsLeft/$d[$i][0]);
         $secondsLeft -= ($w[$i]*$d[$i][0]);
         if($w[$i]!=0)
         {
            $return.= abs($w[$i]) . " " . $d[$i][1] . (($w[$i]>1)?'s':'') ." ";
         }

    }

    $return .= ($diff>0)?"ago":"left";
    return $return;
	}
}
?>
</body>
</html>