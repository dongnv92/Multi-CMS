<?php

function admin_breadcrumbs($title, $title_des = '', $title_active, $list_url = ''){
    $li = '';
    if(is_array($list_url)){
        foreach ($list_url AS $key => $value){
            $li .= '<li class="breadcrumb-item"><a href="'. $key .'">'. $value .'</a></li>';
        }
    }
    $text = "<div class=\"block-header\">
        <div class=\"row\">
            <div class=\"col-lg-7 col-md-6 col-sm-12\">
                <h2>$title
                ". ($title_des ? '<small class="text-muted">'. $title_des .'</small>' : '') ."
                </h2>
            </div>
            <div class=\"col-lg-5 col-md-6 col-sm-12\">
                <ul class=\"breadcrumb float-md-right\">
                    <li class=\"breadcrumb-item\"><a href=\"". URL_HOME ."\"><i class=\"zmdi zmdi-home\"></i> Trang chủ</a></li>
                    $li
                    <li class=\"breadcrumb-item active\">$title_active</li>
                </ul>
            </div>
        </div>
    </div>";
    return $text;
}