<?php
header('Content-Type: application/json');

switch ($path[2]){
    default:
        $kplus = new Kplus($database);
        $data = $kplus->checkCard('135328155460');
        echo $data;
        break;
}