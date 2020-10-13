<?php
require_once 'init.php';
// EAAAAZAw4FxQIBAGjLGd8y4xDyDKPfuYTojKQiJha7P3kE8xSAmNWLRu6xHQJcgeHHnFEKePqskIea9zEoqQsVwGOk2VrRmFkXFzTNQhvZAyS2gLiKaaOLPJzKBAP7M6GGngagx38TOgRpehLkIAAIEC7rHIxpen7AzjiU7I4JZBUUMbcADj

$text = 'Mình chuẩn bị thi công dự án điện áp mái tại tp hải dương quy mô 8MW bạn nào cung cấp vật tư liên quan vui lòng liên hệ zalo,đt 0982984732 0982984734.tks';

function checkPhone($text){
    preg_match_all('/0[0-9]{9}/', $text, $match);
    if(count($match[0]) == 0){
        return false;
    }
    return implode(',', $match[0]);
}

if(!checkPhone($text)){
    echo "Không có số điện thoại";
}else{
    print_r(checkPhone($text));
}
