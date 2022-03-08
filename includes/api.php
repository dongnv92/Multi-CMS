<?php
require_once '../init.php';
header('Content-Type: application/json; charset=utf-8');
switch ($path[1]){
    case 'dong':
        $method = get_method_request();
        echo encode_json(['response' => 200, 'method' => $method]);
        break;
    default:
        if(in_array($path[1], get_list_plugin())){
            $config = file_get_contents(ABSPATH . PATH_PLUGIN . $path[1] . '/config.json');
            $config = json_decode($config, true);
            if($config['status'] == 'active'){
                $module_api_file = ABSPATH . PATH_PLUGIN . $path[1] . "/{$config['source']['api']}";
                if(file_exists($module_api_file)){
                    require_once $module_api_file;
                }
            }
        }else{
            $response = [
                'response'  => 404,
                'message'   => 'URL API IS NOT FOUND'
            ];
            echo encode_json($response);
        }
        break;
}