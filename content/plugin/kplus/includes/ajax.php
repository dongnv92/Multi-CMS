<?php
switch ($path[2]){
    case 'update_status':
        if(!$role['kplus']['manager']){
            exit('Forbidden');
        }
        $kplus  = new Kplus($database);
        $action = $kplus->updateStatus($path[3], $path[4]);
        echo encode_json($action);
        break;
    case 'delete':
        if(!$role['kplus']['manager']){
            exit('Forbidden');
        }
        $kplus  = new Kplus($database);
        $action = $kplus->delete($path[3]);
        echo encode_json($action);
        break;
    case 'update':
        if(!$role['kplus']['manager']){
            exit('Forbidden');
        }
        $kplus  = new Kplus($database);
        $action = $kplus->update($path[3]);
        echo encode_json($action);
        break;
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