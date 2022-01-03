<?php
ini_set('display_errors',1);
require_once "config/database.php";
require_once "helpers/form_validate.php";

$username = $password = $msg = "";


if (isset($_POST["username"])) {
    $username = filter_form_data($_POST['username']);
} else {
    //header("Location:index.php");
}

if (isset($_POST['password'])) {
    $password = filter_form_data($_POST['password']);
} else {
    // header("Location:index.php");
}

if ($username !== "" && $password !== "") {

    $en_password = md5($password);

    try {
        $stmt = $conn->prepare("SELECT * FROM login_master WHERE username = :username and password = :password and status='N'");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $en_password);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        if (!empty($result)) {
            foreach ($result as $row) {
                //echo $row["email"];
                session_start();
                $_SESSION["username"]           = $row["username"];
                $_SESSION["role"]               = $row['role'];
                $_SESSION["name"]               = $row["name"];
                $_SESSION["dept"]               = $row["dept"];
                $_SESSION["dept_id"]            = $row["dept_id"];
                $_SESSION["desig"]              = $row["desig"];
                $_SESSION["mobile_no"]          = $row["mobile_no"];
                $_SESSION["email_id"]           = $row["email_id"];
                $_SESSION["committee_id"]       = $row["committee_id"];
                header("Location:dashboard.php");
            }
        } else {
            //echo "0 records found";
            $msg = "Username or password is wrong";
        }
    } catch (PDOException $e) {
        //$e->getMessage();
        $msg = "Unable to process";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tata Pigment | Safety</title>

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
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="index.php" method="post" id="login_form">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" required="required" maxlength="50" placeholder="Ticket No." name="username" type="text" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" required="required" maxlength="20" placeholder="Password" name="password" type="password" value="">
                                    </div>

                                    <?php
                                    if ($msg !== "") {
                                        echo "<label class='error'>$msg</label>";
                                    }
                                    ?>

                                    <input type="submit" value="Login" class="btn btn-block btn-primary">

                                </fieldset>
                            </form>
                        </div>
                        <div class="panel-footer">
                            Forgot Password? <a href="forgot-password.php" style="text-decoration:underline;color:black;">Click here</a>
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
