<?php
class user{
    private $db;
    private $db_table;      // Tên bảng
    private $user_id;       // Id thành viên (Tự động tăng)
    private $user_login;    // Tên đăng nhập (varchar(50))
    private $user_password; // Mật khẩu (varchar(200))
    private $user_name;     // Tên hiển thị (varchar(100))
    private $user_address;  // ID địa chỉ (int(11))
    private $user_phone;    // Số điện thoại (varchar(20))
    private $user_email;    // Email (varchar(100))
    private $user_gender;   // Giới tính (varchar(10))
    private $user_birthday; // Ngày sinh (date)
    private $user_married;  // Tình trạng hôn nhân (varchar(20) not|already)
    private $user_note;     // Giới thiệu về bản thân (varchar(1000))
    private $user_avatar;   // Đường dẫn ảnh đại diện (varchar(1000))
    private $user_role;     // ID phân quyền (int)
    private $user_status;   // Trạng thái (varchar(100) active|not_active|block)
    private $user_invite;   // Người giới thiệu (int Id người giới thiệu)
    private $user_token;    // Mã truy cập (varchar(500))
    private $user_time;     // Thời gian đăng ký (datetime)

    public function __construct($db){
        $this->db               = $db;
        $this->db_table         = 'dong_user';
        $this->user_id          = 'user_id';
        $this->user_login       = 'user_login';
        $this->user_password    = 'user_password';
        $this->user_name        = 'user_name';
        $this->user_address     = 'user_address';
        $this->user_phone       = 'user_phone';
        $this->user_email       = 'user_email';
        $this->user_gender      = 'user_gender';
        $this->user_birthday    = 'user_birthday';
        $this->user_married     = 'user_married';
        $this->user_note        = 'user_note';
        $this->user_avatar      = 'user_avatar';
        $this->user_role        = 'user_role';
        $this->user_status      = 'user_status';
        $this->user_invite      = 'user_invite';
        $this->user_token       = 'user_token';
        $this->user_time        = 'user_time';
    }

    // Check xem access token có hợp lệ không? trả về false hoặc true.
    public function check_access_token($access_token){
        $db = $this->db;
        $db->select('COUNT(*) AS count')->from("{$this->db_table}");
        $db->where("{$this->user_token}", $access_token);
        $db->where_in("{$this->user_status}", ['active', 'not_active']);
        $check = $db->fetch_first();
        if($check['count'] == 0)
            return false;
        return true;
    }

    // Lấy thông tin của User
    public function get_user($where = [''], $field = '*'){
        $db = $this->db;
        $db->select("$field")->from("{$this->db_table}");
        $db->where("$where");
        $data = $db->fetch_first();
        if(!$data)
            return false;
        return $data;
    }


    // Lấy thông tin user qua user_token
    function init_get_me(){
        /** Kiểm tra cookie, nếu có thì gán cho Session */
        if ($_COOKIE['access_token'])
            $_SESSION['access_token'] = $_COOKIE['access_token'];

        // Nếu Session không tồn tại thì thoát
        if(!$_SESSION['access_token'])
            return false;

        // Check Access Token xem có gợp lệ không?
        $check_token = $this->check_access_token($_SESSION['access_token']);

        // Nếu không hợp lệ thì thoát
        if(!$check_token)
            return false;

        // lấy thông tin thành viên
        $fields_return = "{$this->user_id}, {$this->user_login}, {$this->user_name}, {$this->user_address}, {$this->user_phone}, {$this->user_email}, {$this->user_gender}, {$this->user_birthday}, {$this->user_married}, {$this->user_note}, {$this->user_avatar}, {$this->user_role}, {$this->user_status}, {$this->user_invite}, {$this->user_token}, {$this->user_time}";
        $data_user = $this->get_user(["{$this->user_token}" => $_SESSION['access_token']], $fields_return);

        // Nếu thông tin không chính xác thì thoát
        if(!$data_user)
            return false;

        define('ACCESS_TOKEN', $data_user["{$this->user_token}"]);
        return $data_user;
    }
}