<?php
require_once 'helpers/user-auth.php';
require_once 'config/database.php';
require_once 'classes/Crud.php';
require_once 'helpers/form_validate.php';


$crud_obj = new Crud($conn);

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $name      = filter_form_data($_POST["folder_name"]);
    $folders   = filter_form_data($_POST["folders"]);
    $file_name = filter_form_data($_POST["file_name"]);
    $fail=true;
    if($name=="" && $folders!="")
        $folders   = filter_form_data($_POST["folders"]);
    else if($name!="" && $folders=="")
        $folders=  filter_form_data($_POST["folder_name"]);
    else{
        $_SESSION["msg"] = "Fill folder name in either of option";
        $fail=false;
    }
       
    if($fail){
       
    	if ($_FILES["file_upload"]["size"] > 0) {
              
                $file_error = "";
                $supported_formats = array("pdf","PDF");
                $target_dir = "dmsdocs/";
    
                if (!is_dir($target_dir)) {
                    //echo "Directory not created creating it now";
                    mkdir($target_dir, 0777, TRUE);           	
    
                }
    
                $target_file 	= $target_dir . basename($_FILES["file_upload"]["name"]);
                $imageFileType 	= pathinfo($target_file, PATHINFO_EXTENSION);
                if(in_array($imageFileType, $supported_formats)){
    
                	if ($_FILES["file_upload"]["size"]>0) {
    
    	            	if (file_exists($target_file)) {
    	            		$_SESSION['msg']="file is already exists";
    	            	}else{
    	            		if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file)) {
    		                   
    		                    $attachment = $target_file;
    		                    $file_error = "";
    		                    
    		                      // Preparing data 
                                    $user_data = array(
                                        "folder"    => $folders,
                                        "file_url"  => $_FILES["file_upload"]["name"],
                                        "file_name" => $file_name
                                    );
                                
                                   // echo json_encode($user_data);
                                
                                    try {
                                        // Create crud object
                                
                                        if ($crud_obj->insert("uploads", $user_data) !== false) {
                                
                                            //echo "Successfully Added";
                                            $_SESSION["msg"] = "File uploaded successfully";
                                        } else {
                                            echo "Failed ";
                                            $_SESSION["msg"] = "Failed ! Try again";
                                        }
                                
                                        //echo "<meta http-equiv='refresh' content='0'>";
                                    } catch (PDOException $e) {
                                        $_SESSION["msg"] = "Something went wrong";
                                
                                        echo $e->getMessage();
                                    }
    		                    //$_SESSION['msg']="File uploaded Successfully";
    
    						}
    	            	}
    
    	            }else{
    	            	$_SESSION['msg']="File is fake";
    	            }
                }else{
                	$_SESSION['msg']="Only pdf file is allowed";
                }
                //echo $check 	= getimagesize($_FILES["first_upload"]["tmp_name"]);
    
                
            }else{
                	$_SESSION['msg']="Please select a file to upload";
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

        <title>Tatapigment Safety | Create Upload</title>

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
        <style>
             datalist { 
              display: none;
            }
        </style>

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php include "templates/header.php"; ?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">DMS</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add  Details


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
                                    <form role="form" action="" enctype="multipart/form-data" method="post" id="add_user">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>Folder Name</label>
                                                <input class="form-control" type="text" name="folder_name"  placeholder="Enter Name" pattern="[A-Za-z0-9_ ]{2,50}" >
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div style="font-size: xx-large;margin-top: 24px;" align="center">/</div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>Select Folder</label>
                                                <input list="folders" name="folders" class="form-control" autoComplete="off">
                                                  <datalist id="folders">
                                                    <?php
                                                    $stmt=$conn->query("select distinct folder from uploads");
                                                    $stmt->execute();
                                                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                                    $rslt=$stmt->fetchAll();
                                                    if($stmt->rowCount()>0)
                                                    foreach($rslt as $row)
                                                    {
                                                        $option=$row['folder'];
                                                        echo "<option value='".$option."'>";
                                                    }
                                                    ?>
                                                  </datalist>
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>Browse File(only pdf files are allowed)</label>
                                                <input type="file" class="form-control" name="file_upload" placeholder="Browse file">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label>File name</label>
                                                <input type="text" class="form-control" required name="file_name" pattern="[A-Za-z0-9_ ]{2,100}" placeholder="File name">
                                                <p class="help-block"></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">&nbsp;
                                        </div>
                                        <div class="col-lg-4" align="center">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Upload">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">&nbsp;
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

               <!-- bootstrap datepicker -->
        <script src="assets/vendor/datepicker/bootstrap-datepicker.js"></script>


    </body>

</html>
