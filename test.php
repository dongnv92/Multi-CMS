<?php
require_once 'init.php';

$text = '135259368791/ - 25/12/2020';
$text = str_replace([' ', '-'], '', $text);
$text = explode('/', $text);
echo "Code: {$text[0]}\n Day: {$text[1]}\n Month: {$text[2]}\n Year: {$text[3]}\n";