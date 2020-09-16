<?php
class Kplus{
    private $db;
    const table         = 'dong_kplus';
    const kplus_id      = 'kplus_id';
    const kplus_code    = 'kplus_code';
    const kplus_expired = 'kplus_expired';
    const kplus_name    = 'kplus_name';
    const kplus_status  = 'kplus_status'; // unregistered|registered
    const kplus_note    = 'kplus_note';
    const kplus_time    = 'kplus_time';

    public function __construct($database){
        $this->db = $database;
    }

    private function validateCode($code){
        if(strlen($code) == 12 && validate_int($code)){
            return true;
        }
        return false;
    }

    // dd/mm/yyyy VD 24/02/1992
    private function checkDate($date){
        if(strlen(trim($date)) != 10){
            return false;
        }
        $date = explode('/',$date);
        if(!checkdate($date[1], $date[0], $date[2])){
            return false;
        }
        return true;
    }

    public function checkCodeAvailable($code){
        $db = $this->db;
        if(!$this->validateCode($code)){
            return false;
        }
        $count = $db->select('COUNT(*) AS count')->from(self::table)->where(self::kplus_code, $code)->fetch_first();
        if($count['count'] > 0){
            return false;
        }
        return true;
    }

    public function adds(){
        $content    = $_REQUEST['content'];
        if(!validate_isset($content)){
            return get_response_array(309, 'Chưa có nội dung.');
        }
        if(!validate_isset($_REQUEST[self::kplus_expired])){
            return get_response_array(309, 'Bạn cần nhập ngày hết hạn.');
        }
        $content = explode("\n", $content);
        $success = 0;
        $error   = 0;

        foreach ($content AS $_content){
            $_content_new = str_replace([' ', '-'], '', $_content);
            $_content_new = explode('/', $_content_new);
            $_REQUEST['kplus_code']     = $_content_new[0];
            $action = $this->add();
            if($action['response'] == 200){
                $success+=1;
            }else{
                $error+=1;
            }
        }

        return get_response_array(200, "Thêm thành công $success mã. Lỗi $error mã.");
    }

    public function add(){
        $db = $this->db;
        $_REQUEST[self::kplus_code] = str_replace(' ', '', $_REQUEST[self::kplus_code]);

        if(!$this->validateCode($_REQUEST[self::kplus_code])){
            return get_response_array(309, 'Mã thẻ trống hoặc sai định dạng.');
        }
        if(!$this->checkCodeAvailable($_REQUEST[self::kplus_code])){
            return get_response_array(309, 'Mã thẻ đã được sử dụng.');
        }
        if(!validate_isset($_REQUEST[self::kplus_expired])){
            return get_response_array(309, 'Bạn cần nhập ngày hết hạn.');
        }
        if(!$this->checkDate($_REQUEST[self::kplus_expired])){
            return get_response_array(309, 'Ngày hết hạn không hợp lệ.');
        }
        $kplus_expired = explode('/', $_REQUEST[self::kplus_expired]);

        $data = [
            self::kplus_code        => $db->escape($_REQUEST[self::kplus_code]),
            self::kplus_expired     => $db->escape($kplus_expired[2].'-'.$kplus_expired[1].'-'.$kplus_expired[0]),
            self::kplus_name        => $db->escape($_REQUEST[self::kplus_name]),
            self::kplus_status      => 'unregistered',
            self::kplus_time        => get_date_time()
        ];

        $action = $db->insert(self::table, $data);
        if(!$action){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }
        return ['response' => 200, 'message' => 'Thêm dữ liệu thành công', 'data' => $action];
    }
}