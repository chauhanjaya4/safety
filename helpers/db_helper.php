<?php 

// require_once 'user-auth.php';
// require_once '../config/database.php';
// require_once '../classes/Users.php';

function send_pending_leave($leave_id, $user_id, $leave_type, $leave_sub_category, $leave_from, $leave_to, $from_half, $to_half, $final_total_days, $leave_reason, $authority,$level,$level1,$level2,$level3){
	$user_name = Users::get_username($user_id);
	$email = Users::get_email($user_id);

	$app_url = "http://jamipol.com/apps/lmsv2/";

	$approve_url = $app_url."users/leave-action.php?leave_id=" . $leave_id . "&action=approve&level=".$level;
	$disapprove_url = $app_url."users/leave-action.php?leave_id=" . $leave_id . "&action=disapprove&level=".$level;

	$mail_subject = $user_name."'s leave request is pending";
	$msg = "<div class='line-height: 150%; font-family: 'Trebuchet MS','Verdana','Tahoma', sans-serif; font-size: 14px;'><table cellpadding='5' border='0'>";
	$msg .= "<tr><th style='text-align:right;'>Name : </th><td>" . $user_name . "</td></tr>";
	$msg .= "<tr><th style='text-align:right;'>Email : </th><td>" . $email . "</td></tr>";
	$msg .= "<tr><th style='text-align:right;'>Leave Type : </th><td>" . $leave_type ." " .$leave_sub_category. "</td></tr>";
	$msg .= "<tr><th style='text-align:right;'>Leave from : </th><td>" . $leave_from . " (" . $from_half . ")</td></tr>";
	$msg .= "<tr><th style='text-align:right;'>Leave to : </th><td>" . $leave_to . " (" . $to_half . ")</td></tr>";
	$msg .= "<tr><th style='text-align:right;'>No. of Days : </th><td>" . $final_total_days . "</td></tr>";
	$msg .= "<tr><th style='text-align:right;'>Reason for leave : </th><td>" . $leave_reason . "</td></tr>";

	$msg .= "<tr><th><a href='" . $approve_url . "'><button style='border: 0px; border-radius: 4px; padding: 10px;background-color: #39d18c;font-weight: bold;color: #fff;cursor: pointer;'>APPROVE</button></a></th>";
	$msg .= "<th><a href='" . $disapprove_url . "'><button style='border: 0px; border-radius: 4px; padding: 10px;background-color: #d1395f;font-weight: bold;color: #fff;cursor: pointer;'>DISAPPROVE</button></a></th></tr>";

	$msg .= "</table></div>";

	$auth_email = Users::get_email($authority);
    $mail = new MailHandler($mail_subject, $msg);
    $mail->send_mail($auth_email);
    
    update_leave_levels($leave_id, $level1,$level2,$level3);
   // $mail->send_mail('sagar@sparx.in');

}




function find_pending_leaves($user_id){
	$leave_arr = array();
	global $mconn;
	$sql = "select * from jam_leave_requests where user_id = ".$user_id." and (final_status = 'approve' or final_status is null)";
	$leave_res = $mconn->query($sql);
    if ($leave_res) {
        return $leave_res;
    } else {
        $leave_arr = false;
    }
    //return $leave_arr;
}

// $leave_details = find_pending_leaves(203);

// foreach ($leave_details as $ld) {
// 	// print_r($ld);
// 	// echo '<br><br>';
// }


function update_leave_levels($leave_id, $level_one, $level_two, $level_three){

	global $mconn;
	$sql = "UPDATE `jam_leave_requests` SET `level_one_auth`='".$level_one."',`level_two_auth`='".$level_two."',`level_three_auth`='".$level_three."' WHERE id = ".$leave_id;
	$result = $mconn->query($sql);
	if($result){

		return $result;
	}
	else{
		return false;
	}
}

// $update_res = update_leave_levels(957, '23','26','');


?>
