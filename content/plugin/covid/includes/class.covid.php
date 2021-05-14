<?php
class pCovid{
    private $table = 'dong_covid';

    public function __construct(){
    }

    public function add(){
        global $database, $me;

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
        if(!$_REQUEST['covid_user_name']){
            return get_response_array(309, 'Bạn cần nhập tên của mình.');
        }
        if(!$_REQUEST['covid_sodienthoai']){
            return get_response_array(309, 'Bạn cần nhập số điện thoại của mình.');
        }

        $field = [
            'covid_hovaten'             => $database->escape($_REQUEST['covid_hovaten']),
            'covid_namsinh'             =>  $database->escape($_REQUEST['covid_namsinh']),
            'covid_gioitinh'            =>  $database->escape($_REQUEST['covid_gioitinh']),
            'covid_xom'                 =>  $database->escape($_REQUEST['covid_xom']),
            'covid_thon'                =>  $database->escape($_REQUEST['covid_thon']),
            'covid_xa'                  =>  $database->escape($_REQUEST['covid_xa']),
            'covid_huyen'               =>  $database->escape($_REQUEST['covid_huyen']),
            'covid_tinh'                =>  $database->escape($_REQUEST['covid_tinh']),
            'covid_sodienthoai'         =>  $database->escape($_REQUEST['covid_sodienthoai']),
            'covid_nghe'                =>  $database->escape($_REQUEST['covid_nghe']),
            'covid_loaigiamsat'         =>  $database->escape($_REQUEST['covid_loaigiamsat']),
            'covid_ngayphathien'        =>  $database->escape($_REQUEST['covid_ngayphathien']),
            'covid_f'                   =>  $database->escape($_REQUEST['covid_f']),
            'covid_moiquanhe'           =>  $database->escape($_REQUEST['covid_moiquanhe']),
            'covid_phanloaitx'          =>  $database->escape($_REQUEST['covid_phanloaitx']),
            'covid_ngaytxcuoicung'      =>  $database->escape($_REQUEST['covid_ngaytxcuoicung']),
            'covid_motahoancanhtx'      =>  $database->escape($_REQUEST['covid_motahoancanhtx']),
            'covid_ngaykhoiphat'        =>  $database->escape($_REQUEST['covid_ngaykhoiphat']),
            'covid_ngayvaovien'         =>  $database->escape($_REQUEST['covid_ngayvaovien']),
            'covid_ngayravien'          =>  $database->escape($_REQUEST['covid_ngayravien']),
            'covid_loaicanhly'          =>  $database->escape($_REQUEST['covid_loaicanhly']),
            'covid_ngaycachly'          =>  $database->escape($_REQUEST['covid_ngaycachly']),
            'covid_noicachly'           =>  $database->escape($_REQUEST['covid_noicachly']),
            'covid_ngaychamdutcachly'   =>  $database->escape($_REQUEST['covid_ngaychamdutcachly']),
            'covid_xetnghiemchua'       =>  $database->escape($_REQUEST['covid_xetnghiemchua']),
            'covid_solanxetnghiem'      =>  $database->escape($_REQUEST['covid_solanxetnghiem']),
            'covid_user_name'           =>  $database->escape($_REQUEST['covid_user_name']),
            'covid_user_phone'          =>  $database->escape($_REQUEST['covid_user_phone']),
            'covid_user'                =>  $database->escape($me['user_id']),
            'covid_time'                =>  get_date_time()
        ];
        $add = $database->insert($this->table, $field);
        if(!$add){
            return get_response_array(309, 'Thêm mới không thành công.');
        }
        return ['response' => 200, 'message' => 'Thêm dữ liệu thành công'];
    }
}