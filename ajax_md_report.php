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
        1 => 'username',
        2 => 'description',
        3 => 'observ_date',
        4 => 'observ_time',
        5 => 'place',
        6 => 'categories',
        7 => 'TYPE',
        8 => 'potential',
        9 => 'status',
        10=> 'md_time',
        11=> 'md_remark'
    );
    
    
    // getting total number records without any search
    $sql = "SELECT * FROM `entry_details` WHERE STATUS NOT IN ('Reassigned','Action Taken','Self Closed')";
    
    /* updated code */
    $query = $mconn->query($sql) or die("Something went wrong1");
    $totalData = $query->num_rows;
    
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
    
    if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
        $sql.=" AND(";
        $sql.=" username LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR description LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR observ_date LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR observ_time LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR place LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR categories LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR TYPE LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR potential LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR status LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR md_time LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR md_remark LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=")";
    
    }
    /* Custom Code */
    $query = $mconn->query($sql) or die("Something went wrong2");
    $totalFiltered = $query->num_rows; // when there is a search parameter then we have to modify total number filtered rows as per search result. 
    // Original 
    $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  
    
    
    $query = $mconn->query($sql) or die("Something went wrong3");
    
    $sn = 1;
    
    $data = array();
    while ($row = $query->fetch_assoc()) {  // preparing an array
        $nestedData = array();  
        $id=$row['id'];
        $href='delayed_entries.php?id='.$id.'&name='.$_SESSION['name'].'&username='.$row['username'];
        
       if($row['md_time'] == 0){
        	$entry_date= date('Y-m-d', strtotime($row['date_time']));
        	$now = time(); // or your date as well
        	$your_date = strtotime($entry_date);
        	$datediff = $now - $your_date;
        	$datediff = floor($datediff/(60*60*24))+1;
        }
        else $datediff = $row['md_time'];
        
        if((($datediff > 7) && ($datediff < 30)) && $row['status'] == "No Action Taken")
    	$style="color:#FF9933";
    	elseif($datediff > 30 && $row['status'] == "No Action Taken")
    	$style="color:#EE0000";
    	elseif($row['status'] == "Action Taken")
    	$style="color:#338A03";
    	elseif(($datediff > 7) && ($datediff < 30) && $row['status'] == "Job Assigned")
    	$style="color:#FF9933";
    	elseif($datediff > 30  && $row['status'] == "Job Assigned")
    	$style="color:#EE0000";
    	else
    	$style="color:black";
        
        
        $nestedData[] = "<a href='".$href."' style='color:black;text-decoration:underline;'>".$row['id']."</a>";    
        $nestedData[] = "<span style='".$style."'>".$row["username"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["description"]."</span>";
        $nestedData[] = "<span style='".$style."'>".date("d-m-Y",strtotime($row["observ_date"]))."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["observ_time"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["place"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["categories"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["type"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["potential"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["status"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["md_time"]. " days"."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["md_remark"]."</span>";
      
        $data[] = $nestedData;
        $sn++;
    }
    
    $json_data = array(
        "draw" => intval($requestData['draw']), 
        "recordsTotal" => intval($totalData), // total number of records
        "recordsFiltered" => intval($totalFiltered), 
        "data" => $data   // total data array
    );
    echo json_encode($json_data);  // send data as json format
}


?>
