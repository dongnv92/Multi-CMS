<?php

$message_chat       = '/k10_3';
$message            = explode('_', $message_chat);
$message_key        = $message[0];
$message_value      = str_replace("{$message_key}_", '', $message_chat);

if(count($message) > 1){
    echo "Có";
}else{
    echo "Không";
}