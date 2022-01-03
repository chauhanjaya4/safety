<?php
session_start();
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    ini_set('display_errors',0);
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
        13 => 'remarks',  
        14=> 'date_time'
    );
    
    
    // getting total number records without any search
    $sql = "SELECT id,ed.username as uname,name,dept,desig,observ_date,observ_time,place,categories,type,potential,description,ed.status as ed_status,remarks,assign,";
    $sql.="(select name from login_master where username=assign) as assign_name,assign_date,duration,date_time,md_time,";
    $sql.="(select dept from login_master where username=assign) as assign_dept FROM `entry_details` ed";
    $sql.=" left join login_master lm on(ed.username=lm.username)";
    $sql.=" where ed.username!=0 AND committee_id=".$_SESSION['committee_id']."";
    $sql.=" and ed.status!='Reassigned'";
    
    /* updated code */
    $query = $mconn->query($sql) or die("Something went wrong1");
    $totalData = $query->num_rows;
    
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
    
    if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
        $sql.=" AND (";
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
        $sql.=" OR assign_date LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR duration LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=")";
    
          
    }
    
    /* Custom Code */
    $query = $mconn->query($sql) or die("Something went wrong2");
    $totalFiltered = $query->num_rows; // when there is a search parameter then we have to modify total number filtered rows as per search result. 
    // Original 
    $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'];
    $sql.=",date_time asc";
    $sql.="  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  
    
    $query = $mconn->query($sql) or die("Something went wrong3");
    
    $sn = 1;
    
    $data = array();
    while ($row = $query->fetch_assoc()) {  // preparing an array
        $nestedData = array();  
        $id=$row['id'];
        $href='dic_view.php?id='.$id.'&username='.$row['uname'];
        
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
        $nestedData[] = "<span style='".$style."'>".$row["remarks"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["date_time"]."</span>";
    
        $data[] = $nestedData;
        $sn++;
    }
    $json_data = array(
        "draw"              => intval($requestData['draw']), 
        "recordsTotal"      => intval($totalData), // total number of records
        "recordsFiltered"   => intval($totalFiltered), 
        "data"              => $data
        //"sql"               => $sql// total data array
    );
echo json_encode($json_data);  // send data as json format
}


?>
