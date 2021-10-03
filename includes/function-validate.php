<?php

function validate_username ($name, $filter = "[^a-zA-Z0-9\_\.]"){
    return preg_match("~" . $filter . "~iU", $name) ? false : true;
}

function validate_email($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
        return true;
    return false;
}

function validate_isset($text = ''){
    if(isset($text) && !empty($text)){
        return true;
    }else{
        return false;
    }
}

function validate_int($value){
    if(!filter_var($value, FILTER_VALIDATE_INT))
        return false;
    return true;
}

function validate_numeric($value){
    if(is_numeric($value)){
        return true;
    }
    return false;
}

function validate_url($value){
    if(!filter_var($value, FILTER_VALIDATE_URL))
        return false;
    return true;
}

function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

