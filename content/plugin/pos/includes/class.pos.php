<?php
class Pos{
    private $db;
    public function __construct($database){
        $this->db = $database;
    }

    public function get_list_product_ajax($search){
        $product    = new Product($this->db);
        $_REQUEST['search'] = $search;
        $_REQUEST['field']  = 'product_id, product_name, product_image';
        $data       = $product->get_all();
        return $data['data'];
    }
}