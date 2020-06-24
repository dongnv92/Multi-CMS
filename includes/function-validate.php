<?php

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