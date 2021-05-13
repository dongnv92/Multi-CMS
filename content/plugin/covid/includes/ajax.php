<?php
switch ($path[2]){
    case 'add':
        if(!$role['covid']['add']){
            echo encode_json(['response' => 201, 'message' => 'Hello']);
        }
        $covid  = new pCovid();
        $add    = $covid->add();
        echo encode_json($add);
        break;
    default:

    break;
}