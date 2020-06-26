<?php
require_once '../init.php';
require_once ABSPATH . 'includes/function-admin.php';

$mot = [['mot' => 1, 'hai' => 2], ['ba' => 3, 'bon' => 4]];
$hai = ['mot' => 1, 'hai' => 2];

if(in_array($hai, $mot)){
    echo "Có";
}else{
    echo "Không";
}