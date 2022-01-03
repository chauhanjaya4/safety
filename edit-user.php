<?php
require_once 'helpers/user-auth.php';
require_once 'config/database.php';
require_once 'classes/Crud.php';
require_once 'helpers/form_validate.php';

$crud_obj = new Crud($conn);
$user_arr = array();

if (isset($_POST["form_name"]) && $_POST["form_name"] === "edit_user") {
    $user_id = filter_form_data($_POST["user_id"]);
    $name = filter_form_data($_POST["name"]);
    $username = filter_form_data($_POST["username"]);
    $email_id = filter_form_data($_POST["email_id"]);
    $mobile_no = filter_form_data($_POST["mobile_no"]);
    $department = explode("-",filter_form_data($_POST["department"]));
    $dept_id=$department[0];
    $dept=$department[1];
    $desig = filter_form_data($_POST["desig"]);
    $role = filter_form_data($_POST["role"]);
    $block_user = filter_form_data($_POST["block_user"]);

    // Preparing data 
    $user_data = array(
        "name"      => $name,
        "username"  => $username,
        "email_id"  => $email_id,
        "mobile_no" => $mobile_no,
        "dept_id"   => $dept_id,
        "dept"      => $dept,
        "desig"     => $desig,
        "role"      => $role,
        "status"    => $block_user
    );
    
    //echo json_encode($user_data);
    //exit();

    $update_condition = array(
        "sno" => $user_id
    );

    $user_update = $crud_obj->update("login_master", $user_data, $update_condition);
    if ($user_update !== false) {
         exit("<h3>Updated Successfully</h3>");
   
   
     /*    $close = $('<button type="button"/>').attr({id:prefix+'Close'});
        $("button#cboxClose").click(function(){
            publicMethod.close();
        })
        $close.trigger( "click" );
       
        window.close();*/
   
 
    } else {
       header("Location:edit-user.php?user_id=$user_id");
       //print_r($conn->errorInfo());
      // exit();
    }
} else if (isset($_GET["user_id"])) {
    $user_id = filter_form_data($_GET["user_id"]);
    $user_data = $crud_obj->select("login_master", array("sno" => $user_id));
    if ($user_data !== false) {
        foreach ($user_data as $urow) {
            $user_arr = $urow;
        }
    } else {
        header("Location:dashboard.php");
    }
} else {
    header("Location:dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tatapigment Safety | Manage Users</title>
 <!-- jQuery -->
        <script src="assets/vendor/jquery/jquery.min.js"></script>
        <!-- Bootstrap Core CSS -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    </head>

    <body>

        <div class="col-lg-12">
            <form role="form" action="edit-user.php" method="post" id="add_plant">
                <input type="hidden" name="form_name" value="edit_user">
                <input type="hidden" name="user_id" value="<?php echo $user_arr["sno"]; ?>">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Ticket No.</label>
                        <input placeholder="Enter Name" value="<?php echo $user_arr["username"]; ?>" class="form-control" type="text" name="username" readonly maxlength="50">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input placeholder="Enter Name" value="<?php echo $user_arr["name"]; ?>" class="form-control" type="text" name="name" required="required" maxlength="50">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input placeholder="Enter email" value="<?php echo $user_arr["email_id"]; ?>" class="form-control" type="email" name="email_id" required="required" maxlength="100">
                        <p class="help-block"></p>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Mobile</label>
                        <input type="text" value="<?php echo $user_arr["mobile_no"]; ?>" class="form-control" name="mobile_no" placeholder="Enter mobile number">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Department</label>
                        <select id="category-group" class="form-control" name="department" required="required">
                            <option value="">---Select Department---</option>
                            <?php
                            $department_data = $crud_obj->select("department",array("revised"=>"yes"));
                            if ($department_data !== false) {
                                foreach ($department_data as $dept_row) {
                                    $selected = "";
                                    if (isset($user_arr["dept_id"])) {
                                        if ($user_arr["dept_id"] === $dept_row["id"]) {
                                            $selected = " selected='selected'";
                                        } else {
                                            $selected = "";
                                        }
                                    } else {
                                        $selected = "";
                                    }
                                    ?>
                                    <option value="<?php echo $dept_row["id"]."-".$dept_row['dept']; ?>" <?php echo $selected; ?>><?php echo $dept_row["dept"]; ?></option>
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
                        <input placeholder="Enter designation" value="<?php echo $user_arr["desig"]; ?>" class="form-control" type="text" name="desig" maxlength="200" required="required">
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="role" required="required">
                            <option value="">---Select---</option>
                            <?php
                                $emp = $admin = $res_usr = $md = "";
                                if ($user_arr["role"] == 0) {
                                    $emp = "selected = 'selected'";
                                } else if ($user_arr["role"] == 1) {
                                    $admin = "selected = 'selected'";
                                } else if ($user_arr["role"] == 2) {
                                    $res_usr = "selected = 'selected'";
                                } else if ($user_arr["role"] == 3) {
                                    $md = "selected = 'selected'";
                                }else if ($user_arr["role"] == 4) {
                                    $hod = "selected = 'selected'";
                                }
                               
                               
                            ?>
                            <option value="0" <?php echo $emp; ?>>Employee</option>
                            <option value="1" <?php echo $admin; ?>>Admin</option>
                            <option value="2" <?php echo $res_usr; ?>>Officer</option>
                            <option value="3" <?php echo $md; ?>>MD</option>
                            <option value="4" <?php echo $hod; ?>>DIC HOD</option>

                        </select>
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Block User</label>
                        <select name="block_user" class="form-control">
                            <option value="">--Select--</option>
                            <?php
                                $st_active = $st_blocked = "";
                                
                                if($user_arr["status"] === "Y"){
                                     $st_blocked = "selected='selected'";
                                }else if($user_arr["status"] === "N"){
                                    $st_active = "selected='selected'";
                                }
                            ?>
                            <option value="N" <?php echo $st_active; ?>>No</option>
                            <option value="Y" <?php echo $st_blocked; ?>>Yes</option>
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

       


        <!-- Bootstrap Core JavaScript -->
        <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Jquery form validation                Plugin -->
        <script src="assets/vendor/validation/jquery.validate.min.js"></script>
       
    </body>

</html>
