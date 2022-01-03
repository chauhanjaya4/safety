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



        <title>Tatapigment Safety | Manage Users</title>



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





        <!-- DataTables CSS -->

        <link href="assets/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">



        <!-- DataTables Responsive CSS -->

        <link href="assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">



        <!-- Color Box Plugin -->

        <link rel="stylesheet" href="assets/vendor/cbox/example5/colorbox.css">



    </head>



    <body>



        <div id="wrapper">



            <!-- Navigation -->

            <?php include "templates/header.php"; ?>



            <div id="page-wrapper">

                <div class="row">

                    <div class="col-lg-12">

                        <h1 class="page-header">Manage User</h1>

                    </div>

                    <!-- /.col-lg-12 -->

                </div>

                <!-- /.row -->

                <div class="row">





                    <div class="panel panel-default">

                        <div class="panel-heading">

                            User List

                        </div>

                        <div class="panel-body">





                            <table width="100%" class="table table-striped table-bordered table-hover" id="plants_list">

                                <thead>

                                    <tr>
                                        
                                        <th>Ticket No.</th>

                                        <th>Name</th>

                                        <th>Email</th>

                                        <th>Role</th>

                                        <th>Department</th>
                                        
                                        <th>Designation</th>

                                        <th>Mobile</th>
                                        
                                        <th>Blocked</th>

                                        <th>Action</th>



                                    </tr>

                                </thead>

                                <tbody>





                                    <?php

                                    $user_slected = $crud_obj->select("login_master");

                                    foreach ($user_slected as $result) {

                                        ?>

                                        <tr class="odd gradeX">
                                            
                                            <td><?php echo $result["username"]; ?></td>

                                            <td><?php echo $result["name"]; ?></td>

                                            <td><?php echo $result["email_id"]; ?></td>

                                            <td><?php 
                                            if($result['role']==0)
                                            echo "Employee";
                                            else if($result['role']==1)
                                            echo "TPL Admin"; 
                                            else if($result['role']==2)
                                            echo "Officer";
                                            else if($result['role']==3)
                                            echo "MD";
                                            else if($result['role']==4)
                                            echo "DIC HOD";
                                            ?></td>
                                            
                                            <td><?php echo $result["dept"]; ?></td>

                                            <td><?php echo $result["desig"]; ?></td>

                                            <td><?php echo $result["mobile_no"]; ?></td> 
                                            
                                            <td><?php echo ($result["status"]=='N')?'No':'Yes'; ?></td> 

                                            <td><a class="iframe" href="edit-user.php?user_id=<?php echo $result["sno"]; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square" aria-hidden="true"></i> View & Edit </button></a></td>

                                            <?php

                                        };

                                        ?>

                                    </tr>



                                </tbody>

                            </table>





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



        <!-- Color box Plugin -->

        <script src="assets/vendor/cbox/jquery.colorbox.js"></script>

        <script>

            $(".iframe").colorbox({iframe: true, width: "80%", height: "80%"});
            
             $("body").on("click", ".iframe", function () {
        $(".iframe").colorbox({iframe: true, width: "80%", height: "80%", onClosed:function(){ location.reload(); }});
    });

        </script>







        <!-- Bootstrap Core JavaScript -->

        <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>



        <!-- Metis Menu Plugin JavaScript             -->

        <script src="assets/vendor/metisMenu/metisMenu.min.js"></script>



        <!-- Custom Theme JavaScript                 -->

        <script src="assets/dist/js/sb-admin-2.js"></script>



        <!-- Select2 JS File -->

        <script type="text/javascript" src="assets/vendor/select2/select2.full.min.js"></script>



        <script>

            $(function () {



                $(".select2").select2();

            });

        </script>



        <!-- Jquery form validation                Plugin -->

        <script src="assets/vendor/validation/jquery.validate.min.js"></script>



        <script>

                $("#add_plant").validate();

        </script>







        <!-- DataTables Jav                aScript -->

        <script src="assets/vendor/datatables/js/jquery.dataTables.min.js"></script>

        <script src="assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>

        <script src="assets/vendor/datatables-responsive/dataTables.responsive.js"></script>



        <script>

                $(document).ready(function () {

                    $('#plants_list').DataTable({

                        responsive: false

                    });

                });

        </script>



    </body>



</html>

