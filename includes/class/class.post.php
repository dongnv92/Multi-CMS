<?php
class Post{
    private $type, $db;
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

    public function add(){

    }
}