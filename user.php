<?php
require_once 'helpers/user-auth.php';
require_once 'config/database.php';
require_once 'classes/Crud.php';

$crud_obj = new Crud($conn);
?>
<!DOCTYPE html>
<html lang="en">

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tatapigment Safety | Add User</title>

        <!-- Bootstrap Core CSS -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="assets/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="assets/dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="assets/vendor/morrisjs/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- Select2 CSS File -->
        <link rel="stylesheet" type="text/css" href="assets/vendor/select2/select2.min.css">

        <!-- Custom End User CSS -->
        <link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">

        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="assets/vendor/datepicker/datepicker3.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
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
                    <div class="col-lg-12">
                        <h1 class="page-header">Add User</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add User Details


                            <span class="pull-right" style="color: #00b110; font-weight: 600;">
                                <?php
                                echo (isset($_SESSION["msg"])) ? $_SESSION["msg"] : "";
                                $_SESSION["msg"] = "";
                                ?>
                               
                            </span>

                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" action="user_data.php" method="post" id="add_user">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input placeholder="Enter Name" class="form-control" type="text" name="name" required="required" maxlength="50">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input placeholder="Enter email" class="form-control" type="email" name="email_id" required="required" maxlength="100">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input type="text" class="form-control" name="mobile" placeholder="Enter mobile number">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Ticket Number</label>
                                                <input type="text" class="form-control" name="username" placeholder="Enter ticket number" required="required">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <select id="category-group" class="form-control" name="department" required="required">
                                                    <option value="">---Select Department---</option>
                                                    <?php
                                                    $department_data = $crud_obj->select("department",array("revised"=>"Yes"));
                                                    if ($department_data !== false) {
                                                        foreach ($department_data as $dept_row) {
                                                            $selected = "";
                                                            if (isset($preset_arr["department"])) {
                                                                if ($preset_arr["department"] === $dept_row["id"]) {
                                                                    $selected = " selected='selected'";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                            } else {
                                                                $selected = "";
                                                            }
                                                            ?>
                                                            <option value="<?php echo $dept_row["id"]."-".$dept_row["dept"]; ?>" <?php echo $selected; ?>><?php echo $dept_row["dept"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Committee</label>
                                                <select id="category-group" class="form-control" name="committee" required="required">
                                                    <option value="">---Select Committee---</option>
                                                    <?php
                                                    $comm_data = $crud_obj->select("committee_master");
                                                    if ($comm_data !== false) {
                                                        foreach ($comm_data as $comm_row) {
                                                            $selected = "";
                                                            if (isset($preset_arr["committee"])) {
                                                                if ($preset_arr["committee"] === $comm_row["id"]) {
                                                                    $selected = " selected='selected'";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                            } else {
                                                                $selected = "";
                                                            }
                                                            ?>
                                                            <option value="<?php echo $comm_row["id"]."-".$comm_row["committee"]; ?>" <?php echo $selected; ?>><?php echo $comm_row["committee"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Designation</label>
                                                <input placeholder="Enter designation" class="form-control" type="text" name="designation" maxlength="200" required="required">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Role</label>
                                                <select class="form-control" name="role" required="required">
                                                    <option value="">---Select---</option>
                                                    <option value="0">Employee</option>
                                                    <option value="1">TPL Admin</option>
                                                    <option value="2">Officer</option>
                                                    <option value="3">MD</option>
                                                    <option value="4">DIC HOD</option>

                                                </select>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <button class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->


                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>



                </div>
                <!-- /.row -->
                <div class="row">


                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="assets/vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="assets/vendor/metisMenu/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="assets/dist/js/sb-admin-2.js"></script>

        <!-- Select2 JS File -->
        <script type="text/javascript" src="assets/vendor/select2/select2.full.min.js"></script>

        <script>
            $(function () {
                $(".select2").select2();


            });
        </script>

        <!-- Jquery form validation Plugin -->
        <script src="assets/vendor/validation/jquery.validate.min.js"></script>

        <script>
            $("#add_user").validate();
        </script>

        <!-- bootstrap datepicker -->
        <script src="assets/vendor/datepicker/bootstrap-datepicker.js"></script>

        <script>
            //Date picker
            $('#dob').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy'
            });

            $('#doj').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy'
            });
     </script>

    </body>

</html>
