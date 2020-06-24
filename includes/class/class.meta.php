<?php
class meta{
    private $db;
    private $db_table;
    private $type;
    private $meta_id;
    private $meta_type;
    private $meta_name;
    private $meta_des;
    private $meta_url;
    private $meta_info;
    private $meta_images;
    private $meta_parent;
    private $meta_user;
    private $meta_time;

    public function __construct($db, $meta_type){
        $this->db           = $db;
        $this->db_table     = 'dong_meta';
        $this->meta_id      = 'meta_id';
        $this->meta_type    = 'meta_type';
        $this->meta_name    = 'meta_name';
        $this->meta_des     = 'meta_des';
        $this->meta_url     = 'meta_url';
        $this->meta_info    = 'meta_info';
        $this->meta_images  = 'meta_images';
        $this->meta_parent  = 'meta_parent';
        $this->meta_url     = 'meta_user';
        $this->meta_user    = 'meta_user';
        $this->meta_time    = 'meta_time';
        $this->type         = $meta_type;
    }

    private function check_name($name){
        $db     = $this->db;
        $check  = $db->select('COUNT(*) AS count')->from($this->db_table)->where([$this->meta_name => $name, $this->meta_type => $this->type])->fetch_first();
        if($check['count'] > 0)
            return true;
        return false;
    }

    public function add(){
        global $me;
        $db = $this->db;
        if(!validate_isset($_REQUEST[$this->meta_name]))
            return get_response_array(309, 'Bạn cần nhập tên vai trò thành viên.'. $me['user_name']);

        if($this->check_name($_REQUEST[$this->meta_name]))
            return get_response_array(310, "Tên vai trò thành viên ({$_REQUEST[$this->meta_name]}) đã tồn tại, vui lòng chọn tên khác.");

        $meta_info  = [];
        $data_role      = role_structure();
        foreach ($data_role AS $key => $value){
            foreach ($value AS $_key => $_value){
                if($_REQUEST["{$key}_{$_key}"]){
                    $meta_info[$key][$_key] = true;
                }else{
                    $meta_info[$key][$_key] = false;
                }
            }
        }
        $meta_info  = serialize($meta_info);
        $data_add   = [
            'meta_type'     => $db->escape($this->type),
            'meta_name'     => $db->escape($_REQUEST[$this->meta_name]),
            'meta_des'      => $db->escape($_REQUEST[$this->meta_des]),
            'meta_url'      => '',
            'meta_info'     => $db->escape($meta_info),
            'meta_images'   => '',
            'meta_parent'   => '0',
            'meta_user'     => $me['user_id'],
            'meta_time'     => get_date_time()
        ];

        $data_add = $db->insert($this->db_table, $data_add);
        if(!$data_add)
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        return get_response_array(200, "Thêm dữ liệu thành công.");
    }
}