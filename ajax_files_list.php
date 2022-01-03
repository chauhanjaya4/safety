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
        0   =>  'id',
        1   =>  'folder',
        2   =>  'file',
        3   =>  'upl_dt'
    );
    
    
    // getting total number records without any search
    $sql = "SELECT id,folder,file_url,file_name,last_modified from uploads where 1=1";
    
    /* updated code */
    $query = $mconn->query($sql) or die("Something went wrong1");
    $totalData = $query->num_rows;
    
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
    
    if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
        $sql.=" AND (";
        $sql.=" folder LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR file_name LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=" OR last_modified LIKE '" . $requestData['search']['value'] . "%' ";
        $sql.=")";
    
    }
    
    /* Custom Code */
    $query = $mconn->query($sql) or die("Something went wrong2");
    $totalFiltered = $query->num_rows; // when there is a search parameter then we have to modify total number filtered rows as per search result. 
    // Original 
    
    $sql.=" order by last_modified desc";
    if($requestData['length']!=-1)
    $sql.="  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  
    
    $query = $mconn->query($sql) or die("Something went wrong3");
    
    $sn = 1;
    
    $data = array();
    while ($row = $query->fetch_assoc()) {  // preparing an array
        $nestedData = array();  
        $id=$row['id'];
        
        $href='dmsdocs/'.$row['file_url'];
    
    
        $nestedData[] = "<a href='".$href."' style='color:black;text-decoration:underline;' target='_blank'>".$row['id']."</a>";    
        $nestedData[] = "<span style='".$style."'>".$row["folder"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["file_name"]."</span>";
        $nestedData[] = "<span style='".$style."'>".$row["last_modified"]."</span>";
        $data[] = $nestedData;
        $sn++;
    }
    $json_data = array(
        "draw" => intval($requestData['draw']), 
        "recordsTotal" => intval($totalData), // total number of records
        "recordsFiltered" => intval($totalFiltered), 
        "data" => $data//,
        //"sql" => $sql// total data array
    );
    echo json_encode($json_data);  // send data as json format
}
?>
