<?php

function set_msg($key, $msg) {
    $_SESSION[$key]=$msg;
}

function get_msg($key) {
    if(isset($_SESSION[$key])) {
        $msg = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $msg;
    }
    return "";
}

function primary_validate($value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}