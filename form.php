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
                            Fill the form


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
<form role="form" action="load.php" method="post" id="add_user" enctype="multipart/form-data">
<fieldset>
<legend>Employee Information</legend>
<div class="col-lg-6">
<div class="form-group">
<label>Full Name</label>
<input readonly class="form-control" type="text" name="name" required="required" value="<?php echo $_SESSION['name']; ?>" maxlength="50">
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Department</label>
<input readonly class="form-control" type="text" name="dept" required="required" value="<?php echo $_SESSION['dept']; ?>" maxlength="100">
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Designation</label>
<input class="form-control" readonly type="text" name="desig" value="<?php echo $_SESSION['desig']; ?>" maxlength="100">
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Ticket No.</label>
<input class="form-control" readonly type="text" name="username" value="<?php echo $_SESSION['username']; ?>" maxlength="100">
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Mobile</label>
<input type="text" class="form-control" readonly name="mobile_no" value="<?php echo $_SESSION['mobile_no']; ?>" placeholder="Enter mobile number">
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Email Id</label>
<input type="email" class="form-control" readonly name="email_id" value="<?php echo $_SESSION['email_id']; ?>" placeholder="Enter email id">
<p class="help-block"></p>
</div>
</div>
</fieldset>
<fieldset>
<legend>Observation Details :</legend>
<div class="col-lg-6">
<div class="form-group">
<label>Date:</label>
<input type="text" class="form-control" name="ob_dt" id="ob_dt" readonly required>
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>From:</label>
<input type="text" class="form-control" name="from" id="from" readonly required>
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>To:</label>
<input type="text" class="form-control" name="to" id="to" readonly required>
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Place</label>
<input type="text" class="form-control" name="place" placeholder="Enter Place" required>
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Category</label>
<select name="category" class="form-control" required>
<option value="">Category</option>
<!--<option value="0" selected="selected">Category</option>
--><option value="Near Miss">Near Miss</option>
<option value="Reactions of People">Reactions of People</option>
<option value="Positions of People">Positions of People</option>
<option value="Personal Protective Equipment">Personal Protective Equipment</option>
<option value="Tools and Equipment">Tools and Equipment</option>
<option value="Procedures and Housekeeping">Procedures and Housekeeping</option>
<option value="Ergonomics">Ergonomics</option>
</select>
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Type</label>
<select name="type" class="form-control" required>
<option value="">Type</option>
<option value="Unsafe Condition">Unsafe Condition</option>
<option value="Safe Condition">Safe Condition</option>
<option value="Unsafe Act">Unsafe Act</option>
<option value="Safe Act">Safe Act</option>
</select>
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>Potential</label>
<select name="potential" class="form-control" required>
<option value="">Potential</option>
<option value="Fatality">Fatality</option>
<option value="Serious Injury">Serious Injury</option>
<option value="Minor Injury">Minor Injury</option>
</select>
<p class="help-block"></p>
</div>
</div>
</legend>
</fieldset>

<fieldset>
<legend></legend>
<div class="col-lg-12">
<div class="form-group">
<label>Short Description</label>
<textarea class="form-control" placeholder="Enter Description" rows="5" name="obv"></textarea>
<p class="help-block"></p>
</div>
</div>  

<div class="col-lg-12">
<div class="form-group">
<label>Self Closed</label>
<input type="checkbox" name="chk_self">
<p class="help-block"></p>
</div>
</div>

<div class="col-lg-6">
<div class="form-group">
<label>Image/file upload</label>
<input type="file" name="upload_file" class="form-control" placeholder="(Only . doc, .docx, .txt, .pdf, .jpeg, .jpg, .png, .gif)">
<p class="help-block"></p>
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<label>&nbsp;</label>
<label style="margin-top:5%">(Only . doc, .docx, .txt, .pdf, .jpeg, .jpg, .png, .gif)</label>

</div>
</div>
</fieldset>
<br>
<div class="col-md-12" id="assign_action">
	<fieldset>
    <legend><h5>Assign Action Plan To :</h5></legend>
        <div class="col-md-6">
            <div class="form-group">
                <label>Department</label>
                <select  class="form-control" name="dd_dept" id="dd_dept" required title="Select Department!">
                  <option value="">--Select--</option>
                  <?php

					  $dept_stmt=$conn->query("SELECT `id`, `dept` FROM `department` where revised='Yes'");
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
        <div class="col-md-6">
            <div class="form-group">
                <label>Person</label>
                <select  class="form-control" name="assign_to" id="assign_to">
                  </select>
                <p class="help-block"></p>
            </div>
        </div>        
</fieldset>
</div>


<div class="col-lg-12" align="center">
<div class="form-group">
<button class="btn btn-primary">Submit</button>	
</div>
</div>
<div class="col-lg-12" align="right">
<div class="form-group">
<label>Emaild id : safety@tatapigments.co.in</label>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script>
    $(function () {
        $(".select2").select2();
        $('#from').timepicker();
        $('#to').timepicker();

        $("#add_user").validate();

        //Date picker
        $('#ob_dt').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            startDate: '-15d',
            endDate: '0d'
        });

        $('#doj').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy'
        });
        
        $("[name='category']").change(function(){
           if($(this).val()==="Near Miss"){
               $("[name='type']").attr("disabled",true);
               $("[name='potential']").attr("disabled",true);
           }else{
              
               $("[name='type']").attr("disabled",false);
               $("[name='potential']").attr("disabled",false);
           }
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

     	$("[name='chk_self']").click(function(){
     		if($(this).is(':checked'))
     			$("#assign_action").css('display','none');
     		else
     			$("#assign_action").css('display','block');
     	});

    });
</script>

<!-- Jquery form validation Plugin -->
<script src="assets/vendor/validation/jquery.validate.min.js"></script>
<!-- bootstrap datepicker -->
<script src="assets/vendor/datepicker/bootstrap-datepicker.js"></script>
</body>
</html>