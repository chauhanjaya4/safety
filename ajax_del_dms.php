<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    require_once 'helpers/user-auth.php';
    require_once 'helpers/form_validate.php';
    require_once 'config/database.php';
    
    $del_id=filter_form_data($_REQUEST['del_id']);
    
    if($conn->query("delete from uploads where id=$del_id"))
    echo "Y";
    else
    echo "N";
}
    
?>