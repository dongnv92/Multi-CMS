<?php
switch ($path[2]){
    default:
        function convertNumbertoAnser($number){
            $text = '';
            switch ($number){
                case '1':
                    $text = 'A';
                    break;
                case '2':
                    $text = 'B';
                    break;
                case '3':
                    $text = 'C';
                    break;
                case '4':
                    $text = 'D';
                    break;
            }
            return $text;
        }
        $header['title']    = 'Xem kết quả thi';
        $header['toolbar']  = admin_breadcrumbs('Kết quả thi', [URL_ADMIN . '/user' => 'Thành viên'],'Cập nhật', '<a href="'. URL_ADMIN .'/'. $path[1] .'" class="btn btn-success font-weight-bold btn-square btn-sm mr-2">DANH SÁCH</a> <a href="'. URL_ADMIN .'/'. $path[1] .'/add" class="btn btn-success font-weight-bold btn-square btn-sm">THÊM MỚI</a>');
        require_once 'admin-header.php';
        ?>
        <div class="row">
            <div class="col-lg-12">
                <form action="" method="post">
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Nhập dãy câu hỏi <?=count($path)?></h3>
                            </div>
                            <div class="card-toolbar">
                                <button type="submit" name="submit" value="submit" class="btn btn-dark btn-square">Xem đáp áp</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <textarea class="form-control" name="cauhoi" placeholder="Nhập danh sách câu hỏi"><?=($_REQUEST['cauhoi'] ? $_REQUEST['cauhoi'] : '')?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php if($_REQUEST['submit'] && $_REQUEST['cauhoi']){?>
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Đáp Án</h3>
                        </div>
                    </div>
                    <div class="card-body">
                    <?php
                    $datas = $_REQUEST['cauhoi'];
                    $datas = json_decode($datas, true);
                    $i = 0;
                    foreach ($datas AS $data){
                        $i++;
                        echo "Câu $i: ";
                        $j = 0;
                        foreach ($data['ListAnswer'] AS $answer){
                            $j++;
                            if($answer['CorrectAnswerName'] == 'Đúng'){
                                echo convertNumbertoAnser($j).'<hr />';
                                break;
                            }
                        }
                    }
                    ?>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
        <?php
        require_once 'admin-footer.php';
        break;
}
?>
