<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function diff_time($first_date, $last_date) {

    if ($first_date !== "" && $last_date !== "") {
        if ($last_date === false) {
            $last = date("Y-m-d");
        }

        $first_date = new DateTime($first_date);
        $last_date = new DateTime($last_date);
        $date_diff = date_diff($first_date, $last_date, true);
        return $date_diff->format("%a");
    } else {
        return "N/A";
    }
}

function date_formater($date = "") {
    if ($date === "" || $date === NULL) {
        return "N/A";
    } else {
        return date("d-m-Y", strtotime($date));
    }
}

?>