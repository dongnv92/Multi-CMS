<?php
switch ($path[2]){
    case 'add':
        if(!$role['pickup']['add']){
            exit('Forbidden');
        }
        $pickup  = new Pickup();
        $action = $pickup->add();
        echo encode_json($action);
        break;
}