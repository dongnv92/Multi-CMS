<?php
class Pickup{
    private $table                  = 'dong_pickup';
    private $pickup_id              = 'pickup_id';
    private $pickup_big_car         = 'pickup_big_car';
    private $pickup_date_move       = 'pickup_date_move';
    private $pickup_weight          = 'pickup_weight';
    private $pickup_up              = 'pickup_up';
    private $pickup_down            = 'pickup_down';
    private $pickup_weight_total    = 'pickup_weight_total';
    private $pickup_user_receive    = 'pickup_user_receive';
    private $pickup_note            = 'pickup_note';
    private $pickup_create          = 'pickup_create';

    public function __construct(){
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

    public function add(){
        global $database;
        $user = new user($database);

        if(!$_REQUEST[$this->pickup_date_move]){
            return get_response_array(309, 'Bạn cần nhập ngày vận chuyển.');
        }
        if(!$this->checkDate($_REQUEST[$this->pickup_date_move])){
            return get_response_array(309, 'Ngày vận chuyển sai định dạng (d/m/Y VD: 31/12/2021).');
        }
        if(!$_REQUEST[$this->pickup_big_car]){
            return get_response_array(309, 'Bạn cần nhập biển số xe lớn.');
        }
        if(!$_REQUEST[$this->pickup_weight]){
            return get_response_array(309, 'Bạn cần nhập số tấn hàng.');
        }
        if(!validate_numeric($_REQUEST[$this->pickup_weight])){
            return get_response_array(309, 'Số tấn hàng phải là dạng số.');
        }
        if(!$_REQUEST[$this->pickup_user_receive]){
            return get_response_array(309, 'Bạn cần chọn điều phối nhận hàng.');
        }
        if(!$user->check_user($_REQUEST[$this->pickup_user_receive],'id')){
            return get_response_array(309, 'Điều phối không chính xác.');
        }

        $pickup_date_move_explore   = explode('/', trim($_REQUEST[$this->pickup_date_move]));
        $cal_pickup_weight_total    = 0;
        if($_REQUEST[$this->pickup_up] && $_REQUEST[$this->pickup_down]){
            $cal_pickup_weight_total = $_REQUEST[$this->pickup_weight] * 2;
        }else if($_REQUEST[$this->pickup_up] && !$_REQUEST[$this->pickup_down]){
            $cal_pickup_weight_total = $_REQUEST[$this->pickup_weight];
        }else if(!$_REQUEST[$this->pickup_up] && $_REQUEST[$this->pickup_down]){
            $cal_pickup_weight_total = $_REQUEST[$this->pickup_weight];
        }

        $data = [
            $this->pickup_big_car       => $database->escape(trim($_REQUEST[$this->pickup_big_car])),
            $this->pickup_date_move     => "{$pickup_date_move_explore[2]}-{$pickup_date_move_explore[1]}-{$pickup_date_move_explore[0]}",
            $this->pickup_weight        => $database->escape(trim($_REQUEST[$this->pickup_weight])),
            $this->pickup_up            => $database->escape($_REQUEST[$this->pickup_up] ? 'yes' : 'no'),
            $this->pickup_down          => $database->escape($_REQUEST[$this->pickup_down] ? 'yes' : 'no'),
            $this->pickup_weight_total  => $database->escape($cal_pickup_weight_total),
            $this->pickup_user_receive  => $database->escape(trim($_REQUEST[$this->pickup_user_receive])),
            $this->pickup_note          => $database->escape(trim($_REQUEST[$this->pickup_note])),
            $this->pickup_create        => get_date_time()
        ];

        $action = $database->insert($this->table, $data);
        if(!$action){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }
        return get_response_array(200, "Thêm dữ liệu thành công.");
    }
}