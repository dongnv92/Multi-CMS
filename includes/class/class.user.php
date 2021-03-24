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

    public function get_all_user_by_role($role){
        global $database;
        $check_role = $database->select('COUNT(*) AS count')->from('dong_meta')->where(['meta_type' => 'role', 'meta_id' => $role])->fetch_first();
        if($check_role['count'] == 0){
            return false;
        }
        $user = $database->select("{$this->user_id}, {$this->user_name}")->from($this->db_table)->where($this->user_role, $role)->fetch();
        if(!$user){
            return false;
        }
        return $user;
    }

    // Lấy danh sách tất cả thành viên
    public function get_all(){
        $db         = $this->db;
        $param      = get_param_defaul();
        $page       = $param['page'];
        $limit      = $param['limit'];
        $offset     = $param['offset'];
        $where      = [];
        $pagination = [];

        if($_REQUEST[$this->user_status] && (in_array($_REQUEST[$this->user_status], self::USER_STATUS_LOGIN_ACCESS) || in_array($_REQUEST[$this->user_status], self::USER_STATUS_LOGIN_BLOCK))){
            $where[$this->user_status] = $_REQUEST[$this->user_status];
        }

        // Tính tổng data
        $db->select('COUNT(*) AS count_data')->from($this->db_table);
        if($_REQUEST['search']){
            $db->where(get_query_search($_REQUEST['search'], [$this->user_login, $this->user_name, $this->user_email, $this->user_phone]));
        }
        if($where){
            $db->where($where);
        }
        $data_count                 = $db->fetch_first();
        $pagination['count']        = $data_count['count_data'];                    // Tổng số bản ghi
        $pagination['page_num']     = ceil($pagination['count'] / $limit);   // Tổng số trang
        $pagination['page_start']   = ($page - 1) * $limit;                        // Bắt đầu từ số bản ghi này

        // Nếu số trang hiện tại lớn hơn tổng số trang thì bào lỗi
        if(($page - 1) > $pagination['page_num'] || $offset > $pagination['count'])
            return get_response_array(311, 'Số trang không được lớn hơn số dữ liệu có.');

        // Hiển thị dữ liệu theo số liệu nhập vào
        $db->select('*')->from($this->db_table);
        if($_REQUEST['search']){
            $db->where(get_query_search($_REQUEST['search'], [$this->user_login, $this->user_name, $this->user_email, $this->user_phone]));
        }
        if($where){
            $db->where($where);
        }
        $db->limit($limit, ($page > 1 ? $pagination['page_start'] : $offset));
        if($_REQUEST['sort']){
            $sort = explode('.',$_REQUEST['sort']);
            if(count($sort) == 1){
                $db->order_by($sort[0]);
            }else if(count($sort) == 2 && in_array($sort[1], ['asc', 'ASC', 'desc', 'DESC'])){
                $db->order_by($sort[0], $sort[1]);
            }
        }
        $data = $db->fetch();
        $response = [
            'response'  => 200,
            'paging'    => [
                'count_data'    => $pagination['count'],
                'page'          => $pagination['page_num'],
                'page_current'  => $page,
                'limit'         => $limit,
                'offset'        => $page > 1 ? $pagination['page_start'] : $offset
            ],
            'data'      => $data
        ];
        return $response;
    }

    public function delete($id){
        $db         = $this->db;
        $user_count = $db->select('COUNT(*) AS count')->from($this->db_table)->fetch_first();
        if(!$this->check_user($id, 'id'))
            return get_response_array(309, 'Thành viên không tồn tại hoặc đã bị xóa khỏi hệ thống.');
        if($user_count['count'] == 1)
            return get_response_array(309, 'Không thể xóa thành viên cuối cùng.');
        if(get_config('user_special') == $id)
            return get_response_array(309, 'Không thể thành viên này.');
        $delete = $db->delete()->from($this->db_table)->where($this->user_id, $id)->limit(1)->execute();
        if(!$delete)
            return get_response_array(208, 'Xóa thành viên không thành công!');
        return get_response_array(200, 'Xóa thành viên thành công!');
    }

    // Lấy thông tin user qua user_token
    function init_get_me(){
        $db = $this->db;
        /** Kiểm tra cookie, nếu có thì gán cho Session */
        if ($_COOKIE['access_token']) {
            $_SESSION['access_token'] = $_COOKIE['access_token'];
        }

        // Nếu Session không tồn tại thì thoát
        if(!$_SESSION['access_token']){
            return false;
        }

        // Check Access Token xem có gợp lệ không?
        $check_token = $this->check_access_token($_SESSION['access_token']);

        // Nếu không hợp lệ thì thoát
        if(!$check_token){
            return false;
        }

        // lấy thông tin thành viên
        $fields_return  = "{$this->user_id}, {$this->user_login}, {$this->user_name}, {$this->user_address}, {$this->user_phone}, {$this->user_email}, {$this->user_gender}, {$this->user_birthday}, {$this->user_married}, {$this->user_note}, {$this->user_avatar}, {$this->user_role}, {$this->user_status}, {$this->user_invite}, {$this->user_token}, {$this->user_time}";
        $data_user      = $this->get_user(["{$this->user_token}" => $_SESSION['access_token']], $fields_return);

        // Nếu thông tin không chính xác thì thoát
        if(!$data_user){
            return false;
        }

        // Lấy thông tin chức năng thành viên
        $role = $db->select('meta_name')->from('dong_meta')->where(['meta_type' => 'role', 'meta_id' => $data_user['user_role']])->fetch_first();
        $data_user['meta_name'] = $role['meta_name'];

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
        $db->select("{$this->user_token}, {$this->user_id}")->from($this->db_table);
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
        $db->where([$this->user_id => $check_user_login[$this->user_id]])->update($this->db_table, ['user_status' => 'active']);
        return ['response' => 200, 'data' => $check_user_login, 'message' => 'Đăng nhập thành công.'];
    }

    public function check_user($data, $check_type = ''){
        $db   = $this->db;
        $user = false;
        switch ($check_type){
            case 'id':
                $check = $db->select('COUNT(*) AS count')->from($this->db_table)->where($this->user_id, $data)->fetch_first();
                if($check['count'] > 0){
                    $user = true;
                }
                break;
            default:
                $check = $db->select('COUNT(*) AS count')->from($this->db_table)->where($this->user_login, $data)->fetch_first();
                if($check['count'] > 0){
                    $user = true;
                }
                break;
        }
        return $user;
    }

    public function update_avatar($images){
        $db = $this->db;
        if(!$db->where($this->user_token, ACCESS_TOKEN)->update($this->db_table, ['user_avatar' => $images]))
            return get_response_array(208, "Cập nhật ảnh đại diện không thành công.");
        return get_response_array(200, "Cập nhật ảnh đại diện thành công.");
    }

    public function update($id){
        global $me;
        $db             = $this->db;
        $get_user       = $db->select("{$this->user_login}, {$this->user_email}, {$this->user_phone}")->from($this->db_table)->where($this->user_id, $id)->fetch_first();
        $check_user     = $db->select("COUNT(*) AS count")->from($this->db_table)->where($this->user_login, $_REQUEST[$this->user_login])->fetch_first();
        $check_email    = $db->select("COUNT(*) AS count")->from($this->db_table)->where($this->user_email, $_REQUEST[$this->user_email])->fetch_first();
        $check_phone    = $db->select("COUNT(*) AS count")->from($this->db_table)->where($this->user_phone, $_REQUEST[$this->user_phone])->fetch_first();
        $check_role     = $db->select('COUNT(*) AS count')->from('dong_meta')->where(['meta_type' => 'role', 'meta_id' => $_REQUEST[$this->user_role]])->fetch_first();

        if(!$get_user)
            return get_response_array(309, 'Thành viên không tồn tại trên hệ thống hoặc đã bị xóa.');

        // Nếu update thành viên đặc biệt thì báo lỗi
        if(get_config('user_special') == $id && $id !=$me['user_id'])
            return get_response_array(309, 'Bạn không thể cập nhật thành viên này.');

        // Kiểm tra username
        if(!validate_isset($_REQUEST[$this->user_login]))
            return get_response_array(309, 'Bạn cần nhập tên đăng nhập.');
        if(strlen($_REQUEST[$this->user_login]) < 4 || strlen($_REQUEST[$this->user_login]) > 20)
            return get_response_array(309, 'Tên đăng nhập từ 4 đến 20 ký tự.');
        if(!validate_username($_REQUEST[$this->user_login]))
            return get_response_array(309, 'Tên đăng nhập chỉ bao gồm chữ, số, ký tự _ hoặc dấu chấm.');
        if(($_REQUEST[$this->user_login] != $get_user[$this->user_login]) && $check_user['count'] > 0)
            return get_response_array(309, 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác.');

        // Kiểm tra tên hiển thị
        if(!validate_isset($_REQUEST[$this->user_name]))
            return get_response_array(309, 'Bạn cần nhập tên hiển thị.');
        if(strlen($_REQUEST[$this->user_name]) < 4 || strlen($_REQUEST[$this->user_name]) > 20)
            return get_response_array(309, 'Tên hiển thị từ 4 đến 20 ký tự.');

        // Kiểm tra mật khẩu
        if(validate_isset($_REQUEST[$this->user_password])){
            if(strlen($_REQUEST[$this->user_password]) < 4 || strlen($_REQUEST[$this->user_password]) > 20)
                return get_response_array(309, 'Mật khẩu từ 4 đến 20 ký tự.');

            // Kiểm tra nhập lại mật khẩu
            if(!validate_isset($_REQUEST['user_repass']))
                return get_response_array(309, 'Bạn cần nhập lại mật khẩu.');
            if($_REQUEST['user_repass'] != $_REQUEST[$this->user_password])
                return get_response_array(309, 'Hai mật khẩu không giống nhau.');
        }

        // Kiểm tra email
        if($_REQUEST[$this->user_email] && !validate_email($_REQUEST[$this->user_email]))
            return get_response_array(309, 'Email không đúng định dạng.');
        if($_REQUEST[$this->user_email] && (($_REQUEST[$this->user_email] != $get_user[$this->user_email]) && $check_email['count'] > 0))
            return get_response_array(309, 'Email đã tồn tại, vui lòng chọn Email khác.');

        // Kiểm tra điện thoại
        if($_REQUEST[$this->user_phone] && (strlen($_REQUEST[$this->user_phone]) < 8 || strlen($_REQUEST[$this->user_phone]) > 35))
            return get_response_array(309, 'Số điện thoại từ 8 đến 35 ký tự.');
        if($_REQUEST[$this->user_phone] && (($_REQUEST[$this->user_phone] != $get_user[$this->user_phone]) && $check_phone['count'] > 0))
            return get_response_array(309, 'Điện thoại đã tồn tại, vui lòng chọn số điện thoại khác.');

        // Kiểm tra vai trò thành viên
        if(!validate_isset($_REQUEST[$this->user_role]))
            return get_response_array(309, 'Bạn cần chọn 1 vai trò thành viên.');
        if(!validate_int($_REQUEST[$this->user_role]))
            return get_response_array(309, 'Vai trò thành viên phải là dạng ID.');
        if($check_role['count'] == 0)
            return get_response_array(309, 'Vai trò thành viên không tồn tại.');

        // Kiểm tra trạng thái
        if(!validate_isset($_REQUEST[$this->user_status]))
            return get_response_array(309, 'Bạn cần chọn 1 trạng thái.');
        if(!in_array($_REQUEST[$this->user_status], self::USER_STATUS_LOGIN_BLOCK) && !in_array($_REQUEST[$this->user_status], self::USER_STATUS_LOGIN_ACCESS))
            return get_response_array(309, 'Trạng thái không hợp lệ.');


        $data_update = [
            'user_login'    => $db->escape($_REQUEST[$this->user_login]),
            'user_name'     => $db->escape($_REQUEST[$this->user_name]),
            'user_phone'    => $db->escape($_REQUEST[$this->user_phone]),
            'user_email'    => $db->escape($_REQUEST[$this->user_email]),
            'user_role'     => $db->escape($_REQUEST[$this->user_role]),
            'user_status'   => $db->escape($_REQUEST[$this->user_status])
        ];
        if($_REQUEST[$this->user_password]){
            $data_update[$this->user_password] = $this->encodeText($_REQUEST[$this->user_password]);
        }

        $data_update = $db->where($this->user_id, $id)->update($this->db_table, $data_update);
        if(!$data_update)
            return get_response_array(208, "Cập nhật thành viên không thành công.");
        return get_response_array(200, "Cập nhật thành viên thành công.");
    }

    public function update_me(){
        $db             = $this->db;
        $get_user       = $db->select("{$this->user_login}, {$this->user_email}, {$this->user_phone}")->from($this->db_table)->where($this->user_token, ACCESS_TOKEN)->fetch_first();
        $check_email    = $db->select("COUNT(*) AS count")->from($this->db_table)->where($this->user_email, $_REQUEST[$this->user_email])->fetch_first();
        $check_phone    = $db->select("COUNT(*) AS count")->from($this->db_table)->where($this->user_phone, $_REQUEST[$this->user_phone])->fetch_first();

        // Kiểm tra tên hiển thị
        if(!validate_isset($_REQUEST[$this->user_name]))
            return get_response_array(309, 'Bạn cần nhập tên hiển thị.');
        if(strlen($_REQUEST[$this->user_name]) < 4 || strlen($_REQUEST[$this->user_name]) > 20)
            return get_response_array(309, 'Tên hiển thị từ 4 đến 20 ký tự.');

        // Kiểm tra mật khẩu
        if(validate_isset($_REQUEST[$this->user_password])){
            if(strlen($_REQUEST[$this->user_password]) < 4 || strlen($_REQUEST[$this->user_password]) > 20)
                return get_response_array(309, 'Mật khẩu từ 4 đến 20 ký tự.');

            // Kiểm tra nhập lại mật khẩu
            if(!validate_isset($_REQUEST['user_repass']))
                return get_response_array(309, 'Bạn cần nhập lại mật khẩu.');
            if($_REQUEST['user_repass'] != $_REQUEST[$this->user_password])
                return get_response_array(309, 'Hai mật khẩu không giống nhau.');
        }

        // Kiểm tra email
        if($_REQUEST[$this->user_email] && !validate_email($_REQUEST[$this->user_email]))
            return get_response_array(309, 'Email không đúng định dạng.');
        if($_REQUEST[$this->user_email] && (($_REQUEST[$this->user_email] != $get_user[$this->user_email]) && $check_email['count'] > 0))
            return get_response_array(309, 'Email đã tồn tại, vui lòng chọn Email khác.');

        // Kiểm tra điện thoại
        if($_REQUEST[$this->user_phone] && (strlen($_REQUEST[$this->user_phone]) < 8 || strlen($_REQUEST[$this->user_phone]) > 35))
            return get_response_array(309, 'Số điện thoại từ 8 đến 35 ký tự.');
        if($_REQUEST[$this->user_phone] && (($_REQUEST[$this->user_phone] != $get_user[$this->user_phone]) && $check_phone['count'] > 0))
            return get_response_array(309, 'Điện thoại đã tồn tại, vui lòng chọn số điện thoại khác.');


        $data_update = [
            'user_name'     => $db->escape($_REQUEST[$this->user_name]),
            'user_phone'    => $db->escape($_REQUEST[$this->user_phone]),
            'user_email'    => $db->escape($_REQUEST[$this->user_email])
        ];
        if($_REQUEST[$this->user_password]){
            $data_update[$this->user_password] = $this->encodeText($_REQUEST[$this->user_password]);
        }

        $data_update = $db->where($this->user_token, ACCESS_TOKEN)->update($this->db_table, $data_update);
        if(!$data_update)
            return get_response_array(208, "Cập nhật hồ sơ thành công.");
        return get_response_array(200, "Cập nhật hồ sơ thành công.");
    }

    public function add(){
        $db         = $this->db;
        $check_role = $db->select('COUNT(*) AS count')->from('dong_meta')->where(['meta_type' => 'role', 'meta_id' => $_REQUEST[$this->user_role]])->fetch_first();
        // Kiểm tra username
        if(!validate_isset($_REQUEST[$this->user_login]))
            return get_response_array(309, 'Bạn cần nhập tên đăng nhập.');
        if(strlen($_REQUEST[$this->user_login]) < 4 || strlen($_REQUEST[$this->user_login]) > 20)
            return get_response_array(309, 'Tên đăng nhập từ 4 đến 20 ký tự.');
        if(!validate_username($_REQUEST[$this->user_login]))
            return get_response_array(309, 'Tên đăng nhập chỉ bao gồm chữ, số, ký tự _ hoặc dấu chấm.');
        if($this->check_user($_REQUEST[$this->user_login]))
            return get_response_array(309, 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác.');

        // Kiểm tra tên hiển thị
        if(!validate_isset($_REQUEST[$this->user_name]))
            return get_response_array(309, 'Bạn cần nhập tên hiển thị.');
        if(strlen($_REQUEST[$this->user_name]) < 4 || strlen($_REQUEST[$this->user_name]) > 20)
            return get_response_array(309, 'Tên hiển thị từ 4 đến 20 ký tự.');

        // Kiểm tra mật khẩu
        if(!validate_isset($_REQUEST[$this->user_password]))
            return get_response_array(309, 'Bạn cần nhập mật khẩu.');
        if(strlen($_REQUEST[$this->user_password]) < 4 || strlen($_REQUEST[$this->user_password]) > 20)
            return get_response_array(309, 'Mật khẩu từ 4 đến 20 ký tự.');

        // Kiểm tra nhập lại mật khẩu
        if(!validate_isset($_REQUEST['user_repass']))
            return get_response_array(309, 'Bạn cần nhập lại mật khẩu.');
        if($_REQUEST['user_repass'] != $_REQUEST[$this->user_password])
            return get_response_array(309, 'Hai mật khẩu không giống nhau.');

        // Kiểm tra email
        if($_REQUEST[$this->user_email] && !validate_email($_REQUEST[$this->user_email]))
            return get_response_array(309, 'Email không đúng định dạng.');

        // Kiểm tra điện thoại
        if($_REQUEST[$this->user_phone] && (strlen($_REQUEST[$this->user_phone]) < 8 || strlen($_REQUEST[$this->user_phone]) > 35))
            return get_response_array(309, 'Số điện thoại từ 8 đến 35 ký tự.');

        // Kiểm tra vai trò thành viên
        if(!validate_isset($_REQUEST[$this->user_role]))
            return get_response_array(309, 'Bạn cần chọn 1 vai trò thành viên.');
        if(!validate_int($_REQUEST[$this->user_role]))
            return get_response_array(309, 'Vai trò thành viên phải là dạng ID.');
        if($check_role['count'] == 0)
            return get_response_array(309, 'Vai trò thành viên không tồn tại.');

        $data_add = [
            'user_login'        => $db->escape($_REQUEST[$this->user_login]),
            'user_password'     => $this->encodeText($_REQUEST[$this->user_password]),
            'user_name'         => $db->escape($_REQUEST[$this->user_name]),
            'user_address'      => '',
            'user_phone'        => $db->escape($_REQUEST[$this->user_phone]),
            'user_email'        => $db->escape($_REQUEST[$this->user_email]),
            'user_gender'       => '',
            'user_birthday'     => '',
            'user_married'      => '',
            'user_note'         => '',
            'user_avatar'       => '',
            'user_role'         => $db->escape($_REQUEST[$this->user_role]),
            'user_status'       => 'active',
            'user_block_time'   => '',
            'user_block_message'=> '',
            'user_invite'       => '',
            'user_token'        => $this->encodeText($_REQUEST[$this->user_name].time()),
            'user_time'         => get_date_time()
        ];
        $data_add = $db->insert($this->db_table, $data_add);
        if(!$data_add)
            return get_response_array(208, "Thêm thành viên mới không thành công.");
        return get_response_array(200, "Thêm thành viên mới thành công.");
    }

    public function logout(){
        session_destroy();
        setcookie('access_token', '');
    }
}