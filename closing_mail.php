<?php
// Include mail library
    require_once 'libs/mailer/MailHandler.php';
    require_once 'helpers/user-auth.php';
    require_once 'config/database.php';

	$cc_arr = array();
	
	/**********Mail for complained closing person**********/
	$mail_stmt =$conn->query("SELECT * FROM `login_master` WHERE  username='".$_SESSION['username']."'");
	$mail_stmt->execute();
	$mail_stmt->setFetchMode(PDO::FETCH_ASSOC);
	$mail_rslt=$mail_stmt->fetchAll();
	foreach($mail_rslt as $mail_row){
	    
	    $email_close=$mail_row['email_id'];
	    $name_close=$mail_row['name'];
	    
	}

	array_push($cc_arr,"pkpsingh@tatapigments.co.in","khalevasant@yahoo.co.in","bnmitra@tatapigments.co.in"); 
	
	$subject = "Safety Observation Closing";
	$body = "<form>
					<html>
						<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"></head>
						<body>
							Safety Observation Form Entry:<br><br>
							<table width='80%' border='0' cellspacing='0' cellpadding='0' style='margin-top:20px; margin-bottom:20px; border: dashed 1px #660000;'>
							  <tr>
								<td height='30' align='left' valign='middle' style='color:#fff; background-color:#751E20; font-family:Arial; font-size:17px; font-weight:bold; padding-left:20px;'>Observed By</td>
							  </tr>
							  <tr>
								<td align='left' valign='middle'><table width='100%' border='0' style='font-weight: bold; font-weight: bold; font-family:Arial; font-size:12px;' cellspacing='0' cellpadding='0' >
								  <tr>
									<td width='25%' height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Name</td>
									<td width='70%' height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$name."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Ticket No. </td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$username."</strong></td>
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
									<td width='70%' height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$_REQUEST['observ_dt']."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Observation Time</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$_REQUEST['time']."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Observation Place</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$_REQUEST['place']."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Observation Categories</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$_REQUEST['categories']."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Observation Type</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$_REQUEST['type']."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Observation Potential</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$_REQUEST['potential']."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Obsevation Description</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>".$_REQUEST['description']."</td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>File Uploaded </td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong><a href='http://tatapigments.co.in/safety/".$_REQUEST['location']."' target='_blank'><img width='55px' height='60px' src='http://tatapigments.co.in/safety/".$location."'/></a></strong></td>
								  </tr>
								</table></td>
							  </tr>
                              <tr>
								<td height='30' align='left' valign='middle' style='color:#fff; background-color:#751E20; font-family:Arial; font-size:17px; font-weight:bold; padding-left:20px;'>Closing Details</td>
							  </tr>
                              <tr>
								<td align='left' valign='middle'><table width='100%' border='0' style='font-weight: bold; font-weight: bold; font-family:Arial; font-size:12px;' cellspacing='0' cellpadding='0' >
								  <tr>
									<td width='25%' height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Closed by</td>
									<td width='70%' height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$name_close."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Total Time taken for work completion</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$time_money."</strong></td>
								  </tr>
								  <tr>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'>Remarks</td>
									<td height='25' align='left' valign='middle' style='padding-left:35px; border-bottom:dotted 1px #660000; border-right:dotted 1px #660000;'><strong>".$remarks."</strong></td>
								  </tr>
								  
								</table></td>
							  </tr>
							</table>	
							  <br><br><a href='http://tatapigments.co.in/safety/'>Click here to Login</a><br><br>*This is an Auto-generated mail. Kindly do not reply to this mail.
						</body>
					</html>
					</form>	";

	// Load mail library
	$mailObj = new MailHandler($subject, $body);

	// Set CC array
	$mailObj->set_cc($cc_arr);

	if ($mailObj->send_mail($email_close))
	{
		//include("closing_reply.php") ;
		print "<script type=\"text/javascript\">";
		print "alert('Job closed.')";
		print "</script>";
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=officers_report.php">';
	}
	else
	{
		print "<script type=\"text/javascript\">";
		print "alert('Failed : Try Again...!!!')";
		print "</script>";
	}
?>