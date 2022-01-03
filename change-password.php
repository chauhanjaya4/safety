<?php
date_default_timezone_set('Asia/Kolkata');

session_start();

require_once "config/database.php";
require_once "helpers/form_validate.php";
require_once 'classes/Crud.php';
require_once 'libs/mailer/MailHandler.php';

$user = $email = $password = $new_pass = $cnf_pass = $msg = "";
$subject = $message = $datetime = "";
$datetime = date('d-m-Y H:i:s');

$crud_obj = new Crud($conn);

if(isset($_SESSION['username']) && isset($_SESSION['email_id']))
{
    $user = $_SESSION['username'];
    $email = $_SESSION['email_id'];

    if(isset($_POST['btn-change']))
    {
        if(isset($_POST['curr_password']))
        {
            $password = filter_form_data($_POST['curr_password']);
        }
        if(isset($_POST['new_password']))
        {
            $new_pass = filter_form_data($_POST['new_password']);
        }
        if(isset($_POST['cnf_password']))
        {
            $cnf_pass = filter_form_data($_POST['cnf_password']);
        }
        if($password=="")
        {
            $msg = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Password is required.</div>';
        }
        else if($new_pass=="")
        {
            $msg = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>New Password is required.</div>';
        }
        else if($cnf_pass=="")
        {
            $msg = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Confirm Password is required.</div>';
        }
        else if($new_pass!==$cnf_pass)
        {
            $msg = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>New Passwords do not match.</div>';
        }
        else
        {
            $en_pass = md5($password);
            $admin_res = $crud_obj->select("login_master", array("username" => $user, "operator" => "and", "password" => $en_pass));
            if($admin_res===false)
            {
                $msg = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Your current password is wrong.</div>';
            }
            else
            {
                foreach($admin_res as $admin_row)
                {
                    $id = $admin_row["sno"];
                }
                $en_pass = md5($password);
                $en_new_pass = md5($new_pass);
                $update_data = array("password"=>$en_new_pass);
                $condition = array("sno" => $id);
                $res = $crud_obj->update('login_master', $update_data, $condition);

                if($res!==false)
                {
                    $msg = '<div class="alert alert-success"><button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Your password changed successfully.</div>';
                    $subject = "Password Changed";
                    $message = "Your password was changed on ".$datetime;
                    $headers='MIME-Version: 1.0'. "\r\n";
                	$headers.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
                	$headers.='from: Safety Application - Tata Pigments Ltd. <safety@tatapigments.co.in>' . "\r\n" ."CC: safety@tatapigments.co.in". "\r\n" ."BCC: web@sparx.in"."\r\n";
                		
	                mail($email,$subject,$message,$headers);
                }
                else
                {
                    echo 'Update password failed';
                }
            }
        }
    }
}
else
{
    header('Location:index.php');
}

// ================== END OF CODE ================================

?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tatapigments Safety | Change Password</title>

        <!-- Bootstrap Core CSS -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="assets/dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- Custom End User CSS -->
        <link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
	<div id="wrapper">
            <!-- Navigation -->
            <?php include "templates/header.php"; ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <?php echo $msg; ?>
                </div>
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-primary" style="border-radius:0px;">
                        <div class="panel-heading" style="border-radius:0px;">
                            <h3 class="panel-title">Change Password</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="change-password.php" method="post" id="login_form">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" required="required" maxlength="50" placeholder="Current Password" name="curr_password" type="password" autofocus style="border-radius:0px;">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" required="required" maxlength="20" placeholder="New Password" name="new_password" type="password" value="" style="border-radius:0px;">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" required="required" maxlength="20" placeholder="Confirm Password" name="cnf_password" type="password" value="" style="border-radius:0px;">
                                    </div>

                                    <input type="submit" name="btn-change" value="Change Password" class="btn btn-block btn-primary">

                                </fieldset>
                            </form>
                        </div>
                        <!-- <div class="panel-footer">
                            Forgot Password? <a href="forgot-password.php">Click here</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
      </div>

        <!-- jQuery -->
        <script src="assets/vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="assets/vendor/metisMenu/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="assets/dist/js/sb-admin-2.js"></script>

        <!-- Jquery form validation Plugin -->
        <script src="assets/vendor/validation/jquery.validate.min.js"></script>

        <script>
            $("#login_form").validate();
        </script>

    </body>

</html>
