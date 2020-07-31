<?php
class Product{
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    function get_unit($type = '', $data = ''){
        $data = [
            '1' => 'Chiếc',
            '2' => 'Cái',
            '3' => 'Kg',
            '4' => 'Lọ',
            '5' => 'Túi',
            '6' => 'Mét'
        ];
        switch ($type){
            default:
                return $data;
                break;
        }
    }
}