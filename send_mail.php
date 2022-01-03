<?php
//ini_set('display_errors',1);
require_once 'libs/mailer/MailHandler.php';
require_once 'helpers/user-auth.php';
require_once 'config/database.php';


$stmt=$conn->query("SELECT description, observ_date, observ_time, status, md_remark, md_time, date_time, assign FROM entry_details WHERE   id=".$id."");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$rslt=$stmt->fetchAll();
foreach($rslt as $row){
    $entry_date= date('Y-m-d', strtotime($row['date_time']));
    $status=$row['status'];
}

    $now = time(); // or your date as well
    $your_date = strtotime($entry_date);
    $datediff = $now - $your_date;
    $d = floor($datediff/(60*60*24))+1;
//mail

	if($status == 'Job Assigned')
	{
		$det_stmt= $conn->query("SELECT name, email_id FROM login_master WHERE username= (SELECT assign FROM entry_details WHERE id='".$id."')");
        $det_stmt->execute();
        $det_stmt->setFetchMode(PDO::FETCH_ASSOC);
        $det_rslt=$det_stmt->fetchAll();
        foreach($det_rslt as $det_row)
		$email_to = $det_row['email'];
		
	$cc_arr =  array('pkpsingh@tatapigments.co.in,safety@tatapigments.co.in,khalevasant@yahoo.co.in,bnmitra@tatapigments.co.in');

	}
	if($status == 'No Action Taken')
	{
		$email_to = "pkpsingh@tatapigments.co.in";
	
	}

	$subject = "Action Mail from MD, Tata Pigments Ltd.";
	$body = "
	<html>
		<head></head>
		<body>
			Safety Observation Form Entry:<br><br>
			<table width='971' border='0' style='font-weight: bold; font-weight: bold; font-family:Arial; font-size:12px;' cellspacing='0' cellpadding='0'>
			  <tr>
				<td height='33' colspan='7' align='left' valign='middle' style='color:#fff; background-color:#751E20; font-family:Arial; font-size:17px; font-weight:bold; padding-left:10px; border:dashed 1px #fff; border-bottom:dashed 1px #BE797B;'>Action Mail from MD, Tata Pigments Ltd.</td>
			  </tr>
			  <tr bgcolor='#BE797B' style='font-size:14px;'>
				<td width='301' height='29' align='center' valign='middle' nowrap style='text-align: center; border-bottom:dashed 1px #660000; border-left:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>Observation Details</td>
				<td width='98' align='center' valign='middle' nowrap style='text-align: center; border-bottom:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>Date &amp; Time</td>
				<td width='77' align='center' valign='middle' nowrap style='text-align: center; border-bottom:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>Status</td>
				<td width='84' align='center' valign='middle' nowrap style='text-align: center; border-bottom:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>Due by</td>
				<td width='304' align='center' valign='middle' nowrap style='text-align: center; border-bottom:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>MD's Remarks</td>
				<td width='107' align='center' valign='middle' nowrap style='text-align: center; border-bottom:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>Allotted Time</td>
			  </tr>
			  <tr>
				<td nowrap width='301' height='49' align='center' valign='middle' style='text-align: center; border-bottom:dashed 1px #660000; border-left:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>".$row['description']."</td>
				<td nowrap width='98' align='center' valign='middle' style='text-align: center; border-bottom:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>".$row['observ_date']."<br>".$row['observ_time']."</td>
				<td nowrap width='77' align='center' valign='middle' style='text-align: center; border-bottom:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>".$row['status']."</td>
				<td nowrap width='84' align='center' valign='middle' style='text-align: center; border-bottom:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>".$d." days</td>
				<td nowrap width='304' align='center' valign='middle' style='text-align: center; border-bottom:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>".$row['md_remark']."</td>
				<td nowrap width='107' align='center' valign='middle' style='text-align: center; border-bottom:dashed 1px #660000; border-right:dashed 1px #660000; padding-left:7px; padding-right:7px'>".$row['md_time']." days</td>
			  </tr>
			</table>
			<br><br><a href='http://tatapigments.co.in/safety/'>Click here to Login</a><br><br>*This is an Auto-generated mail. Kindly do not reply to this mail.
		</body>
	</html>";
$body.="<br/>";


// Load mail library
	$mailObj = new MailHandler($subject, $body);

	// Set CC array
	$mailObj->set_cc($cc_arr);

	if ($mailObj->send_mail($email_to))
	{
		print "<script type=\"text/javascript\">";
		print "alert('Done... Mail Sent... !');window.location='md_report.php?id=".$_REQUEST['id']."&tkt=".$_REQUEST['tkt']."&name=".$_REQUEST['name']."' ";
		print "</script>";
		//echo '<META HTTP-EQUIV="Refresh" Content="0; URL=md_panel.php?id="'.$_REQUEST["id"].'"&tkt="'.$_REQUEST['tkt'].'"&name="'.$_REQUEST['name'].'"">';
		//include('md_panel.php');
	}
	else
	{
		print "<script type=\"text/javascript\">";
		print "alert('Failed : Try Again...!!!')";
		print "</script>";
	}
?>
