<?php
class user{
    const OPEN_SSL_METHOD           = 'aes-256-cbc';
    const BASE64_ENCRYPTION_KEY     = 'G1fM0aXhguJ5tVaqVMJOVHB+Jk6QFd99FgkfAcEgwjI';//base64_encode(openssl_random_pseudo_bytes(32));
    const BASE64_IV                 = 'xIkaHuquZFjtP4SI4mIyOg';//base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length(AES_256_CBC)));
    const USER_STATUS_LOGIN_ACCESS  = ['active', 'not_active', 'block'];
    const USER_STATUS_LOGIN_BLOCK   = ['block_forever'];
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
    private $user_block_time;       // Thời gian bị khóa đến bao giờ? datetime
    private $user_block_message;    // Lý do bị khóa (varchar 500)
    private $user_invite;   // Người giới thiệu (int Id người giới thiệu)
    private $user_token;    // Mã truy cập (varchar(500))
    private $user_time;     // Thời gian đăng ký (datetime)

    public function __construct($db){
        $this->db                   = $db;
        $this->db_table             = 'dong_user';
        $this->user_id              = 'user_id';
        $this->user_login           = 'user_login';
        $this->user_password        = 'user_password';
        $this->user_name            = 'user_name';
        $this->user_address         = 'user_address';
        $this->user_phone           = 'user_phone';
        $this->user_email           = 'user_email';
        $this->user_gender          = 'user_gender';
        $this->user_birthday        = 'user_birthday';
        $this->user_married         = 'user_married';
        $this->user_note            = 'user_note';
        $this->user_avatar          = 'user_avatar';
        $this->user_role            = 'user_role';
        $this->user_status          = 'user_status';
        $this->user_block_time      = 'user_block_time';
        $this->user_block_message   = 'user_block_message';
        $this->user_invite          = 'user_invite';
        $this->user_token           = 'user_token';
        $this->user_time            = 'user_time';
    }

    static private function base64_url_encode($input){
        return strtr(base64_encode($input), '+/=', '-_,');
    }

    static private function base64_url_decode($input){
        return base64_decode(strtr($input, '-_,', '+/='));
    }

    function encodeText($message){
        $encrypted = openssl_encrypt($message, self::OPEN_SSL_METHOD, base64_decode(self::BASE64_ENCRYPTION_KEY), 0, base64_decode(self::BASE64_IV));
        $base64_encrypted = self::base64_url_encode($encrypted);
        return $base64_encrypted;
    }

    function decodeText($base64_encrypted){
        $encrypted = self::base64_url_decode($base64_encrypted);
        $decrypted = openssl_decrypt($encrypted, self::OPEN_SSL_METHOD, base64_decode(self::BASE64_ENCRYPTION_KEY), 0, base64_decode(self::BASE64_IV));
        return $decrypted;
    }

    // Check xem access token có hợp lệ không? trả về false hoặc true.
    public function check_access_token($access_token){
        $db = $this->db;
        $db->select('COUNT(*) AS count')->from("{$this->db_table}");
        $db->where("{$this->user_token}", $access_token);
        $db->where_in("{$this->user_status}", self::USER_STATUS_LOGIN_ACCESS);
        $check = $db->fetch_first();
        if($check['count'] == 0)
            return false;
        return true;
    }

    // Lấy thông tin của User
    public function get_user($where = [], $field = '*'){
        $db = $this->db;
        $db->select("$field")->from("{$this->db_table}");
        $db->where($where);
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
        $fields_return  = "{$this->user_id}, {$this->user_login}, {$this->user_name}, {$this->user_address}, {$this->user_phone}, {$this->user_email}, {$this->user_gender}, {$this->user_birthday}, {$this->user_married}, {$this->user_note}, {$this->user_avatar}, {$this->user_role}, {$this->user_status}, {$this->user_invite}, {$this->user_token}, {$this->user_time}";
        $data_user      = $this->get_user(["{$this->user_token}" => $_SESSION['access_token']], $fields_return);

        // Nếu thông tin không chính xác thì thoát
        if(!$data_user)
            return false;

        define('ACCESS_TOKEN', $data_user["{$this->user_token}"]);
        return $data_user;
    }

    public function login(){
        $db = $this->db;
        // Nếu chưa điền tên đăng nhập thì báo lỗi.
        if(!$_REQUEST['user_login'])
            return get_response_array(309, 'Bạn cần nhập tên đăng nhập.');

        // Nếu chưa điền mật khẩu thì báo lỗi
        if(!$_REQUEST['user_pass'])
            return get_response_array(309, 'Bạn cần nhập mật khẩu.');

        // Kiểm tra xem tài khoản có tồn tại không
        $db->select('COUNT(*) AS count')->from($this->db_table);
        $db->open_where();
        $db->where($this->user_login, $_REQUEST['user_login']);
        $db->or_where($this->user_email, $_REQUEST['user_login']);
        $db->or_where($this->user_phone, $_REQUEST['user_login']);
        $db->close_where();
        $check_user_login = $db->fetch_first();
        if($check_user_login['count'] == 0)
            return get_response_array(302, 'Tài khoản không tồn tại.');

        // Kiểm tra xem tài khoản có bị khóa vĩnh viễn hay không?
        $db->select('COUNT(*) AS count')->from($this->db_table);
        $db->where($this->user_status, 'block_forever');
        $db->open_where();
        $db->where($this->user_login, $_REQUEST['user_login']);
        $db->or_where($this->user_email, $_REQUEST['user_login']);
        $db->or_where($this->user_phone, $_REQUEST['user_login']);
        $db->close_where();
        $check_user_login = $db->fetch_first();
        if($check_user_login['count'] > 0)
            return get_response_array(302, 'Tài khoản của bạn đang bị khóa. Liên hệ BQT để được giải đáp.');

        // Kiểm tra xem tài khoản có bị tạm khóa và thời gian bị khóa có lớn hơn thời gian hiện tại hay không?
        $db->select("COUNT(*) AS count, {$this->user_block_time}")->from($this->db_table);
        $db->where($this->user_status, 'block');
        $db->where("{$this->user_block_time} >", get_date_time());
        $db->open_where();
        $db->where($this->user_login, $_REQUEST['user_login']);
        $db->or_where($this->user_email, $_REQUEST['user_login']);
        $db->or_where($this->user_phone, $_REQUEST['user_login']);
        $db->close_where();
        $check_user_login = $db->fetch_first();
        if($check_user_login['count'] > 0)
            return get_response_array(302, 'Tài khoản của bạn đang bị tạm khóa. Đăng nhập trong '. human_time_diff(strtotime($check_user_login[$this->user_block_time]), time(), 'sau') .'.');

        // Kiểm tra xem mật khẩu có chính xác không?
        $db->select("{$this->user_token}")->from($this->db_table);
        $db->where_in($this->user_status, self::USER_STATUS_LOGIN_ACCESS);
        $db->where($this->user_password, $this->encodeText($_REQUEST['user_pass']));
        $db->open_where();
        $db->where($this->user_login, $_REQUEST['user_login']);
        $db->or_where($this->user_email, $_REQUEST['user_login']);
        $db->or_where($this->user_phone, $_REQUEST['user_login']);
        $db->close_where();
        $check_user_login = $db->fetch_first();
        if(!$check_user_login)
            return get_response_array(204, 'Mật khẩu không chính xác.');

        if($_REQUEST['rememberme']){
            setcookie("access_token", $check_user_login[$this->user_token], _CONFIG_TIME + (30 * 24 * 60 * 60));
            $_SESSION['access_token'] = $check_user_login[$this->user_token];
        }else{
            $_SESSION['access_token'] = $check_user_login[$this->user_token];
        }
        return ['response' => 200, 'data' => $check_user_login, 'message' => 'Đăng nhập thành công.'];
    }

    public function logout(){
        session_destroy();
        setcookie('access_token', '');
    }
}