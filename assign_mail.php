<?php

	$email_to = $assign_to = $asgnd_ofcr;

	$email_subject = "Safety Observation Assigned";	
    
	$body = "<html>
				<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"></head>
				<body>
					Hello ". $asgnd_username.",<br><br>
					You are assigned for a Safety Observation Work. <br><br>Kindly click on the below LINK to check the details.<br>
					<a href='http://tatapigments.co.in/safety/'>Click here to Login</a>
					<br><br><br>*This is an Auto-generated mail. Kindly do not reply to this mail.
				</body>
			</html>";
			
	$body.="<br/>";
	
	$cc_arr =  array('pkpsingh@tatapigments.co.in,safety@tatapigments.co.in,khalevasant@yahoo.co.in,bnmitra@tatapigments.co.in');
	
	$mailObj = new MailHandler($email_subject, $body);
    $mailObj->set_cc($cc_arr);

	if($mailObj->send_mail($email_to)) 
		$assign_state=true; 
	else 
		$assign_state=false;
?>