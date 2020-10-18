<?php

$text   = '20/02/2021 - 22/02/2021';
$count  = explode('-', $text);
$text_n = trim($count[1]);
echo $text_n;