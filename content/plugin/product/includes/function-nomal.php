<?php
// Function hiển thị tiền thêm dấu chấm
function convert_number_to_money($number){
    return number_format($number, 0, '', '.');
}