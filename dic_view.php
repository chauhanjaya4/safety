<?php
    //ini_set('display_errors',1);
    require_once 'helpers/form_validate.php';
    require_once 'helpers/user-auth.php';
    require_once 'config/database.php';
    
    $id=filter_form_data($_REQUEST['id']);
    $username=filter_form_data($_REQUEST['username']);

    $stmt=$conn->query("select * from login_master where username='$username'") or die($conn->error());
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rslt=$stmt->fetchAll();
    foreach($rslt as $row){
        $dept       =$row['dept'];
        $email_id   =$row['email_id'];
        $desig      =$row['desig'];
        $mobile_no  =$row['mobile_no'];
        $name       =$row['name'];
    }
    
    if(isset($_REQUEST['btn_submit'])){
        
        $status_sub=filter_form_data($_REQUEST['status']);
        $time_sub=filter_form_data($_REQUEST['time']);
        $remarks_sub=filter_form_data($_REQUEST['remarks']);
        
        $upd_qry="UPDATE entry_details SET time_money='$time_sub',status='$status_sub',remarks='$remarks_sub'";
        $upd_qry.=" WHERE id='".@$_REQUEST['id']."'";
        $conn->query($upd_qry);
	    include("closing_mail.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>TataPigments | Safety</title>

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
                        <h1 class="page-header">Safety Observation Form</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">


                    <div class="panel panel-default">
                        <div class="panel-heading">
<!--                            Fill the form
-->

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
                                    <form role="form" action="" method="post" id="add_user">
                                        <fieldset>
                                            <legend>Employee Information</legend>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <input readonly class="form-control" type="text" name="name" readonly value="<?php echo $name; ?>"  maxlength="50">
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Department</label>
                                                    <input readonly class="form-control" type="text" name="dept" required="required" value="<?php echo $dept; ?>" maxlength="100">
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Designation</label>
                                                    <input class="form-control" readonly type="text" name="desig" value="<?php echo $desig; ?>" maxlength="100">
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Ticket No.</label>
                                                    <input class="form-control" readonly type="text" name="username" value="<?php echo $username; ?>" maxlength="100">
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Mobile</label>
                                                    <input type="text" class="form-control" readonly name="mobile_no" value="<?php echo $mobile_no; ?>" placeholder="Enter mobile number">
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Email Id</label>
                                                    <input type="email" class="form-control" readonly name="email_id" value="<?php echo $email_id; ?>" placeholder="Enter email id">
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php
                                            $ed_qry="select observ_date,categories,observ_time,type,place,potential,description,location,status,md_time,md_remark,";
                                            $ed_qry.="(select name from login_master where username=assign) as assing_name,time_money,remarks from entry_details where id=$id";
                                            $ed_stmt=$conn->query($ed_qry);
                                            $ed_stmt->execute();
                                            $ed_stmt->setFetchMode(PDO::FETCH_ASSOC);
                                            $ed_rslt=$ed_stmt->fetchAll();
                                            foreach($ed_rslt as $ed_row){
                                                
                                                $observ_date        =$ed_row['observ_date'];
                                                $categories         =$ed_row['categories'];
                                                $observ_time        =$ed_row['observ_time'];
                                                $type               =$ed_row['type'];
                                                $place              =$ed_row['place'];
                                                $potential          =$ed_row['potential'];
                                                $description        =$ed_row['description'];
                                                $location           =(empty($ed_row['location'])?"No file attached":$ed_row["location"]);
                                                $status             =$ed_row['status'];
                                                $assign             =$ed_row['assing_name'];
                                                $time_money         =$ed_row['time_money'];
                                                $remarks            =$ed_row['remarks'];
                                                $location           =$ed_row['location'];
                                                $assign_dt          =$ed_row['assign_date'];
                                                
                                            }
                                        ?>
                                        <fieldset>
                                            <legend>Observation Details : </legend>
                                            
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Date:</label>
                                                    <input type="text" class="form-control" name="observ_dt" value="<?php echo $observ_date ?>"  readonly>
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Time:</label>
                                                    <input type="text" class="form-control" name="time" value="<?php echo $observ_time; ?>" readonly>
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Place</label>
                                                    <input type="text" class="form-control" name="place" readonly value="<?php echo $place; ?>">
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Categories</label>
                                                    <input type="text" class="form-control" name="categories" readonly value="<?php echo $categories; ?>">
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <input type="text" class="form-control" name="type" readonly value="<?php echo $type; ?>">
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Potential</label>
                                                    <input type="text" class="form-control" name="potential" readonly value="<?php echo $potential; ?>">
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Short Description</label>
                                                    <textarea class="form-control" rows="5" name="description" readonly><?php echo $description; ?></textarea>
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Uploaded Image/File</label>
                                                    <span class="form-control" style="border:none;">
                                                        <?php 
                                                            $href="<a href=".$location." style='color:black;text-decoration:underline;'>Click to see</a>";
                                                            echo ($location=="No file attached"?$location:$href); 
                                                            ?>
                                                    </span>
                                                    <input type="hidden" name="location" value="<?php echo $location; ?>">
                                                    <p class="help-block"></p>
                                                </div>
                                            </div>
                                    </fieldset>
                                    <fieldset>
                                        <legend>Action Deatils :</legend>
                                    <?php 
                                        if($status=="Reassigned"){
                                    ?>
                                            <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Action Taken</label>
                                                 <input type="text" value="<?php echo $status; ?>" readonly class="form-control" />
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                        else if($status=="Job Assigned"){
                                    ?>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Assigned To:</label>
                                                 <input type="text" value="<?php echo $assign; ?>" class="form-control" name="assign" id="assign" readonly/>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        
                                       <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Assigned Date</label>
                                                  <input type="text" value="<?php echo $assign_dt; ?>" class="form-control" name="assign_dt" id="assign_dt" readonly/>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                       
                                    <?php
                                        }
                                        else{
                                    ?>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Action Taken</label>
                                                 <input type="text" value="<?php echo $status; ?>" readonly class="form-control" />
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Time Taken (In Days)</label>
                                                  <input type="text" value="<?php echo $time_money; ?>" readonly class="form-control"/>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Action Plan Description</label>
                                                  <textarea name="remarks" id="remarks" class="form-control" readonly><?php echo $remarks; ?></textarea><br>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
        <script>
            $(function () {
                $(".select2").select2();
                $('#from').timepicker();
                $('#to').timepicker();
                
                $("[name='category']").change(function(){
                   if($(this).val()==="Near Miss"){
                       $("[name='type']").attr("disabled",true);
                       $("[name='potential']").attr("disabled",true);
                   }else{
                      
                       $("[name='type']").attr("disabled",false);
                       $("[name='potential']").attr("disabled",false);
                   }
                });
            });
        </script>

        <!-- Jquery form validation Plugin -->
        <script src="assets/vendor/validation/jquery.validate.min.js"></script>

        <script>
        $(document).ready(function(){
            $("#add_user").validate();
            
             //Date picker
            $('#dob').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy'
            });

            $('#doj').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy'
            });
            
            $("#dd_dept").bind("change", function() {

                 $.ajax({
            
                     type: "POST", 
            
                     url: "emp_submaster.php",
            
                     data: "dd_dept="+$("#dd_dept").val(),
            
                     success: function(html) {
            
                         $("#assign_to").html(html);
            
                     }
            
                 });
            
             }); 
            
        });
            
        </script>

        <!-- bootstrap datepicker -->
        <script src="assets/vendor/datepicker/bootstrap-datepicker.js"></script>

    </body>

</html>
