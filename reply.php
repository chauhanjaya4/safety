<?php

	$email_to = $email_id;

	$email_subject = $subject;

	if($status=='Self Closed'){
		$msg="Hello ".$name.",<br><br> Thank you for your Observation and it is highly appreciated.";
		$alert="Thank You";
	}
	else{
		$msg="Hello ".$name.",<br><br>Thank you for contacting us. We will be in touch with you soon.";
		$alert="Thank You for contacting us";
	}

	$email_message = "
					<html>
						<head></head>
						<body>
							
							".$msg."<br><br>
							<table width='80%' border='0' cellspacing='0' cellpadding='0' style='margin-top:20px; margin-bottom:20px; border: dashed 1px #660000;'>
								<tr>
									<td height='30' align='left' valign='middle' style='color:#fff; background-color:#751E20; font-family:Arial; font-size:17px; font-weight:bold; padding-left:20px;'>Observation Details </td>
								</tr>
								<tr>
									<td>
										<table width='100%' border='0' style='font-weight: bold; font-weight: bold; font-family:Arial; font-size:12px;' cellspacing='0' cellpadding='0' >
										<tr>
										<td width='25%' height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Obsevation Description</td>
										<td width='70%' height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>".$obv."</td>
										</tr>
										<tr>
										<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>File Uploaded </td>
									    <td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong><a href='http://tatapigments.co.in/safety/".$file_loc."' target='_blank'>Click here to see the file</a></strong></td>
										</tr>
										</table>
									</td>
								</tr>
							</table>	
							  <br><br><br>*This is an Auto-generated mail. Kindly do not reply to this mail.
						
						</body>
					</html>";
	
		// Load mail library
	$mailObj = new MailHandler($email_subject, $email_message);

	// Set CC array
	//$mailObj->set_cc($cc_arr);
	if ($mailObj->send_mail($email_to)){
	    
		print "<script type=\"text/javascript\">";
		print "alert('".$alert."')";
		print "</script>";
		include("dashboard.php") ;
	}
	else{
		print "<script type=\"text/javascript\">";
		print "alert('Failed : Try Again...!!!')";
		print "</script>";
	}
?>
