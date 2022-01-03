<?php

    require_once 'libs/mailer/MailHandler.php';

	$dept = $_REQUEST['dept'];
	$email_id= $_REQUEST['email_id'];

	$cc_arr =  array('safety@tatapigments.co.in','pkpsingh@tatapigments.co.in','khalevasant@yahoo.co.in','bnmitra@tatapigments.co.in'); 


	if($status=='Self Closed')
		$subject = "Self Closed- Safety Observation Form Entry";
	else
		$subject = "Safety Observation Form Entry";

	$body = "<form>
					<html>
						<head></head>
						<body>
							Safety Observation Form Entry:<br><br>
							<table width='80%' border='0' cellspacing='0' cellpadding='0' style='margin-top:20px; margin-bottom:20px; border: dashed 1px #660000;'>
							  <tr>
								<td height='30' align='left' valign='middle' style='color:#fff; background-color:#751E20; font-family:Arial; font-size:17px; font-weight:bold; padding-left:20px;'>Personal Information</td>
							  </tr>
							  <tr>
								<td align='left' valign='middle'><table width='100%' border='0' style='font-weight: bold; font-weight: bold; font-family:Arial; font-size:12px;' cellspacing='0' cellpadding='0' >
								  <tr>
									<td width='25%' height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Name</td>
									<td width='70%' height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$name."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Ticket No. </td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$chk."</strong></td>
								  </tr>
<tr>                              <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Serial No. </td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$sno."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Department/Site </td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$dept."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Designation </td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$desig."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Email </td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$email_id."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Mobile No.</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$mobile_no."</strong></td>
								  </tr>
								</table></td>
							  </tr>
							  <tr>
								<td height='30' align='left' valign='middle' style='color:#fff; background-color:#751E20; font-family:Arial; font-size:17px; font-weight:bold; padding-left:20px;'>Observation Details</td>
							  </tr>
							  <tr>
								<td align='left' valign='middle'><table width='100%' border='0' style='font-weight: bold; font-weight: bold; font-family:Arial; font-size:12px;' cellspacing='0' cellpadding='0' >
								  <tr>
									<td width='25%' height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Observation Date</td>
									<td width='70%' height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$date."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Observation Time</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$time."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Observation Place</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$place."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Observation Categories</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$cat."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Observation Type</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".@$type."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Observation Potential</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".@$poten."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Obsevation Description</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>".$obv."</td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>File Uploaded </td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong><a href='http://tatapigments.co.in/safety/".$file_loc."' target='_blank'>Click here to see the file</a></strong></td>
								  </tr>
								</table></td>
							  </tr>
							</table>	
							  <br><br><a href='http://tatapigments.co.in/safety/'>Click here to Login</a><br><br>*This is an Auto-generated mail. Kindly do not reply to this mail.
						</body>
					</html>
					</form>
	";
	$body.="<br/>";
	
	$mailObj = new MailHandler($subject, $body);
    $mailObj->set_cc($cc_arr);

	if ($mailObj->send_mail($email_id)){
		
		if($status!='Self Closed')
		include("assign_mail.php");
		include("reply.php") ;
			
	}
	else{
		print "<script type=\"text/javascript\">";
		print "alert('Failed : Try Again...!!!')";
		print "</script>";
	}
?>