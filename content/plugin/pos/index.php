<?php
switch ($path[2]){
    default:
        $header['css']      = [
            URL_HOME . '/' . PATH_PLUGIN . $path[1] . "/assets/css/jquery.auto-complete.css"
        ];
        $header['js']       = [
            URL_HOME . '/' . PATH_PLUGIN . $path[1] . "/assets/js/jquery.auto-complete.min.js",
            URL_JS . "{$path[1]}"
        ];
        $header['title']    = 'POS';
        require_once ABSPATH . PATH_ADMIN . "/admin-header.php";
        //echo admin_breadcrumbs('BÁN HÀNG LẺ', 'Bán hàng lẻ','Bán hàng', [URL_ADMIN . "/{$path[1]}/" => 'POS']);
        ?>
        <div class="row">
            <div class="col-lg-9">
                <!-- Ô tìm kiếm sản phẩm -->
                <div class="card action_bar m-t-15">
                    <?=formOpen('', ['method' => 'GET'])?>
                    <div class="row" style="margin-left : 5px; margin-right : 5px">
                        <div class="col-lg-12 col-md-6 hidden-sm-down">
                            <div class="input-group m-t-10">
                                <span class="input-group-addon"><i class="zmdi zmdi-search"></i></span>
                                <div class="form-line">
                                    <input type="text" autofocus name="search_product" value="<?=$_REQUEST['search']?>" class="form-control" placeholder="Nhập mã Barcode hoặc tên sản phẩm ...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?=formClose()?>
                </div>

                <!-- Danh sách sản phẩm trong giỏ hàng -->
                <div class="card">
                    <div class="content table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th style="width: 3%" class="text-left align-middle"></th>
                                <th style="width: 2%" class="text-left align-middle"><i class="material-icons text-danger">delete_forever</i></th>
                                <th style="width: 35%" class="text-left align-middle">Sản phẩm</th>
                                <th style="width: 15%" class="text-left align-middle">Số lượng</th>
                                <th style="width: 15%" class="text-left align-middle">Giá bán</th>
                                <th style="width: 15%" class="text-left align-middle">Giảm giá</th>
                                <th style="width: 15%" class="text-left align-middle">Thành tiền</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="card action_bar m-t-15">
                    <?=formOpen('', ['method' => 'GET'])?>
                    <div class="row" style="margin-left : 5px; margin-right : 5px">
                        <div class="col-lg-12 col-md-6 hidden-sm-down">
                            <div class="input-group m-t-10">
                                <span class="input-group-addon"><i class="zmdi zmdi-search"></i></span>
                                <div class="form-line">
                                    <input type="text" autofocus name="search" value="<?=$_REQUEST['search']?>" class="form-control" placeholder="Nhập tên khách hàng ...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?=formClose()?>
                </div>
            </div>
        </div>
        <?php
        require_once ABSPATH . PATH_ADMIN . "/admin-footer.php";
        break;
}