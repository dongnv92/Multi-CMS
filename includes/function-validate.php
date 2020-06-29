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