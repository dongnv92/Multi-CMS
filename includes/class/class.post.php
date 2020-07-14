<?php
class Post{
    private $type, $db;
    const table                 = 'dong_post';
    const post_id               = 'post_id';
    const post_type             = 'post_type';
    const post_title            = 'post_title';
    const post_content          = 'post_content';
    const post_keyword          = 'post_keyword';
    const post_short_content    = 'post_short_content';
    const post_category         = 'post_category';
    const post_url              = 'post_url';
    const post_user             = 'post_user';
    const post_status           = 'post_status';
    const post_view             = 'post_view';
    const post_feature          = 'post_feature';
    const post_time             = 'post_time';

    public function __construct($database, $type){
        $this->db   = $database;
        $this->type = $type;
    }

    private function check_post($where){
        $db                     = $this->db;
        $where[self::post_type] = $this->type;
        $check  = $db->select('COUNT(*) AS count')->from(self::table)->where($where)->fetch_first();
        if($check['count'] > 0)
            return true;
        return false;
    }

    public function add(){
        $db = $this->db;

        // Kiểm tra tiêu đề
        if(!validate_isset($_REQUEST[self::post_title]))
            return get_response_array(309, 'Bạn cần nhập tên.');
        if($this->check_post(['post_title' => $_REQUEST[self::post_title]]))
            return get_response_array(309, 'Tên đã tồn tại. Vui lòng chọn tên khác');
        if(!validate_isset($_REQUEST[self::post_content]))
            return get_response_array(309, 'Bạn cần nội dung.');
        if($_REQUEST[self::post_url]){
            if(validate_isset($_REQUEST[self::post_url])){
                return get_response_array(309, 'URL đã tồn tại, vui lòng chọn URL khác.');
            }
        }else{
            $_REQUEST[self::post_url] = sanitize_title($_REQUEST[self::post_title]);
        }


    }
}