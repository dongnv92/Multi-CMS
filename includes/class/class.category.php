<?php
class Category{
    private $category_system = ['blog'];
    private $path;

    public function __construct($path){
        $this->path = $path;
    }

    public function getConfig(){
        $config = false;
        $path   = $this->path;
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
            if($check_lugin && is_array($check_lugin['category'])){
                $config = $check_lugin['category'];
            }
        }
        return $config;
    }
}