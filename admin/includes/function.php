<?php
function alert($type = 'success', $content = ''){
    $text = '';
    switch ($type){
        case 'success':
            $text = '<div class="alert alert-success alert-icon alert-dismissible"><em class="icon ni ni-check-circle"></em> '. $content .' <button class="close" data-dismiss="alert"></button></div>';
            break;
        case 'error':
            $text = '<div class="alert alert-danger alert-icon alert-dismissible"><em class="icon ni ni-cross-circle"></em> '. $content .' <button class="close" data-dismiss="alert"></button></div>';
            break;
    }
    return $text;
}