<?php
    //ini_set('display_errors',1);
    // Include mail library
    require_once "libs/mailer/MailHandler.php";
    require_once 'helpers/user-auth.php';
    require_once 'config/database.php';
    require_once 'helpers/form_validate.php';
    
    $id=filter_form_data($_REQUEST['id']);
    $username=filter_form_data($_REQUEST['username']);
    $report_type=filter_form_data($_REQUEST['report_type']);

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
        $assign_to_str = filter_form_data($_POST['assign_to']);
        $assign_to_arr= explode("-", $assign_to_str);
        $assign_to    =$assign_to_arr[0];
        $stmt=$conn->query("select * from login_master where email_id='$assign_to'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rslt=$stmt->fetchAll();
        foreach($rslt as $row){
            
            $asgnd_username=$row['username'];
            $asgnd_duration=filter_form_data($_REQUEST['duration']);
            $asgnd_dept=$row['dept_id'];
            $asgnd_ofcr=$assign_to;
            
            $parent_id=filter_form_data($_REQUEST['id']);

            if(isset($_REQUEST['status'])){
                
                $upd_qry="UPDATE entry_details SET status='Reassigned' WHERE id=$parent_id";
                $conn->query($upd_qry);
                
                $conn->query("CREATE TEMPORARY TABLE tmptable_1 SELECT * FROM entry_details WHERE id = $id");
                $conn->query("UPDATE tmptable_1 SET id = NULL");
                $conn->query("INSERT INTO entry_details SELECT * FROM tmptable_1");
                $id=$conn->lastInsertId();
                $conn->query("DROP TEMPORARY TABLE IF EXISTS tmptable_1");
                
                $upd_qry="UPDATE entry_details SET assign='$asgnd_username',assign_date=CURDATE() ,status='Job Assigned',parent_id=$parent_id,duration='$asgnd_duration',";
                $upd_qry.="assign_dept='$asgnd_dept',officer_name='$asgnd_ofcr' WHERE id='$id'";
                $conn->query($upd_qry);
                
            
            }else{
                $upd_qry="UPDATE entry_details SET assign='$asgnd_username',assign_date=CURDATE() ,status='Job Assigned',duration='$asgnd_duration',";
                $upd_qry.="assign_dept='$asgnd_dept',officer_name='$asgnd_ofcr' WHERE id=$parent_id";
                $conn->query($upd_qry);
            }

    	    include("assign_mail.php");

            if($assign_state)
            {
                print "<script type=\"text/javascript\">";
                print "alert('Job Assigned')";
                print "</script>";

                if($_REQUEST["report_type"]=="re-assign"){
                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=safety_report_total.php">';
                }
            }
        
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
<h1 class="page-header">Assign Requests</h1>
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
            
            $observ_date=$ed_row['observ_date'];
            $categories=$ed_row['categories'];
            $observ_time=$ed_row['observ_time'];
            $type=$ed_row['type'];
            $place=$ed_row['place'];
            $potential=$ed_row['potential'];
            $description=$ed_row['description'];
            $location=(empty($ed_row['location'])?"No file attached":$ed_row["location"]);
            $status=$ed_row['status'];
            $assign=$ed_row['assing_name'];
            $time_money=$ed_row['time_money'];
            $remarks=$ed_row['remarks'];
            
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
                        $href="<a target='_blank' href=".$location." style='color:black;text-decoration:underline;'>Click to see</a>";
                        echo ($location=="No file attached"?$location:$href); 
                    ?>
                </span>
                
                <p class="help-block"></p>
            </div>
        </div>
</fieldset>
<?php 
     if($status=="Reassigned"){
?>
    <fieldset>
        <legend>Assigned Deatils :</legend>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Action Status</label>
                    <input type="text" class="form-control" name="status" readonly value="<?php echo $status; ?>">
                    <p class="help-block"></p>
                </div>
            </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Plan of Action assigned to</label>
                    <input type="text" class="form-control" name="assigned_to" readonly value="<?php echo $assign; ?>">
                <p class="help-block"></p>
            </div>
        </div>  
    </fieldset>
<?php
     }
    else if($status=="Job Assigned"){
?>
    <fieldset>
        <legend>Assigned Deatils :</legend>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Action Status</label>
                    <input type="text" class="form-control" name="status" readonly value="<?php echo $status." (Pending...)"; ?>">
                    <p class="help-block"></p>
                </div>
            </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Plan of Action assigned to</label>
                    <input type="text" class="form-control" name="assigned_to" readonly value="<?php echo $assign; ?>">
                <p class="help-block"></p>
            </div>
        </div>  
    </fieldset>

            <?php if($_SESSION['role']==2){ ?>
            <div class="col-lg-12">
                <fieldset>
                    <legend>Re-assign Action Plan To :</legend>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Department</label>
                                <select  class="form-control" name="dd_dept" id="dd_dept" required title="Select Department!">
                                  <!-- <option value="">--Select--</option> -->
                                  <option value="<?= $_SESSION['dept_id']; ?>"><?= $_SESSION['dept']; ?></option>                      
                                  </select>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Person</label>
                                <select  class="form-control" name="assign_to" id="assign_to">
                                  </select>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Time duration for Action</label>
                                <select  class="form-control" name="duration" id="duration">
                                    <option value="Immediate">Immediate</option>

                                    <option value="1">1 Day</option>

                                    <option value="7">7 Days</option>

                                      <option value="30">30 Days</option>
                    
                                      <option value="90">90 Days</option>

                                      <option value="Project">Project</option>
                                  </select>
                                <p class="help-block"></p>
                            </div>
                        </div>
                </fieldset>
        </div>
        <div class="col-lg-12" align="center">
            <div class="form-group">
                <button class="btn btn-primary" name="btn_submit">Re-assign</button>
                <p class="help-block"></p>
            </div>
        </div>
        <?php
        }
}else if($status=="No Action Taken"){

     if($_SESSION['role']==2){ 
?>
        <fieldset>
            <legend>Assign Action Plan To :</legend>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Department</label>
                        <select  class="form-control" name="dd_dept" id="dd_dept" required title="Select Department!">
                          <option value="">--Select--</option>
                          <?php
        
        					  $dept_stmt=$conn->query("SELECT `id`, `dept` FROM `department`  order by lpad(dept,1,0)");
        					  $dept_stmt->execute();
        					  $dept_stmt->setFetchMode(PDO::FETCH_ASSOC);
        					  $dept_rslt=$dept_stmt->fetchAll();
        					  foreach($dept_rslt as $dept_row){
        					      $dept_id=$dept_row['id'];
        					      $dept_name=$dept_row['dept'];
        					      echo "<option value='".$dept_id."'>".$dept_name."</option>";
        					  }
        				  ?>
        
                          </select>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Person</label>
                        <select  class="form-control" name="assign_to" id="assign_to">
                          </select>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Time duration for Action</label>
                        <select  class="form-control" name="duration" id="duration">
                            <option value="Immediate">Immediate</option>

                            <option value="1">1 Day</option>

                            <option value="7">7 Days</option>

                              <option value="30">30 Days</option>
            
                              <option value="90">90 Days</option>

                              <option value="Project">Project</option>
                          </select>
                        <p class="help-block"></p>
                    </div>
                </div>
        </fieldset>
        <div class="col-lg-12" align="center">
            <div class="form-group">
                <button class="btn btn-primary" name="btn_submit">Submit</button>
                <p class="help-block"></p>
            </div>
        </div>
        
<?php
        }
    }
    else if($status=="Action Taken"){
?>
    <fieldset>
        <legend>Action Details:</legend>
       <div class="col-lg-4">
            <div class="form-group">
                <label>Action Taken</label>
                    <input type="text" class="form-control" name="action_taken" readonly value="<?php echo $status; ?>">
                <p class="help-block"></p>
            </div>
        </div>  
        <div class="col-lg-4">
            <div class="form-group">
                <label>Time Required</label>
                    <input type="text" class="form-control" name="time_required" readonly value="<?php echo $time_money; ?>">
                <p class="help-block"></p>
            </div>
        </div> 
        <div class="col-lg-4">
            <div class="form-group">
                <label>Action Plan</label>
                    <input type="text" class="form-control" name="action_plan" readonly value="<?php echo $remarks; ?>">
                <p class="help-block"></p>
            </div>
        </div>
    </fieldset>
<?php
    }
    
?>
 </fieldset>

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
            

            //ajax call to load emps against dept
            
             $.ajax({
        
                 type: "POST", 
        
                 url: "emp_submaster.php",
        
                 data: {
                    dd_dept : $("#dd_dept").val(),
                    all_emp : true
                 },
        
                 success: function(html) {
        
                     $("#assign_to").html(html);
        
                 }
        
             });
            
            
            
        });
            
        </script>

        <!-- bootstrap datepicker -->
        <script src="assets/vendor/datepicker/bootstrap-datepicker.js"></script>
     
    </body>

</html>
