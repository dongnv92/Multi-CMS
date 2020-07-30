<?php
$momo = new Momo();
$data = json_decode($momo->history(10), true);
echo '<pre>';
print_r($data);
echo '</pre>';