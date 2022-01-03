<?php
require_once "config/database.php";
require_once "helpers/form_validate.php";

require_once 'classes/Crud.php';
require_once 'libs/mailer/MailHandler.php';

$username = $password = $enc_password = $msg = $id = $email = $subject = $message = "";

//$url = "http://www.jamipol.com/apps/lmsv2/admin/";
$crud_obj = new Crud($conn);

if (isset($_POST["username"])) {
    $username = filter_form_data($_POST['username']);
} else {
    //header("Location:index.php");
}

if ($username !== "") {

    try {
        $stmt = $conn->prepare("SELECT * FROM login_master WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        if (!empty($result)) {
            foreach ($result as $row) {
                $id = $row["sno"];
                $email = $row["email_id"];
            }
            $password = "TPL".rand(33333,99999);
            $enc_password = md5($password);
            $update_data = array("password"=>$enc_password);
            $condition = array("id"=>$id);

            $res = $crud_obj->update('login_master',$update_data,$condition);

            if($res!=false)
            {
                $subject = "Important!";
                $message = "Your password has been reset. Please use the given password to login to your dashboard.<br/><br/>Password: ".$password."<br/><br/>Please do not forward this email to prevent unauthorized access to your dashboard. <br/>Please change your password after login. Option for changing password resides at the top-right corner of you dashboard.<br/><br/>This email contains confidential data. If you received this email accidently, please delete this email immediately and notify the sender through e-mail.";
                
                $headers='MIME-Version: 1.0'. "\r\n";
            	$headers.='Content-type: text/html; charset=iso-8859-1' . "\r\n";
            	$headers.='from: Safety Application - Tata Pigments Ltd. <safety@tatapigments.co.in>' . "\r\n" ."CC: safety@tatapigments.co.in". "\r\n" ."BCC: web@sparx.in"."\r\n";
            		
               
                if(mail($email,$subject,$message,$headers)) // Sends email to administrator's email
                {
                    $msg = '<div class="alert alert-success"><button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>An email has been sent to your email. Please check your email to continue login to your dashboard.</div>';
                }
                else
                {
                    $msg = '<div class="alert alert-danger"><button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>There was a problem sending an email. Please try again.</div>';
                }
            }
            else
            {
                $msg = '<label class="error">Something went wrong! Please try again.</label>';
            }
        } else {
            //echo "0 records found";
            $msg = "Ticker No. does not exist.";
        }
    } catch (PDOException $e) {
        //$e->getMessage();
        $msg = "Unable to process";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tatapigments Safety | Forgot Password</title>

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

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <?php echo $msg; ?>
                </div>
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recover Account</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="forgot-password.php" method="post" id="login_form">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" required="required" maxlength="50" placeholder="Username" name="username" type="text" autofocus>
                                    </div>

                                    <input type="submit" value="Recover Account" class="btn btn-block btn-primary">

                                </fieldset>
                            </form>
                        </div>
<!--                         <div class="panel-footer">
                            Forgot Password? <a href="forgot-password.php">Click here</a>
                        </div> -->
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
