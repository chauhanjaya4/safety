<?php
require_once 'helpers/user-auth.php';
require_once 'helpers/form_validate.php';
require_once 'config/database.php';
require_once 'classes/Crud.php';

$crud_obj = new Crud($conn);
$user_add = "";
if (isset($_POST["name"])) {
    //$plant_name = filter_form_data($data);

    $name = filter_form_data($_POST["name"]);
    $username = filter_form_data($_POST["username"]);
    $email = filter_form_data($_POST["email_id"]);
    $mobile = filter_form_data($_POST["mobile"]);
    $department = explode("-",filter_form_data($_POST["department"]));
    $committee = explode("-",filter_form_data($_POST["committee"]));
    $designation = filter_form_data($_POST["designation"]);
    $role = filter_form_data($_POST["role"]);

    $password = "tpl@123";


    // Preparing data 
    $user_data = array(
        "name" => $name,
        "username" => $username,
        "password" => md5($password),
        "email_id" => $email,
        "role" => $role,
        "mobile_no" => $mobile,
        "dept_id" => $department[0],
        "committee_id" => $committee[0],
        "dept"=>$department[1],
        "desig" => $designation
    );

    //echo json_encode($user_data);

    try {
        // Create crud object


        if ($crud_obj->insert("login_master", $user_data) !== false) {

            //echo "Successfully Added";
            $_SESSION["msg"] = "User added successfully";
        } else {
           // echo "Failed ";
            $_SESSION["msg"] = "Failed ! Try again";
        }

        //echo "<meta http-equiv='refresh' content='0'>";
    } catch (PDOException $e) {
        $_SESSION["msg"] = "Something went wrong";

        echo $e->getMessage();
    }

    header("Location:user.php");
    exit();
}
?>