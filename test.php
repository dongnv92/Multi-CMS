<?php
require_once 'init.php';
// EAAAAZAw4FxQIBAGjLGd8y4xDyDKPfuYTojKQiJha7P3kE8xSAmNWLRu6xHQJcgeHHnFEKePqskIea9zEoqQsVwGOk2VrRmFkXFzTNQhvZAyS2gLiKaaOLPJzKBAP7M6GGngagx38TOgRpehLkIAAIEC7rHIxpen7AzjiU7I4JZBUUMbcADj

$text = 'Mình chuẩn bị thi công dự án điện áp mái tại tp hải dương quy mô 8MW bạn nào cung cấp vật tư liên quan vui lòng liên hệ zalo,đt 0982987382.tks';
preg_match_all('/0[0-9]{9}/', $text, $match);

print_r($match);