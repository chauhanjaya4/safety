<?php
session_start();
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    //ini_set('display_errors',1);
    require_once 'helpers/user-auth.php';
    require_once 'config/database.php';
    require_once 'classes/Crud.php';
    // storing  request (ie, get/post) global array to a variable  
    $requestData = $_REQUEST;
    $crud_obj = new Crud($mconn);
    
    $columns = array(
    // datatable column index  => database column name
        0 => 'id',
        1 => 'uname',
        2=>  'name',
        3=>  'dept',
        4=>  'desig',
        5=>  'observ_date',
        6=>  'observ_time',
        7 => 'place',
        8 => 'categories',
        9 => 'TYPE',
        10 => 'potential',
        11 => 'description',
        12 => 'ed.status',
        13 => 'parent_id',
        14 => 'remarks',
        15 => 'assign',
        16 => 'assign_name',
        17 => 'assign_date',
        18 => 'duration',
        19=> 'committee',
        20=> 'assign_dept',
        21=> 'date_time',
        22=> 'md_time'
    );
    
    
    // getting total number records without any search
    $sql = "SELECT id,ed.username as uname,name,dept,desig,observ_date,observ_time,place,categories,type,potential,description,ed.status as ed_status,remarks,assign,";
    $sql.="(select name from login_master where username=assign) as assign_name,assign_date,duration,date_time,md_time,parent_id,";
    $sql.="(select dept from login_master where username=assign) as assign_dept,(select committee from committee_master where id=committee_id) as committee,md_time FROM `entry_details` ed";
    $sql.=" left join login_master lm on(ed.username=lm.username) ";
    
    if($_REQUEST['report']=="total")
        $sql.="where ed.username!=0";
    else if($_REQUEST['report']=="week_no")
        $sql.=" WHERE (observ_date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND observ_date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY)  AND ed.`status`='Job Assigned' AND ed.username!=0"; 
    else if($_REQUEST["report"]=="month_no")
        $sql.="where (observ_date >= DATE_FORMAT( CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01' ) AND  observ_date < DATE_FORMAT( CURRENT_DATE, '%Y/%m/01' ) ) AND ed.`status`='No Action Taken' AND ed.username!=0";
    else if($_REQUEST["report"]=="month_yes")
    $sql.="where ( observ_date >= DATE_FORMAT( CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01' ) AND  observ_date < DATE_FORMAT( CURRENT_DATE, '%Y/%m/01' ) ) AND ed.`status`='Job Assigned' AND ed.username!=0";
    else if($_REQUEST["report"]=="history")
        $sql.="where ed.username=".$_SESSION["username"];
    else if($_REQUEST["report"]=="re-assign") //This is for HOD(not role) to re-assign.
    {
        $sql.="where assign_dept='".$_SESSION["dept_id"]."'";
    }
    
    $sql.=" and ed.status!='Reassigned'";
    
    
    if($_REQUEST['is_filter']=='yes'){
        $frm_dt=$_REQUEST['frm_dt'];
        if($frm_dt!=''){
            $frm_dt=date("Y-m-d",strtotime($_REQUEST['frm_dt']));
            $to_dt=date("Y-m-d",strtotime($_REQUEST['to_dt']));
            $sql.=" and observ_date between '$frm_dt' and '$to_dt'";
        }else{
            $byyear=$_REQUEST['byyear'];
            $sql.=" and observ_date like '%$byyear%'";
        }
        
        
    }
    
    /* updated code */
    $query = $mconn->query($sql) or die("Something went wrong1");
    $totalData = $query->num_rows;
    
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
    
    if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
        $sql.=" AND (";
        //$sql.=" id LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" ed.username LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR name LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR dept LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR desig LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR observ_date LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR observ_time LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR place LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR categories LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR TYPE LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR potential LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR description LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR ed.status LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR remarks LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR assign LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR assign_date LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR duration LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=")";
    
    }
    /* Custom Code */
    $query = $mconn->query($sql) or die("Something went wrong2");
    $totalFiltered = $query->num_rows;  
    // Original 
    $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'];
    $sql.=",date_time asc";
    if(isset($requestData['start']))
    $sql.="  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  
    
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
    $query = $mconn->query($sql) or die("Something went wrong3");
    
    $sn = 1;
    
    $data = array();
    while ($row = $query->fetch_assoc()) {  // preparing an array
        $nestedData = array();  
        $id=$row['id'];
        
        if($_REQUEST["report"]=="history")
            $href='view_history.php?id='.$id.'&username='.$row['uname'].'&report_type='.$_REQUEST['report'];
        else
            $href='assign_entries.php?id='.$id.'&username='.$row['uname'].'&report_type='.$_REQUEST['report'];
        
       if($row['md_time'] == 0){
        	$entry_date= date('Y-m-d', strtotime($row['date_time']));
        	$now = time(); // or your date as well
        	$your_date = strtotime($entry_date);
        	$datediff = $now - $your_date;
        	$datediff = floor($datediff/(60*60*24))+1;
        }
        else $datediff = $row['md_time'];
        
        if((($datediff > 7) && ($datediff < 30)) && $row['ed_status'] == "No Action Taken")
    	$style="color:#FF9933";
    	elseif($datediff > 30 && $row['ed_status'] == "No Action Taken")
    	$style="color:#EE0000";
    	elseif(in_array($row['ed_status'], array("Action Taken","Self Closed")))
    	$style="color:#338A03";
    	elseif(($datediff > 7) && ($datediff < 30) && $row['ed_status'] == "Job Assigned")
    	$style="color:#FF9933";
    	elseif($datediff > 30  && $row['ed_status'] == "Job Assigned")
    	$style="color:#EE0000";
    	else
    	$style="color:black";
    	
    	if($row['parent_id']!=0) $asgn_lvl='Last'; else $asgn_lvl='First';
        
        
        $nestedData[] = "<a href='".$href."' style='color:black;text-decoration:underline;'>".$row['id']."</a>";    
        $nestedData[] = "<span style='".$style."'>".$row["uname"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["name"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["dept"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["desig"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["observ_date"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["observ_time"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["place"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["categories"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["type"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["potential"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["description"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["ed_status"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$asgn_lvl."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["remarks"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["assign"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["assign_name"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["assign_date"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["duration"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["committee"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["assign_dept"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["date_time"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["md_time"]."</span>";
            
        $data[] = $nestedData;
        $sn++;
    }
    $json_data = array(
        "draw" => intval($requestData['draw']), 
        "recordsTotal" => intval($totalData), // total number of records
        "recordsFiltered" => intval($totalFiltered), 
        "data" => $data,
        //"sql" => $sql,// total data array,
        "start"=> $requestData['start'],
        "end"=> $requestData['length']
    );
    echo json_encode($json_data);  // send data as json format
}


?>
