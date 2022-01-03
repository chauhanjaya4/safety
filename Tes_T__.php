<?php
    require_once 'config/database.php';
  /*  
    $stmt=$conn->query("select * from entry details where status='Reassigned'");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rslt=$stmt->fetchAll();
    foreach($rslt as $row){
        $parent_id=$row['id'];
        $stmt_b=$conn->query("select * from entry_details where description='".$row['description']."'");
        $stmt_b->execute();
        $rslt_b=$stmt_b->fetchAll();
        foreach($rslt_b as $row_b){
            
            $stmt_c=$conn->query("update entry_details set req_no='".$parent_id."',status='Reassigned',parent_id= where id=".$row_b['id']); //child
            $stmt_c->execute();
            
            $stmt_c=$conn->query("update entry_details set parent_id='".$parent_id."' where id=".$row_b['id']);
            $stmt_c->execute();
        }
    }
    */

// Include mail library
/*require_once "libs/mailer/MailHandler.php";

	//$email_to = "web@sparx.in";
	
	//$cc_arr =  array('safety@tatapigments.co.in','sweta@sparx.in');
	$email_subject = "Safety Observation Form Entry";
	
    
	$body = "<html>
				<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
				<body>
					Hello ,<br><br>
					You are assigned for a Safety Observation Work. <br><br>Kindly click on the below LINK to check the datails.<br>
					<a href='http://tatapigments.co.in/safety/'>Click here to Login</a>
					<br><br><br>*This is an Auto-generated mail. Kindly do not reply to this mail.
				</body>
			</html>";
	$body.="<br/>";
	
	$mailObj = new MailHandler($email_subject, $body);

	if ($mailObj->send_mail('web@sparx.in'))
	{
		print "<script type=\"text/javascript\">";
		print "alert('Job Assigned')";
		print "</script>";
	}
	else
	{
		print "<script type=\"text/javascript\">";
		print "alert('Failed : Try Again...!!!')";
		print "</script>";
	}*/