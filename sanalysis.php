<?php
require_once 'helpers/user-auth.php';
require_once 'config/database.php';
require_once 'classes/Crud.php';
require_once 'classes/User.php';
require_once 'helpers/form_validate.php';

if(isset($_REQUEST['btn_submit'])){
    $from_dt=date("Y-m-d",strtotime($_REQUEST['from_dt']));
    $to_dt=date("Y-m-d",strtotime($_REQUEST['to_dt']));
}else{
    $from_dt=$to_dt="";
}

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


// Get Count of users
function tot_safety_req(){
    global $conn,$from_dt,$to_dt;
    $sql = "select count(*) as tot from entry_details where status not like '%Reassigned%'";
    $sql.=" and username!=0";
    if($from_dt!="" && $to_dt!="")
    $sql.=" and observ_date between '$from_dt' and '$to_dt'";
    //echo $sql;
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

function tot_req_flvl(){
    global $conn,$from_dt,$to_dt;
    $sql = "select count(*) as tot_pen from entry_details where status='Job Assigned' and parent_id=0";
    $sql.=" and username!=0";
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
    $sql.=" and username!=0";
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

// Pending Leave request
function tot_req_resolved(){
    global $conn,$from_dt,$to_dt;
    $sql = "select count(*) as tot_resl from entry_details where status = 'Action Taken'";
    $sql.=" and username!=0";
    if($from_dt!="" && $to_dt!="")
    $sql.=" and observ_date between '$from_dt' and '$to_dt'";
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

// self closed
function tot_self_clsd(){
    global $conn,$from_dt,$to_dt;
    $sql = "select count(*) as tot_resl from entry_details where status = 'Self Closed'";
    $sql.=" and username!=0";
    if($from_dt!="" && $to_dt!="")
    $sql.=" and observ_date between '$from_dt' and '$to_dt'";
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

    $usr_cnt=tot_users_count();
    $req_saf=tot_safety_req();
    $req_flvl=tot_req_flvl();
    $req_llvl=tot_req_llvl();
    $req_res=tot_req_resolved();
    $slf_cls=tot_self_clsd();
    $dataPoints = array(
    	array("label"=> "Users Count","y"=> $usr_cnt),
    	array("label"=> "Requests Raised", "y"=> $req_saf, "color"=>"Black"),
    	array("label"=> "Assigned @ 1st Level", "y"=> $req_flvl),
    	array("label"=> "Assigned @ Last Level", "y"=> $req_llvl, "color"=>"Red"),
    	array("label"=> "Requests Resolved", "y"=> $req_res, "color"=> "Green"),
        array("label"=> "Self Closed", "y"=> $slf_cls, "color"=> "Blue")
    );

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
        
        <link rel="stylesheet" href="assets/datatables/dataTables.bootstrap.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    <script type="text/javascript">
		window.onload = function () {
			var chart = new CanvasJS.Chart("chartContainer", {
			    animationEnabled: true,
            	exportEnabled: true,
            	theme: "light1", // "light1", "light2", "dark1", "dark2"
				title: {
					text: "",
                    fontSize: 25
				},
				data: [{
					type: "column",
					indexLabel: "{y}",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();
		}
	</script>
    <script src="assets/js/canvasjs.min.js"></script>
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php include "templates/header.php"; ?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <form action="" method="post">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <div class="form-group">
                                   <label>From Date</label>
                                   <input class="form-control" type="date" name="from_dt" required="required" value="<?php echo $from_dt; ?>">
                                </div>
                            </div>
                        
                            <div class="col-lg-4">
                                <div class="form-group">
                                   <label>To Date</label>
                                   <input class="form-control" type="date" name="to_dt" required="required" value="<?php echo $to_dt; ?>">
                                </div>
                            </div>
                            <div class="col-lg-4" style="margin-top: 25px;" align="center">
                                <div class="form-group">
                                    <button class="btn btn-primary" name="btn_submit">Re-draw</button>	
                                </div>
                            </div>
                          
                            <div class="col-lg-12">
                                 <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                            </div>
                        </div>
                    
                    </form>
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


    </body>

    </html>
