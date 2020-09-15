<?php
require_once '../init.php';

switch ($path[1]){
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
        }
        break;
}