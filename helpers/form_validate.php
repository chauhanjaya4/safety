<?php


function filter_form_data($data){
    $data = trim($data);
    $data = escapeshellcmd($data);
    $data = htmlentities($data);
    $data = str_replace("^", " ", $data);
    return $data;
}


 ?>
