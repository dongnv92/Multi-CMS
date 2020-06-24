<?php

function validate_isset($text = ''){
    if(isset($text) && !empty($text)){
        return true;
    }else{
        return false;
    }
}

