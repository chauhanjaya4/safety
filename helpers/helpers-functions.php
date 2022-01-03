<?php

function get_status($data){
    if($data === "1"){
        return "Enabled";
    }else{
        return "Disabled";
    }
}