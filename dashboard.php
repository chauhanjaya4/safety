<?php
require_once 'helpers/user-auth.php';
require_once 'config/database.php';
require_once 'classes/Crud.php';
require_once 'classes/User.php';
require_once 'helpers/form_validate.php';


// Get Count of users
function tot_users_count(){
    global $conn;
    $sql = "select count(*) as tot_users from login_master where status='N'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {

            return $row["tot_users"];
           
        }
    } else {
        return "0";
    }

} 

function tot_req_flvl(){
    global $conn,$from_dt,$to_dt;
    $sql = "select count(*) as tot_pen from entry_details where status='Job Assigned' and parent_id=0";
    $sql.=" and username='".$_SESSION['username']."'";
    if($from_dt!="" && $to_dt!="")
    $sql.=" and observ_date between '$from_dt' and '$to_dt'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {

            return $row["tot_pen"];
           
        }
    } else {
        return "0";
    }

} 

function tot_req_llvl(){
    global $conn,$from_dt,$to_dt;
    $sql = "select count(*) as tot_ass from entry_details where status ='Job Assigned' and parent_id!=0";
    $sql.=" and username='".$_SESSION['username']."'";
    if($from_dt!="" && $to_dt!="")
    $sql.=" and observ_date between '$from_dt' and '$to_dt'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {

            return $row["tot_ass"];
           
        }
    } else {
        return "0";
    }

} 


// Get Count of users
function tot_safety_req(){
    global $conn;
    $sql = "select count(*) as tot from entry_details where username='".$_SESSION['username']."' and status!='Reassigned'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {

            return $row["tot"];
           
        }
    } else {
        return "0";
    }

} 

// Approved Leave request
function tot_req_pending(){
    global $conn;
    $sql = "select count(*) as tot_pen from entry_details where status = 'Job Assigned' and assign='".$_SESSION['username']."'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {

            return $row["tot_pen"];
           
        }
    } else {
        return "0";
    }

} 

// Pending Leave request
function tot_req_resolved(){
    global $conn;
    $sql = "select count(*) as tot_resl from entry_details where status = 'Action Taken' and assign='".$_SESSION['username']."'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            return $row["tot_resl"];
        }
    } else {
        return "0";
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

     <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css">
        
        <link rel="stylesheet" href="assets/datatables/dataTables.bootstrap.css">


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
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <?php
                    if($_SESSION['role']==5){
                    ?>
                        <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo tot_users_count(); ?></div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- <a href="#"> -->
                                <div class="panel-footer">
                                    <span class="pull-left">Users</span>
                                    <!--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
                                    <div class="clearfix"></div>
                                </div>
                            <!-- </a> -->
                        </div>
                    </div>
                    <?php
                    }
                     if($_SESSION['role']!=5){
                    ?>
                    <a href="req_history.php">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fas fa-exclamation-triangle" style="font-size: 70px;"></i>
    <!--                                        <i class="fa fa-user fa-5x"></i>
    -->                                 </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo tot_safety_req(); ?></div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- <a href="#"> -->
                                    <div class="panel-footer">
                                        <span class="pull-left" style='color:black'>Safety Requests Raised</span>
                                        <!--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
                                        <div class="clearfix"></div>
                                    </div>
                                <!-- </a> -->
                            </div>
                        </div>
                    </a>
                    <?php if($_SESSION['role']==1){ ?>
                    <a href="#">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fas fa-exclamation-triangle" style="font-size: 70px;"></i>
    <!--                                        <i class="fa fa-user fa-5x"></i>
    -->                                 </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo tot_req_flvl(); ?></div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- <a href="#"> -->
                                    <div class="panel-footer">
                                        <span class="pull-left" style='color:black'>Requests @ First Level</span>
                                        <!--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
                                        <div class="clearfix"></div>
                                    </div>
                                <!-- </a> -->
                            </div>
                        </div>
                    </a>
                    
                    <a href="#">
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fas fa-exclamation-triangle" style="font-size: 70px;"></i>
    <!--                                        <i class="fa fa-user fa-5x"></i>
    -->                                 </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo tot_req_llvl(); ?></div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- <a href="#"> -->
                                    <div class="panel-footer">
                                        <span class="pull-left" style='color:black'>Requests @ Last Level</span>
                                        <!--<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
                                        <div class="clearfix"></div>
                                    </div>
                                <!-- </a> -->
                            </div>
                        </div>
                    </a>
                    
                    
                        <?php
                        }
                    }
                    if($_SESSION['role']!=5 && $_SESSION['role']!=1){
                    ?>
                        <a href="officers_report.php" style='color:black'>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-clock-o fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo tot_req_pending(); ?></div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <a href="#"> -->
                                        <div class="panel-footer">
                                            <span class="pull-left">Requests pending for action</span>
                                            
                                            <div class="clearfix"></div>
                                        </div>
                                    <!-- </a> -->
                                </div>
                            </div>
                        </a>
                        
                    <a href="officers_report.php" style='color:black'>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3"><i class="fa fa-check fa-5x"></i>
                                        
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo tot_req_resolved(); ?></div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- <a href="#"> -->
                                <div class="panel-footer">
                                    <span class="pull-left">Requests resolved</span>
                                    
                                    <div class="clearfix"></div>
                                </div>
                            <!-- </a> -->
                        </div>
                    </div>
                    </a>
                     <?php
                    }
                    ?>
                    <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table id="obseravationTable" class="table table-striped table-bordered add-manage-table table demo" data-filter="#filter" data-filter-text-only="true">
                                            <thead>
                                                <tr>
                                                    <th>View</th>
<!--                                                    <th data-sort-ignore="true"> Ticket No.</th>
-->                                                 <th>Folder</th> 
                                                    <th>File</th>
                                                    <th>Upload Date</th>
                                         
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                </div>

                                </div>
                                <!-- /.col-lg-6 (nested) -->


                            </div>
                            <!-- /.row (nested) -->
                        </div>
              
                </div>
                <!-- /.row -->
                <div class="row">
                    <div id="login_id" style='display:none;'><?php echo $_SESSION['username']; ?></div>
    
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


         <!-- DataTables -->
        <script src="assets/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/datatables/dataTables.bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/plug-ins/1.10.19/pagination/select.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>   
<!--        <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
-->
         <script>
            $(document).ready(function () {
                    
                    
                    var dataTable = $('#obseravationTable').DataTable({
    
                        "processing": true,
    
                        "serverSide": true,
    
                        "stateSave": true,
                        
                        "sPaginationType": "listbox",
                        
                        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                        
                        "ajax": {
    
                            url : "ajax_files_list.php", // json datasource
                           
    
                            //type: "post",  // method  , by default get
    
                            error: function () {  // error handling
    
                                $(".employee-grid-error").html("");
    
                                $("#leave_requests").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
    
                                $("#leave_requests").css("display", "none");
                            }
                            
                        },
                        dom: 'Blfrtip',
                        /*buttons: [
                           'copy', 'csv', 'excel' ,
                           { 
                                extend:'pdf',
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                            }, 'print'
                        ]*/
                        buttons: [
                            {
                                extend:'excel',
                                text  :'View Export'
                                
                            }/*,
                            {
                                text  :'Delete',
                                action: function ( e, dt, node, config ) {
                                    
                                    if(confirm("Are you sure!!!")){
                                        del_id=$("#obseravationTable tr.selected td a").html();
                                        $.ajax({
                                            url:'ajax_del_dms.php',
                                            data:{del_id:del_id},
                                            success:function(del_res){
                                               dataTable.draw();
                                            },
                                            error:function(del_res){
                                                alert(del_res);
                                            }
                                           
                                        });
                                    }
                                 
                                }
                            }*/
                        ]
    
                    });
                    
                    
                    if($("#login_id").html()=='1001'){
                        dataTable.button().add( 1, {
                        action: function ( e, dt, button, config ) {
                            if(confirm("Are you sure!!!")){
                                del_id=$("#obseravationTable tr.selected td a").html();
                                $.ajax({
                                    url:'ajax_del_dms.php',
                                    data:{del_id:del_id},
                                    success:function(del_res){
                                       dataTable.draw();
                                    },
                                    error:function(del_res){
                                        alert(del_res);
                                    }
                                   
                                });
                            }
                            //dt.ajax.reload();
                        },
                        text: 'Delete'
                        } );
                    }
                    
                    
                     $('#obseravationTable tbody').on( 'click', 'tr', function () {
                        if ( $(this).hasClass('selected') ) {
                            $(this).removeClass('selected');
                        }
                        else {
                            dataTable.$('tr.selected').removeClass('selected');
                            $(this).addClass('selected');
                        }
                    } );
                 
                 });
        </script>

    </body>

 </html>
