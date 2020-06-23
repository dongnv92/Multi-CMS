<?php
class meta{
    private $db;
    private $db_table;
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
        $this->meta_type    = $meta_type;
        $this->meta_name    = 'meta_name';
        $this->meta_des     = 'meta_des';
        $this->meta_url     = 'meta_url';
        $this->meta_info    = 'meta_info';
        $this->meta_images  = 'meta_images';
        $this->meta_parent  = 'meta_parent';
        $this->meta_url     = 'meta_user';
        $this->meta_user    = 'meta_user';
        $this->meta_time    = 'meta_time';
    }

}