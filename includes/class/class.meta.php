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

    public function get_data_select(){
        $db     = $this->db;
        $data   = $db->select("{$this->meta_id}, {$this->meta_name}")->from($this->db_table)->where($this->meta_type, $this->type)->fetch();
        $result = [];
        foreach ($data AS $_data){
            $result[$_data[$this->meta_id]] = $_data[$this->meta_name];
        }
        return $result;
    }

    private function check_name($name){
        $db     = $this->db;
        $check  = $db->select('COUNT(*) AS count')->from($this->db_table)->where([$this->meta_name => $name, $this->meta_type => $this->type])->fetch_first();
        if($check['count'] > 0)
            return true;
        return false;
    }

    private function check_url($url){
        $db     = $this->db;
        $check  = $db->select('COUNT(*) AS count')->from($this->db_table)->where([$this->meta_url=> $url, $this->meta_type => $this->type])->fetch_first();
        if($check['count'] > 0)
            return true;
        return false;
    }

    private function check_id($id){
        $db     = $this->db;
        $check  = $db->select('COUNT(*) AS count')->from($this->db_table)->where([$this->meta_id=> $id, $this->meta_type => $this->type])->fetch_first();
        if($check['count'] > 0)
            return true;
        return false;
    }


    public function get_meta($id, $field = '*'){
        if(!validate_int($id) || !$id)
            return get_response_array(311, 'ID phải là dạng số.');
        $db     = $this->db;
        $meta   = $db->select($field)->from($this->db_table)->where([$this->meta_type => $this->type, $this->meta_id => $id])->fetch_first();
        if(!$meta)
            return get_response_array(302, 'Dữ liệu không tồn tại.');
        return ['response' => 200, 'data' => $meta];
    }

    public function delete($id){
        // Nếu chưa có id hoặc sai định dạng int thì báo lỗi
        if(!validate_int($id) || !$id)
            return get_response_array(311, 'ID phải là dạng số.');
        $db     = $this->db;
        $meta   = $db->select('COUNT(*) AS count')->from($this->db_table)->where([$this->meta_type => $this->type, $this->meta_id => $id])->fetch_first();

        // Nếu id không tồn tại thì báo lỗi
        if(!$meta)
            return get_response_array(302, 'Dữ liệu không tồn tại.');

        // Nếu id là id đặc biệt thì báo lỗi
        if($id == get_config('role_special'))
            return get_response_array(302, 'Không thể xóa dữ liệu này!');

        // Nếu id là id mặc định thì báo lỗi
        if($id == get_config('role_default'))
            return get_response_array(302, 'Không thể xóa dữ liệu này!');

        $delete = $db->delete()->from($this->db_table)->where([$this->meta_type => $this->type, $this->meta_id => $id])->limit(1)->execute();
        if(!$delete)
            return get_response_array(208, 'Xóa dữ liệu không thành công!');
        return get_response_array(200, 'Xóa dữ liệu thành công!');
    }

    public function get_all(){
        $db         = $this->db;
        $param      = get_param_defaul();
        $page       = $param['page'];
        $limit      = $param['limit'];
        $offset     = $param['offset'];
        $where      = [];
        $pagination = [];

        // Tính tổng data
        $db->select('COUNT(*) AS count_data')->from($this->db_table);
        if($_REQUEST['search']){
            $db->where(get_query_search($_REQUEST['search'], [$this->meta_name, $this->meta_des]));
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
            $db->where(get_query_search($_REQUEST['search'], [$this->meta_name, $this->meta_des]));
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

    public function update($id){
        // Nếu chưa có id hoặc sai định dạng int thì báo lỗi
        if(!validate_int($id) || !$id)
            return get_response_array(311, 'ID phải là dạng số.');
        $db     = $this->db;
        $meta   = $db->from($this->db_table)->where([$this->meta_type => $this->type, $this->meta_id => $id])->fetch_first();

        // Nếu id không tồn tại thì báo lỗi
        if(!$meta)
            return get_response_array(302, 'Dữ liệu không tồn tại.');

        // Nếu không nhập tên thì báo lỗi
        if(!validate_isset($_REQUEST[$this->meta_name]))
            return get_response_array(309, 'Bạn cần nhập tên.');

        // Nếu tên vừa nhập khác tên cũ và trùng thì báo lỗi
        if($_REQUEST[$this->meta_name] != $meta[$this->meta_name] && $this->check_name($_REQUEST[$this->meta_name]))
            return get_response_array(310, "Tên ({$_REQUEST[$this->meta_name]}) đã tồn tại, vui lòng chọn tên khác.");

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

        $data_update = [
            'meta_name'     => $db->escape($_REQUEST[$this->meta_name]),
            'meta_des'      => $db->escape($_REQUEST[$this->meta_des]),
            'meta_info'     => $db->escape($meta_info)
        ];
        $data_update = $db->where([$this->meta_type => $this->type, $this->meta_id => $id])->update($this->db_table, $data_update);
        if(!$data_update)
            return get_response_array(208, "Cập nhật dữ liệu không thành công.");
        return get_response_array(200, "Cập nhật dữ liệu thành công.");
    }

    public function add(){
        global $me;
        $db = $this->db;
        if(!validate_isset($_REQUEST[$this->meta_name]))
            return get_response_array(309, 'Bạn cần nhập tên.');

        if($this->check_name($_REQUEST[$this->meta_name]))
            return get_response_array(310, "Tên ({$_REQUEST[$this->meta_name]}) đã tồn tại, vui lòng chọn tên khác.");

        // Xử lý các trường không bắt buộc
        if($_REQUEST[$this->meta_url]){
            if($this->check_url($_REQUEST[$this->meta_url]))
                return get_response_array(310, "URL ({$_REQUEST[$this->meta_url]}) đã tồn tại, vui lòng chọn URL khác.");
        }
        if($_REQUEST[$this->meta_parent]){
            if(!$this->check_id($_REQUEST[$this->meta_parent]))
                return get_response_array(310, "Chuyên mục cha không tồn tại, vui lòng chọn kiểm tra lại.");
        }else{
            // Nếu meta_type là các trường sau thì tự động thêm url khi người dùng không nhập
            if(in_array($this->type, ['blog_category'])){
                $_REQUEST[$this->meta_url] = sanitize_title($_REQUEST[$this->meta_name]);
            }
        }

        // Nếu type là phân quyền thì xử lý chuỗi phân quyền
        if(in_array($this->type, ['role'])){
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
        }

        $data_add   = [
            'meta_type'     => $db->escape($this->type),
            'meta_name'     => $db->escape($_REQUEST[$this->meta_name]),
            'meta_des'      => $db->escape($_REQUEST[$this->meta_des]),
            'meta_url'      => $db->escape($_REQUEST[$this->meta_url]),
            'meta_info'     => $meta_info ? $db->escape($meta_info) : '',
            'meta_images'   => '',
            'meta_parent'   => $db->escape($_REQUEST[$this->meta_parent]),
            'meta_user'     => $me['user_id'],
            'meta_time'     => get_date_time()
        ];

        $data_add = $db->insert($this->db_table, $data_add);
        if(!$data_add)
            return get_response_array(208, "Thêm dữ liệu không thành công.");
        return get_response_array(200, "Thêm dữ liệu thành công.");
    }
}