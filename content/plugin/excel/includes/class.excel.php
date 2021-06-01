<?php
class ExcelByMe{
    const table                 = 'dong_excel';
    const excel_filename        = 'excel_filename';
    const excel_bill            = 'excel_bill';
    const excel_bks             = 'excel_bks';
    const excel_atd             = 'excel_atd';
    const excel_date_move       = 'excel_date_move';
    const excel_shopname        = 'excel_shopname';
    const excel_address         = 'excel_address';
    const excel_district        = 'excel_district';
    const excel_product_name    = 'excel_product_name';
    const excel_amount          = 'excel_amount';
    const excel_weight          = 'excel_weight';
    const excel_price           = 'excel_price';

    public function __construct(){
    }

    function getListFileUpload(){
        global $database;
        $data   = $database->query("SELECT DISTINCT ". self::excel_filename ." FROM ". self::table)->fetch();
        $return = [];
        foreach ($data AS $_data){
            $return[] = $_data['excel_filename'];
        }
        $return = array_filter($return);
        return $return;
    }

    function getListBks($filename){
        global $database;
        $data   = $database->query("SELECT DISTINCT ". self::excel_bks." FROM ". self::table ." WHERE ". self::excel_filename ." = '$filename'")->fetch();
        $return = [];
        foreach ($data AS $_data){
            $return[] = $_data[self::excel_bks];
        }
        $return = array_filter($return);
        return $return;
    }

    function getListAtd($filename, $bks = ''){
        global $database;
        $data   = $database->query("SELECT DISTINCT ". self::excel_atd." FROM ". self::table ." WHERE ". self::excel_filename ." = '$filename' ". ($bks ? "AND `". self::excel_bks ."` = '$bks'" : "")." ORDER BY `". self::excel_atd ."` DESC")->fetch();
        $return = [];
        foreach ($data AS $_data){
            $return[] = $_data[self::excel_atd];
        }
        $return = array_filter($return);
        return $return;
    }

    function getListDateMove($filename, $bks = ''){
        global $database;
        $data   = $database->query("SELECT DISTINCT ". self::excel_date_move." FROM ". self::table ." WHERE ". self::excel_filename ." = '$filename' ". ($bks ? "AND `". self::excel_bks ."` = '$bks'" : "")." ORDER BY `". self::excel_date_move ."` DESC")->fetch();
        $return = [];
        foreach ($data AS $_data){
            $return[] = $_data[self::excel_date_move];
        }
        $return = array_filter($return);
        return $return;
    }

    function getSumProductName($filename, $bks, $atd = '', $date_move = ''){
        global $database;
        $where = [
            self::excel_filename    => $database->escape($filename),
            self::excel_bks         => $database->escape($bks)
        ];
        if($atd){
            $where[self::excel_atd] = $database->escape($atd);
        }
        if($date_move){
            $where[self::excel_date_move] = $database->escape($date_move);
        }

        $database->select(self::excel_product_name.', SUM(`'. self::excel_amount .'`) AS `sum_product`, SUM(`'. self::excel_amount .'` * `'. self::excel_weight .'` * 1000) AS `sum_weight`')->from(self::table);
        $database->where($where);
        $database->group_by(self::excel_product_name);
        $database->order_by('sum_product', 'DESC');
        $data = $database->fetch();
        return $data;
    }

    public function add_row(){
        global $database;
        $data = [
            self::excel_filename        => $database->escape($_REQUEST[self::excel_filename]),
            self::excel_bill            => $database->escape($_REQUEST[self::excel_bill]),
            self::excel_bks             => $database->escape($_REQUEST[self::excel_bks]),
            self::excel_atd             => $_REQUEST[self::excel_atd],
            self::excel_date_move       => $_REQUEST[self::excel_date_move],
            self::excel_shopname        => $database->escape($_REQUEST[self::excel_shopname]),
            self::excel_address         => $database->escape($_REQUEST[self::excel_address]),
            self::excel_district        => $database->escape($_REQUEST[self::excel_district]),
            self::excel_product_name    => $database->escape($_REQUEST[self::excel_product_name]),
            self::excel_amount          => $database->escape($_REQUEST[self::excel_amount]),
            self::excel_weight          => $database->escape($_REQUEST[self::excel_weight]),
            self::excel_price           => $database->escape($_REQUEST[self::excel_price])
        ];
        $add = $database->insert(self::table, $data);
        if(!$add){
            return false;
        }
        return true;
    }

    public function readExcel($file){
        require_once 'PHPExcel.php';
        //Tiến hành xác thực file
        $objFile = PHPExcel_IOFactory::identify($file);
        $objData = PHPExcel_IOFactory::createReader($objFile);

        //Chỉ đọc dữ liệu
        $objData->setReadDataOnly(true);

        // Load dữ liệu sang dạng đối tượng
        $objPHPExcel = $objData->load($file);

        //Lấy ra số trang sử dụng phương thức getSheetCount();
        // Lấy Ra tên trang sử dụng getSheetNames();

        //Chọn trang cần truy xuất
        $sheet = $objPHPExcel->setActiveSheetIndex(0);

        //Lấy ra số dòng cuối cùng
        $Totalrow = $sheet->getHighestRow();
        //Lấy ra tên cột cuối cùng
        $LastColumn = $sheet->getHighestColumn();

        //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
        $TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

        //Tạo mảng chứa dữ liệu
        $data = [];

        //Tiến hành lặp qua từng ô dữ liệu
        //----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
        for ($i = 2; $i <= $Totalrow; $i++) {
            //----Lặp cột
            for ($j = 0; $j < $TotalCol; $j++) {
                // Tiến hành lấy giá trị của từng ô đổ vào mảng
                /*if(in_array($j, [17, 19])){
                    //$data[$i - 2][$j] = date('d-m-Y',PHPExcel_Shared_Date::ExcelToPHP($sheet->getCellByColumnAndRow($i,$j)->getValue()));
                    $UNIX_DATE = (($sheet->getCellByColumnAndRow($j, $i)->getValue()) - 25569) * 86400;
                    $UNIX_DATE = gmdate("d-m-Y", $UNIX_DATE);
                    $data[$i - 2][$j] = $UNIX_DATE;
                }else{
                    $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
                }*/
                $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
            }
        }
        return $data;
    }
}