<?php
    //ini_set('display_errors',1);
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {
        require_once 'helpers/user-auth.php';
        require_once 'config/database.php';//collect the passed id
        $id = $_POST['dd_dept'];
        if(isset($_POST['all_emp']))
            $hod='No';
        else
            $hod='Yes';
        $stmt = $conn->query("SELECT `username`, `name`, `email_id` FROM `login_master` WHERE dept_id='".$id."' and status='N' and hod='$hod'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rslt=$stmt->fetchAll();
        foreach($rslt as $row){
        ?>
            <option value="<?php echo $row['email_id']."-".$row['username']; ?>" ><?php echo $row['name']; ?></option>
        <?php
        }
    }
?>