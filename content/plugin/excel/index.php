<?php
switch ($path[2]){
    case 'view':
        require_once ABSPATH . 'content/plugin/excel/includes/PHPExcel.php';
        $excel  = new ExcelByMe();
        $bks    = $excel->getListBks($path[3]);
        //$atd    = $excel->getListAtd($path[3], $_REQUEST['excel_bks']);
        //$date_move    = $excel->getListDateMove($path[3], $_REQUEST['excel_bks']);
        $product_name = $excel->getSumProductName($path[3], $_REQUEST['excel_bks'], '', '');
        $cal_count  = 0;
        $cal_weight = 0;
        foreach ($product_name AS $caculator){
            $cal_count  += $caculator['sum_product'];
            $cal_weight += $caculator['sum_weight'];
        }

        $header['js']       = [
            URL_JS . "{$path[1]}/{$path[2]}",
            'https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js'
        ];
        $header['title'] = 'Thêm dữ liệu';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Công Cụ Excel', [URL_ADMIN . "/{$path[1]}/" => 'excel'],'Danh sách');
        ?>
        <div class="nk-block">
            <div class="card card-stretch">
                <div class="card-inner-group">
                    <div class="card-inner position-relative card-tools-toggle">
                        <div class="card-title-group">
                            <div class="card-tools">
                                <?=formOpen('', ['method' => 'GET'])?>
                                <div class="form-inline flex-nowrap gx-3">
                                    <div class="form-wrap w-150px">
                                        Chọn Xe
                                        <select class="form-select form-select-sm" data-search="on" name="excel_bks" data-placeholder="Chọn một xe">
                                            <?php
                                            foreach ($bks AS $_bks){
                                                echo '<option value="'. $_bks .'" '. ($_REQUEST['excel_bks'] == $_bks ? 'selected' : '') .'>'. $_bks .'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="btn-wrap">
                                        <span class="d-none d-md-block">
                                            <br />
                                            <button class="btn btn-primary">LỌC DỮ LIỆU</button>
                                        </span>
                                    </div>
                                </div>
                                <?=formClose()?>
                            </div>
                            <div>
                                <button id="btnExport" class="btn btn-danger">DOWNLOAD EXCEL</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($_REQUEST['excel_bks']){?>
            <div class="card card-bordered">
                <div class="card-inner border-bottom">
                    <div class="text-center">
                    </div>
                    <!-- Content -->
                    <table class="table table-hover mb-0" id="data">
                        <thead>
                        <tr>
                            <th class="text-center align-middle" colspan="3">
                                <h4>FILE TỔNG HÀNG HÓA XE <span class="text-danger"><?=$_REQUEST['excel_bks']?></span>. ĐI PHÁT HÀNG NGÀY <span class="text-danger"><?=$_REQUEST['excel_atd']?></span></h4>
                                (Tổng <span class="text-danger font-weight-bold"><?=$cal_count?></span> kiện hàng, <span class="text-danger font-weight-bold"><?=$cal_weight?></span> kg)<br /><br />
                            </th>
                        </tr>
                        <tr>
                            <th style="width: 10%" class="text-center align-middle">STT</th>
                            <th style="width: 60%" class="text-left align-middle">Nội Dung</th>
                            <th style="width: 30%" class="text-left align-middle">Số Lượng</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 0;
                        foreach ($product_name AS $_product_name){
                            $i++;
                            ?>
                            <tr>
                                <td class="text-center align-middle"><?=$i?></td>
                                <td class="text-left align-middle font-weight-bold"><?=$_product_name['excel_product_name']?></td>
                                <td class="text-left align-middle"><?=$_product_name['sum_product']?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <!-- End Content -->
                </div>
            </div>
            <?php }else{?>
                <div class="card card-bordered">
                    <div class="card-inner border-bottom">
                        <div class="text-center text-danger font-weight-bold">
                            Chọn 1 biển số xe, Ngày ATD và Ngày Vận Chuyển để xem thống kê.
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
    default:
        require_once ABSPATH . 'content/plugin/excel/includes/PHPExcel.php';
        if($_REQUEST['submit']){
            require_once ABSPATH . 'includes/class/class.uploader.php';
            if($_FILES['file_excel']){
                $path_upload        = 'content/plugin/excel/upload/';
                $uploader           = new Uploader();
                $data_upload        = $uploader->upload($_FILES['file_excel'], array(
                    'limit'         => 1, //Maximum Limit of files. {null, Number}
                    'maxSize'       => 2, //Maximum Size of files {null, Number(in MB's)}
                    'extensions'    => ['XLSX', 'xlsx'], //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
                    'required'      => true, //Minimum one file is required for upload {Boolean}
                    'uploadDir'     => ABSPATH . $path_upload, //Upload directory {String}
                    'title'         => array('auto', 15), //New file name {null, String, Array} *please read documentation in README.md
                    'removeFiles'   => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
                    'replace'       => false, //Replace the file if it already exists {Boolean}
                    'onRemove'      => 'onFilesRemoveCallback'//A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
                ));
                if($data_upload['isComplete']){
                    $data_images    =  $path_upload . $data_upload['data']['metas'][0]['name'];
                    $success = '<div class="alert alert-success">Upload File thành công. '. $data_images .'</div>';
                }
            }
        }
        $header['js']       = [
            URL_ADMIN_ASSETS . 'plugins/bootstrap-notify/bootstrap-notify.js',
            URL_JS . "{$path[1]}/{$path[2]}"
        ];
        $header['title'] = 'Thêm dữ liệu';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        echo admin_breadcrumbs('Excel', 'Test','Danh sách', [URL_ADMIN . "/{$path[1]}/" => 'excel']);
        echo formOpen('', ['method' => 'POST', 'enctype' => true, 'id' => 'form_upload']);
        ?>
        <div class="card card-bordered">
            <div class="card-inner border-bottom">
                <!-- Content -->
                <div class="card-inner">
                    <?=($success ? $success : '')?>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="file_excel">
                                        <label class="custom-file-label" for="customFile">Chọn File</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 text-left">
                            <div class="col-lg-12 text-right">
                                <?=formButton('UPLOAD FILE EXCEL', [
                                    'class' => 'btn btn-primary',
                                    'type'  => 'submit',
                                    'name'  => 'submit',
                                    'value' => 'submit'
                                ])?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if($success){
                    $excel  = new ExcelByMe();
                    $data   = $excel->readExcel(ABSPATH.$data_images);

                    foreach ($data AS $_data){
                        $_REQUEST['excel_filename']     = $data_upload['data']['metas'][0]['name'];
                        $_REQUEST['excel_bill']         = $_data[1];
                        $_REQUEST['excel_bks']          = $_data[5];
                        $_REQUEST['excel_atd']          = '';
                        $_REQUEST['excel_date_move']    = '';
                        $_REQUEST['excel_shopname']     = $_data[12];
                        $_REQUEST['excel_address']      = $_data[13];
                        $_REQUEST['excel_district']     = $_data[16];
                        $_REQUEST['excel_product_name'] = $_data[18];
                        $_REQUEST['excel_amount']       = $_data[20];
                        $_REQUEST['excel_weight']       = $_data[21];
                        $_REQUEST['excel_price']        = $_data[8];
                        $excel->add_row();
                    }
                    ?>
                    <?php }?>
                </div>
                <!-- End Content -->
            </div>
        </div>

        <div class="card card-bordered">
            <div class="card-inner border-bottom">
                <!-- Title -->
                <div class="card-title-group">
                    <div class="card-title"><h6 class="title">Danh sách File đã Upload</h6></div>
                </div>
                <!-- Title -->
                <!-- Content -->
                <div class="card-inner">
                <?php
                    $excel = new ExcelByMe();
                    $list_file_upload = $excel->getListFileUpload();
                    foreach ($list_file_upload AS $_list_file_upload){
                        echo '- <a href="'. URL_ADMIN .'/excel/view/'. $_list_file_upload .'">'. $_list_file_upload .'</a><br />';
                    }
                ?>
                </div>
            </div>
        </div>
        <?php
        echo formClose();
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}