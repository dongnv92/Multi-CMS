<?php
switch ($path[2]){
    case 'add':
        if(!$role['kplus']['add']){
            exit('Forbidden');
        }
        $kplus  = new Kplus($database);
        $action = $kplus->add();
        echo encode_json($action);
        break;
    case 'adds':
        if(!$role['kplus']['add']){
            exit('Forbidden');
        }
        $kplus  = new Kplus($database);
        $action = $kplus->adds();
        echo encode_json($action);
        break;
}