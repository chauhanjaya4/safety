<?php
//ini_set('display_errors',1);
session_start();
require_once 'helpers/form_validate.php';

if(!isset($_SESSION["username"]))
{
	header("location:index.php");
	exit();
}
    require_once "config/database.php";
	if(isset($_POST['name'])){$name= filter_form_data($_POST['name']);}
	if(isset($_POST['dept'])){$dept= filter_form_data($_POST['dept']);}
	if(isset($_POST['desig'])){$desig= filter_form_data($_POST['desig']);}
	if(isset($_POST['email_id'])){$email_id= filter_form_data($_POST['email_id']);}
	if(isset($_POST['mobile_no'])){$mob= filter_form_data($_POST['mobile_no']);}
	if(isset($_POST['username'])){$chk= filter_form_data($_POST['username']);}
	if(isset($_POST['chk_self'])){
		$status= 'Self Closed';
		$asgnd_dept="";
	}else{
		$status='Job Assigned';
		$asgnd_dept=filter_form_data($_POST['dd_dept']);
		$assign_to_str=filter_form_data($_POST['assign_to']);
		$assign_to_arr=explode("-", $assign_to_str);
		$asgnd_username=$assign_to_arr[1];
		$asgnd_ofcr=$assign_to_arr[0];
	} 

	$datetime= $_POST['mm'];
	if(isset($_POST['ob_dt'])) { $date= $_POST['ob_dt']; }
	
	if(isset($_POST['from'])) { $t1= $_POST['from']; }
	if(isset($_POST['to'])) { $t2= $_POST['to']; }
	
	$time= $t1." to ".$t2;
	
	if(isset($_POST['place'])){$place= filter_form_data($_POST['place']);}
	if(isset($_POST['category'])){$cat= $_POST['category'];}
	if(isset($_POST['type'])){$type= $_POST['type'];}
	if(isset($_POST['potential'])){$poten= $_POST['potential'];}
	if(isset($_POST['obv'])){$obv= filter_form_data($_POST['obv']);}
	if(isset($_POST['captcha'])){$cap= $_POST['captcha'];}
	
	//define a maxim size for the uploaded images in Kb
	define ("MAX_SIZE","5060");
	//This function reads the extension of the file. It is used to determine if the file is an image by checking the extension.
	function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
	}
	$errors=0;

	//if it is not empty
	if ($_FILES['upload_file']['error']==0)
	{
		//get the original name of the file from the clients machine
		$filename = stripslashes($_FILES['upload_file']['name']);
		//get the extension of the file in a lower case format
		$extension = getExtension($filename);
		$extension = strtolower($extension);
		//if it is not a known extension, we will suppose it is an error and will not upload the file, 
		//otherwise we will do more tests
		if (($extension != "doc") && ($extension != "docx") && ($extension != "txt") && ($extension != "pdf") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")&& ($extension != "jpg"))
		{
			//print error message
			$errors=1;
			print "<script type=\"text/javascript\">";
			print "alert('Unknown extension!!')";
			print "</script>";
			include("form.php");
		}
		else
		{
			$size=filesize($_FILES['upload_file']['tmp_name']);
			//compare the size with the maxim size we defined and print error if bigger
			if ($size > MAX_SIZE*1024)
			{
				$errors=1;
				print "<script type=\"text/javascript\">";
				print "alert('You have exceeded the file size limit! Please reduce the file size to 1MB or less!')";
				print "</script>";
				include("form.php");
			}
			if(($extension == "jpg") || ($extension == "png") || ($extension == "gif") || ($extension == "jpeg"))
			{
				$img_name= rand().".png";
				//the new name will be containing the full path where will be stored (images folder)
				$newname="images/".$img_name;
			}
			
			if(($extension == "doc") || ($extension == "docx") || ($extension == "txt") || ($extension == "pdf"))
			{
				//we will give an unique name, for example the time in unix time format
				$file_name= rand().".$extension";
				//the new name will be containing the full path where will be stored (images folder)
				$newname="images/".$file_name;
			}
			//we verify if the image has been uploaded, and print error instead
			
			$copied = copy($_FILES['upload_file']['tmp_name'], $newname);
		
			if (!$copied)
			{
				$errors=1;
				print "<script type=\"text/javascript\">";
				print "alert('Copy unsuccessful!')";
				print "</script>";
				include("form.php");
			}
		}
	}


	if(!$errors)
	{
		$ed_qry="INSERT INTO entry_details(username, description, observ_date, observ_time, place, categories, TYPE, potential, reg_no, reg_date,";

		if($asgnd_dept !="")
			$ed_qry.="assign,assign_date,assign_dept,officer_name,";		

		$ed_qry.="location, date_time,status)";
		$ed_qry.=" VALUES('".$chk."', '".$obv."', '".date("Y-m-d",strtotime($date))."', '".$time."', '".$place."', '".$cat."', '".@$type."', '".@$poten."', '".@$reg."', CURDATE(),";

		if($asgnd_dept!="")
			$ed_qry.="'$asgnd_username',CURDATE(),'$asgnd_dept','$asgnd_ofcr',";

		 $ed_qry.="'".$newname."',  NOW(),'".$status."')";

		
		if($conn->query($ed_qry))
		{
		    $sno=$conn->lastInsertId();
    		if(@$newname == "")
    		{
    			$file_loc= "NO FILE SUBMITTED";
    			include("send-email.php");
    		}
    		else
    		{
    			$file_loc= $newname;
    			include("send-email.php");
    		}
		}
		
	}
	else
	{
		print "<script type=\"text/javascript\">";
		print "alert('Copy unsuccessful!')";
		print "</script>";
		include("form.php");
	}
?>