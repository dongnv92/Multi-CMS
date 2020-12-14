<?php
switch ($path[2]){
    case 'update_verify':
        if(!$role['kplus']['manager']){
            exit('Forbidden');
        }
        $kplus  = new Kplus($database);
        $action = $kplus->update_verify($path[3]);
        if($action){
            echo encode_json(['response' => 200, 'message' => 'Cập nhật trạng thái xác nhận thành công.']);
        }else{
            echo encode_json(['response' => 309, 'message' => 'Cập nhật trạng thái xác nhận không thành công.']);
        }
        break;
    case 'paid':
        if(!$role['kplus']['manager']){
            exit('Forbidden');
        }
        $kplus  = new Kplus($database);
        $action = $kplus->paid($path[3]);
        echo encode_json($action);
        break;
    case 'check_name':
        if(!$role['kplus']['manager']){
            exit('Forbidden');
        }
        $kplus  = new Kplus($database);
        $action = $kplus->checkName($_REQUEST['kplus_name']);
        if($action){
            echo encode_json(['response' => 404, 'message' => 'Tên đã có trong danh sách']);
        }else{
            echo encode_json(['response' => 200, 'message' => 'Tên chưa có trong danh sách']);
        }
        break;
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