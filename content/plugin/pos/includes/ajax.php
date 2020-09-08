<?php
switch ($path[2]){
    case 'get_product':
        $pos = new Pos($database);
        echo encode_json($pos->get_list_product_ajax($_REQUEST['q']));
        break;
}