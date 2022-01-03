<?php

    require_once 'helpers/user-auth.php';
    require_once 'config/database.php';
    require_once 'classes/Crud.php';
    
    $crud_obj = new Crud($conn);
    
    $data='<div id="table-container">
        <table id="tab">
            <thead>
            <tr>
                <th width="35%" data-sort-ignore="true"> Ticket No.</th>
                <th width="35%">Name</th> 
                <th width="35%">Department</th>
                <th width="35%">Designation</th>
                <th width="35%">Date</th>
                <th width="35%">Time</th>
                <th width="35%">Place</th>
                <th width="35%">Category</th>
                <th width="35%">Type</th>
                <th width="35%">Potential</th>
                <th width="35%">Description</th>
                <th width="35%">Action Status</th>
                <th width="35%">Assigned Level</th>
                <th width="35%">Action Remarks</th>
                <th width="35%">Assigned Tkt No.</th>
                <th width="35%">Assigned Officer Name</th>
                <th width="35%">Assigned Date</th>
                <th width="35%">Assigned Duration</th>
                <th width="35%">Committee</th>
                <th style=" width="35%";text-align: center;">Assigned Dept</th>
                <th width="35%">Last update</th>
                <th width="35%">Product Name</th>
                <th width="20%">Price</th>
                <th width="25%">Category</th>
                <th width="20%">Average Rating</th>
            </tr>
        </thead>
        <tbody>';
 
            $qry="SELECT id,ed.username as uname,name,dept,desig,observ_date,observ_time,place,categories,type,potential,description,
            ed.status as ed_status,remarks,assign,parent_id,(select name from login_master where username=assign) as assign_name,assign_date,duration,date_time,md_time,
            (select dept from login_master where username=assign) as assign_dept,(select committee from committee_master where id=committee_id)
            as committee FROM `entry_details` ed left join login_master lm on(ed.username=lm.username) where ed.username!=0 and ed.status!='Reassigned'";
            if(isset($_REQUEST['userwise']))
            $qry.=" and ed.username='".$_SESSION['username']."'";
            $stmt = $conn->query($qry);
            
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rslt=$stmt->fetchAll();
            if (! empty($rslt)) {
                foreach ($rslt as $key => $value) {
                    
                    if($rslt[$key]["md_time"] == 0){
                    	$entry_date= date('Y-m-d', strtotime($rslt[$key]["date_time"]));
                    	$now = time(); // or your date as well
                    	$your_date = strtotime($entry_date);
                    	$datediff = $now - $your_date;
                    	$datediff = floor($datediff/(60*60*24))+1;
                    }
                    else $datediff = $rslt[$key]['md_time'];
                    
                    if((($datediff > 7) && ($datediff < 30)) && $rslt[$key]['ed_status'] == "No Action Taken")
                	$style="color:#FF9933";
                	elseif($datediff > 30 && $rslt[$key]['ed_status'] == "No Action Taken")
                	$style="color:#EE0000";
                	elseif(in_array($rslt[$key]['ed_status'], array("Action Taken","Self Closed")))
                	$style="color:#338A03";
                	elseif(($datediff > 7) && ($datediff < 30) && $rslt[$key]['ed_status'] == "Job Assigned")
                	$style="color:#FF9933";
                	elseif($datediff > 30  && $rslt[$key]['ed_status'] == "Job Assigned")
                	$style="color:#EE0000";
                	else
                	$style="color:black";
                    $css="style='$style'";
                    
            if($rslt[$key]['parent_id']!=0) $asgn_lvl='Last'; else $asgn_lvl='First';
                 
            $data.='<tr>
                <td><span '.$css.'>'.$rslt[$key]["uname"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["name"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["dept"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["desig"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["observ_date"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["observ_time"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["place"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["categories"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["type"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["potential"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["description"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["ed_status"].'</span></td>
                <td><span '.$css.'>'.$asgn_lvl.'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["remarks"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["assign"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["assign_name"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["assign_date"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["duration"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["date_time"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["md_time"].'</span></td>
                <td><span '.$css.'>'.$rslt[$key]["committee"].'</span></td>
            </tr>';
                }
            }
            
     $data.='</tbody>
    </table>';


    $filename = "Safety_all.xls";
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $isPrintHeader = false;
        echo $data;
        exit();
    

?>