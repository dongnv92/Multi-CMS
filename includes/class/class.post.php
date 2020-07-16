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
    const post_images           = 'post_images';
    const post_user             = 'post_user';
    const post_status           = 'post_status';
    const post_view             = 'post_view';
    const post_feature          = 'post_feature';
    const post_time             = 'post_time';
    const post_feature_value    = ['true', 'false'];
    const post_status_value     = ['public', 'pending'];

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

    public function get_post($where, $select = '*'){
        $db                     = $this->db;
        $where[self::post_type] = $this->type;
        $data                   = $db->select($select)->from(self::table)->where($where)->fetch_first();
        if(!$data){
            return false;
        }
        return ['response' => 200, 'data' => $data];
    }

    public function delete($id){
        $db     = $this->db;
        if(!$this->check_post(['post_id' => $id]))
            return get_response_array(309, 'Bài viết không tồn tại hoặc đã bị xóa khỏi hệ thống.');
        $delete = $db->delete()->from(self::table)->where([self::post_id => $id, self::post_type => $this->type])->limit(1)->execute();
        if(!$delete)
            return get_response_array(208, 'Xóa dữ liệu không thành công!');
        return get_response_array(200, 'Xóa dữ liệu thành công!');
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

        // Tính tổng data
        $db->select('COUNT(*) AS count_data')->from(self::table);
        if($_REQUEST['search']){
            $db->where(get_query_search($_REQUEST['search'], [self::post_title, self::post_content, self::post_short_content, self::post_keyword]));
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
            $db->where(get_query_search($_REQUEST['search'], [self::post_title, self::post_content, self::post_short_content, self::post_keyword]));
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

    private function check_category($id_category){
        $db = $this->db;
        switch ($this->type){
            case 'blog':
                $meta_type = 'blog_category';
                break;
        }
        $meta = $db->select('COUNT(*) AS count')->from('dong_meta')->where(['meta_type' => $meta_type, 'meta_id' => $id_category])->fetch_first();
        if($meta['count'] > 0)
            return true;
        return false;
    }

    public function update_post_images($id_post, $images_url){
        $db = $this->db;
        if(!$this->check_post(['post_id' => $id_post])){
            return get_response_array(309, 'ID Post không tồn tại.');
        }
        $update = $db->where('post_id', $id_post)->update(self::table, [self::post_images => $images_url]);
        if(!$update){
            return get_response_array(208, "Cập nhật dữ liệu không thành công.");
        }
        return get_response_array(200, "Cập nhật dữ liệu thành công.");
    }

    public function add(){
        $db = $this->db;
        global $me;

        // Kiểm tra tiêu đề
        if(!validate_isset($_REQUEST[self::post_title]))
            return get_response_array(309, 'Bạn cần nhập tên.');
        if($this->check_post(['post_title' => $_REQUEST[self::post_title]]))
            return get_response_array(309, 'Tên đã tồn tại. Vui lòng chọn tên khác');
        if(!validate_isset($_REQUEST[self::post_content]))
            return get_response_array(309, 'Bạn cần nội dung.');

        // Kiểm tra url post
        if(validate_isset($_REQUEST[self::post_url])){
            if($this->check_post(['post_url' => $_REQUEST[self::post_url]])){
                return get_response_array(309, 'URL đã tồn tại, vui lòng chọn URL khác.');
            }
        }else{
            $_REQUEST[self::post_url] = sanitize_title($_REQUEST[self::post_title]);
        }

        // Kiểm tra trạng thái bài viết
        if(!validate_isset($_REQUEST[self::post_status]))
            return get_response_array(309, 'Bạn cần chọn trạng thái bài viết.');
        if(!in_array($_REQUEST[self::post_status], self::post_status_value))
            return get_response_array(309, 'Trạng thái bài viết không đúng định dạng.');

        // Kiểm tra bài viết nổi bật, nếu không chọn thì mặc định là false
        if($_REQUEST[self::post_feature]){
            $_REQUEST[self::post_feature] = 'true';
        }else{
            $_REQUEST[self::post_feature] = 'false';
        }

        // Kiểm tra chuyên mục
        if(!validate_isset($_REQUEST[self::post_category]))
            return get_response_array(309, 'Bạn cần chọn một chuyên mục.');
        if(!$this->check_category($_REQUEST[self::post_category]))
            return get_response_array(309, 'Chuyên mục không tồn tại.');

        $data_add = [
            self::post_type             => $this->type,
            self::post_title            => $_REQUEST[self::post_title],
            self::post_content          => $_REQUEST[self::post_content],
            self::post_keyword          => $_REQUEST[self::post_keyword],
            self::post_short_content    => $_REQUEST[self::post_short_content],
            self::post_category         => $_REQUEST[self::post_category],
            self::post_url              => $_REQUEST[self::post_url],
            self::post_status           => $_REQUEST[self::post_status],
            self::post_feature          => $_REQUEST[self::post_feature],
            self::post_time             => get_date_time(),
            self::post_view             => 0,
            self::post_user             => $me['user_id'],
        ];

        $add = $db->insert(self::table, $data_add);
        if(!$add){
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        }
        return ['response' => 200, 'message' => 'Thêm dữ liệu thành công', 'data' => $add];
    }
}