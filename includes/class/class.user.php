<?php
class user{
    private $db;
    private $db_table;
    private $user_id;
    private $user_token;

    public function __construct($db){
        $this->db           = $db;
        $this->db_table     = 'dong_users';
        $this->user_id      = 'user_id';
        $this->user_token   = 'user_token';
    }

    function login(){
        $db = $this->db;
        /** Kiểm tra cookie */
        if ($_COOKIE['access_token']) {
            $_SESSION['access_token'] = $_COOKIE['access_token'];
        }

        /** Kiểm tra tồn tại của tên đăng nhập và mật khẩu  */
        if ($_SESSION['access_token']) {
            $user_token = ['access_token' => $_SESSION['access_token']];
            $user_token = json_decode($function->curlAPI($user_token, 'POST',_URL_API.'/user/info'),true);
            if($user_token['response'] == 200){
                $user   = $user_token['data'];
                $role   = unserialize($user['meta_info']);
                define('_ACCESS_TOKEN', $user['user_token']);
            }else{
                unset ($_SESSION['access_token']);
                setcookie('access_token', '');
                $user_token = false;
            }
        }
    }

    public function check_user_by_access_token($access_token){
        $db     = $this->db;
        $where  = [$this->user_token => $access_token];
        $check_access_token = $db->select("COUNT(*) AS count_user")->from($this->db_table)->where($where)->fetch_first();
        if($check_access_token['count_user'] == 0)
            return false;
        return true;
    }
}