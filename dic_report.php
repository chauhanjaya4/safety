<?php
require_once 'helpers/user-auth.php';
require_once 'config/database.php';
require_once 'classes/Crud.php';

$crud_obj = new Crud($conn);


?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
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
        
         <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
        
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
                        <h1 class="page-header">Report</h1>
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
                                    <div class="table-responsive">
                                        <table id="obseravationTable" class="table table-striped table-bordered add-manage-table table demo" data-filter="#filter" data-filter-text-only="true">
                                            <thead>
                                                <tr>
                                                    <th>View</th>
                                                    <th data-sort-ignore="true"> Ticket No.</th>
                                                    <th>Name</th> 
                                                    <th>Department</th>
                                                    <th>Designation</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Place</th>
                                                    <th>Category</th>
                                                    <th>Type</th>
                                                    <th>Potential</th>
                                                    <th>Description</th>
                                                    <th>Action Status</th>
                                                    <th>Action Remarks</th>
                                                    <th>Last update</th>
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

         <script>
           $(document).ready(function () {

                var dataTable = $('#obseravationTable').DataTable({

                    "processing": true,

                    "serverSide": true,

                    "stateSave": true,
                    
                    "sPaginationType": "listbox",
             
                    "ajax": {

                        url: "ajax_dic_report.php",
                        //type: "post",  // method  , by default get

                        error: function () {  // error handling

                            $(".employee-grid-error").html("");

                            $("#leave_requests").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');

                            $("#leave_requests").css("display", "none");
                        }
                        
                    },
                    dom: 'Blfrtip',
                        buttons: [
                            'copy', 'csv', 'excel',
                            { 
                                extend:'pdf',
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                            }, 'print'
                        ]

                });
                
                dataTable.order( [[ 0, 'desc' ]]) .draw();

            });
        </script>

    </body>

</html>
