<?php
    ini_set('display_errors',1);
    //require_once 'helpers/user-auth.php';
    require_once 'config/database.php';
//redirection values

//	$email_to = $assign_to;

    $qry="select * from entry_details ed left join login_master lm on (ed.assign=lm.username)";
    $qry.=" where ed.status='Job Assigned' and lm.status='N' and assign_date!='0000-00-00' and duration!=''";
    $stmt=$conn->query($qry);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rslt=$stmt->fetchAll();

    foreach($rslt as $row){
        $assign_date=date_create($row['assign_date']);
        $duration=$row['duration'];
        $current_date=date_create(date('Y-m-d'));
        $diff=date_diff($assign_date,$current_date);
        $days=$diff->format("%a");
        if($days>$duration){
            $asgnd_username=$row['assign'];
            $email_to=$row['email_id'];
            $id=$row['id'];
            
            $email_to='harpreetsinghjsr@gmail.com';
	
        	$headers='MIME-Version: 1.0'. "\r\n";
        	$headers.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
        	$headers.='from: Safety Application - Tata Pigments Ltd. <sanjeev@sparx.in>' . "\r\n" ."CC: harpreet@sparx.in". "\r\n" ."BCC: web@sparx.in"."\r\n";
        	
        	
        	$email_subject = "Reminder mail";
        	
            
        	$body = "<html>
        				<head></head>
        				<body>
        					Hello ". $asgnd_username.",<br><br>
        					Your due date to take action on the safety work #$id has been passed by $days days. <br><br>Kindly click on the below LINK to update your status.<br>
        					<a href='http://tatapigments.co.in/safety/'>Click here to Login</a>
        					<br><br><br>*This is an Auto-generated mail. Kindly do not reply to this mail.
        				</body>
        			</html>";
        			
        	$body.="<br/>";
        	
        	if (m_ail($email_to,$email_subject,$body,$headers))
        	{
        	    $val="Email To:$email_to,Sub:$email_subject,Username:$asgnd_username,id:$id,days:$days,success";
        	    echo "insert into cron_job_logs(msg) values('$val')";
        	    $conn->query("insert into cron_job_logs(msg) values('$val')");
        	}
        	else
        	{
        		$val="Email To:$email,Sub:$email_subject,Body:$body,Username:$asgnd_username,id:$id,days:$days,failed";
        	    $conn->query("insert into cron_job_logs(msg) values('$val')");
        	}
            
        }
        
    }

   
	
?>