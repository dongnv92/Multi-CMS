<?php
class Category{
    private $category_system = ['blog'];
    private $path, $title;

    public function __construct($path, $title = ''){
        $this->path     = $path;
        $this->title    = $title;
    }

    public function getCategory($category_id){
        global $database;
        if(!validate_int($category_id) || !$category_id)
            return get_response_array(311, 'ID phải là dạng số.');
        $meta   = $database->select()->from("dong_meta")->where(['meta_id' => $category_id])->fetch_first();
        if(!$meta)
            return get_response_array(302, 'Dữ liệu không tồn tại.');
        return $meta;
    }

    public function getOptionSelect($plus = ''){
        global $database;
        $config = $this->getConfig();
        $option = [];
        if(is_array($plus)){
            $option['0'] = $plus[0];
        }
        $data   = $database->select('meta_id, meta_name')->from('dong_meta')->where(['meta_type' => $config['type']])->fetch();
        foreach ($data AS $_data){
            $option[$_data['meta_id']] = $_data['meta_name'];
        }
        return $option;
    }

    public function getConfig(){
        $config = false;
        $path   = $this->path;
        $title  = $this->title;

        if(in_array($path, $this->category_system)){
            switch ($path){
                case 'blog':
                    $config = [
                        'text' => [
                            'title'         => 'Chuyên mục Blog',
                            'title_update'  => 'Cập nhật chuyên mục Blog',
                            'title_card'    => 'Thông tin chuyên mục',
                            'tool_card'     => '<a href="#" class="link">Xem tất cả</a>',
                            'field_name'    => 'Tên chuyên mục',
                            'field_des'     => 'Mô tả',
                            'field_url'     => 'Đường dẫn',
                            'bt_add'        => 'Thêm chuyên mục mới',
                            'bt_update'     => 'Cập nhật chuyên mục'
                        ],
                        'fields' => ['url' => true, 'cat_parent' => true, 'des' => true, 'image' => true],
                        'permission'    => ['blog', 'category'],
                        'type'          => 'blog_category',
                        'breadcrumbs'   => [
                            'title'     => 'Chuyên mục Blog',
                            'url'       => [URL_ADMIN . '/blog' => 'Blog'],
                            'active'    => 'Chuyên mục'
                        ]
                    ];
                    break;
            }
        }else{
            $check_lugin = get_config_plugin($path);
            if($check_lugin && is_array($check_lugin['category'][$title])){
                $config = $check_lugin['category'][$title];
            }
        }
        return $config;
    }
}