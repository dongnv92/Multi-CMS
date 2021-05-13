<?php
class pCovid{
    public function __construct(){
    }

    public function add(){
        if(!$_REQUEST['covid_hovaten']){
            return get_response_array(309, 'Bạn cần nhập họ và tên người đang khai.');
        }
        if(strlen($_REQUEST['covid_hovaten']) <= 3){
            return get_response_array(309, 'Họ và tên cần lớn hơn 3 ký tự.');
        }
        if(!$_REQUEST['covid_namsinh']){
            return get_response_array(309, 'Bạn cần nhập năm sinh người đang khai.');
        }
        if(strlen($_REQUEST['covid_namsinh']) != 4){
            return get_response_array(309, 'Năm sinh phải đúng.');
        }
        if(!$_REQUEST['covid_gioitinh']){
            return get_response_array(309, 'Bạn cần chọn giới tính người đang khai.');
        }
        if(!$_REQUEST['covid_xom']){
            return get_response_array(309, 'Bạn cần nhập tên Xóm.');
        }
        if(!$_REQUEST['covid_thon']){
            return get_response_array(309, 'Bạn cần nhập tên Thôn.');
        }
        if(!$_REQUEST['covid_xa']){
            return get_response_array(309, 'Bạn cần nhập tên Xã.');
        }
        if(!$_REQUEST['covid_huyen']){
            return get_response_array(309, 'Bạn cần nhập tên Huyện.');
        }
        if(!$_REQUEST['covid_tinh']){
            return get_response_array(309, 'Bạn cần nhập tên Tỉnh.');
        }
        if(!$_REQUEST['covid_sodienthoai']){
            return get_response_array(309, 'Bạn cần nhập số điện thoại.');
        }

    }
}