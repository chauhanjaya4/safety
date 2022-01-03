<?php
    require_once 'helpers/user-auth.php';
    require_once 'config/database.php';
    require_once 'classes/Crud.php';
    $crud_obj = new Crud($conn);
    
    $re_assign=true;
    
    if(isset($_REQUEST['purpose']))
        $re_assign=false;
  
    if($_SESSION['role']==1) $report="total"; 
    else if($_SESSION['role']==2){ 
        if(!$re_assign) $report="total";
        else
        $report="re-assign";
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
        
                <!-- Custom Fonts -->
        <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- Custom End User CSS -->
        <link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">


        <!-- Custom CSS -->
        <link href="assets/dist/css/sb-admin-2.css" rel="stylesheet">

        
         <!-- DataTables -->
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
                        <h1 class="page-header">Safety Observation Form</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">


                    <div class="panel panel-default">
                        <div class="panel-heading">
                        	<form>
                        		
                            <h4>Filter by:</h4><br>
                            <span style="border: 1px dashed;padding: 1.5%;"> 
                            <input type="radio" oninvalid="this.setCustomValidity('Please check either of the option by date/ by year')" oninput="this.setCustomValidity('')" required name="rad_filter" value="bydate">
                            <strong>Date:</strong> From <input type="date" name="from_date" id="from_date" >&nbsp;To <input type="date" name="to_date" id="to_date" >
                            &nbsp;&nbsp;&nbsp;  
                            <input type="radio" required name="rad_filter" value="byyear">

                            <strong>Year:</strong> <select name="lst_year" >
                            	<option value="">Select Year</option>
                        	<?php              
                    			for($yr=date('Y'); $yr>=2012; $yr--){
                    		?>
                    				<option value="<?= $yr; ?>">
                    					<?= $yr; ?>                     	
                    				</option>
                    		<?php
                    			}
                    		 ?>
                            </select>
                            &nbsp;&nbsp;&nbsp;
                            <input type="submit" name="filter" class="btn btn-outline-secondary" value="Filter" style="background-color: #3f51b5;color: white;">
                           </span>
                            </form>
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
                                                    <th>Assign Level</th>
                                                    <th>Action Remarks</th>
                                                    <th>Assigned Tkt No.</th>
                                                    <th>Assigned Officer Name</th>
                                                    <th>Assigned Date</th>
                                                    <th>Assigned Duration</th>
                                                    <th>Committee</th>
                                                    <th style="width: 15%;text-align: center;">Assigned Dept</th>
                                                    <th>Last update</th>
                                                    <th>MD Time</th>
                                                    
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
<div id="response" style='display:none'></div>


                </div>
                <!-- /.row -->
                <div class="row">

                    <input type="hidden" name="report" id="report" value="<?= $report; ?>">
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

         <script>

         	$(document).ready(function(){

         		$("[name='lst_year']").attr("disabled","disabled");		
         		$('#from_date').attr("disabled","disabled");
				$('#to_date').attr("disabled","disabled");			

         	  $("[name='rad_filter']").click(function(){

         	  	var filterby=$("[name='rad_filter']:checked").val();

         	  	if(filterby=='bydate'){
         	  		$('#from_date').attr("required",true).removeAttr("disabled");
					$('#to_date').attr("required",true).removeAttr("disabled");					
					$("[name='lst_year']").removeAttr("required").val("").attr("disabled","disabled");					

         	  	}else if(filterby=='byyear'){
         	  		$("[name='lst_year']").attr("required",true).removeAttr("disabled");
         	  		$('#from_date').removeAttr("required").val("").attr("disabled","disabled");
					$('#to_date').removeAttr("required").val("").attr("disabled","disabled");					
         	  	}

         	  });
         		
         	});
            
            fetch('no');

            $("form").submit(function(e){

            	e.preventDefault();

            	frm_dt =  $('#from_date').val();
	            to_dt  =  $('#to_date').val();
	            byyear =  $("[name='lst_year']").val();
            	fetch('yes',frm_dt,to_dt,byyear);

            });
            
            function fetch(is_filter,frm_dt='',to_dt='',byyear=''){
                
                var dataTable;
                $(document).ready(function () {
                 
                
	              
				   $('#obseravationTable').DataTable().destroy();
                     // $('#obseravationTable').DataTable().clear().draw();
               
                    dataTable = $('#obseravationTable').DataTable({
    
                        "processing": true,
    
                        "serverSide": true,
    
                        "stateSave": true,
                        
                        /*"sPaginationType": "listbox",*/
                        
                        "lengthMenu": [ [10, 25, 50], [10, 25, 50] ],
                        
                        order: [[0, "desc" ]],
                        
                        "ajax": {
    
                            url : "ajax_report_total.php", // json datasource
                            data:{report: $("#report").val(),is_filter:is_filter,frm_dt:frm_dt,to_dt:to_dt,byyear:byyear},
    
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
                                extend:'excelHtml5',
                                text  :'View Export',
                                customize: function(xlsx) {
                                    
                                    /*var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                    
                                    var pg_rec=dataTable.page.info().recordsTotal;
                                   
                                    for(i=1; i<=pg_rec; i++){ 
                                        $('row c[r*='+i+']', sheet).each( function (index) {
                                            
                                            if(index==12) var ed_status=$('is t', this).text();
                                            
                                            if(index==19){
                                                var dt_time=new Date($('is t', this).text());
                                                dt_time=dt_time.getMonth()+"/"+dt_time.getDate()+"/"+dt_time.getFullYear();
                                                dt_time=new Date(dt_time).getTime();
                                                curr_dt=new Date().getTime();
                                                dt_diff=Math.floor((curr_dt-dt_time)/(60*60*24))+1;
                                                 if(((dt_diff > 7) && (dt_diff < 30)) && ed_status == "No Action Taken")
                                                	style="#FF9933";
                                                	else if(datediff > 30 && ed_status == "No Action Taken")
                                                	style="#EE0000";
                                                	else if(ed_status == "Action Taken")
                                                	style="#338A03";
                                                	else if((datediff > 7) && (datediff < 30) && ed_status == "Job Assigned")
                                                	style="#FF9933";
                                                	elseif(datediff > 30  && ed_status == "Job Assigned")
                                                	style="#EE0000";
                                                	else
                                                	style="black";
                                            }
                                            
                                            if(index==20)
                                                if( $('is t', this).text()==0)
                                                {
                                                    $(this).attr( 's', '20' );
                                                }
                                            
                                            console.log(index);
                                        
                                        });
                                    }*/
                                  
                                }
                                
                            },
                            {
                                text: 'Export All',
                                action: function ( e, dt, node, config ) {
                                    window.open('http://tatapigments.co.in/safety/ajax_xl_report_total.php','_blank' );  
                                }
                            }
                        ],
                        "pagingType": "full_numbers"
                    });
                                        
                    dataTable.order( [[ 0, 'desc' ]]).draw();
                        
                    dataTable.page.len( 10 ).draw();
                        
                    if(is_filter=='yes'){
                        dataTable.page.len( 2000).draw();
                        is_filter='no';
                    }                   

                });
            }
         
        </script>

    </body>

</html>
