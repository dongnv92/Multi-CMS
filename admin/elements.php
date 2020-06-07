<?php
require_once '../init.php';
$header['title']        = 'Các phần tử trong trang quản trị';
$header['breadcrumbs']  = admin_breadcrumbs('Phần tử HTML', 'Các phần tử trong trang quản trị', 'Phần tử HTML',[URL_ADMIN."/elements.php" => 'Phần tử HTML']);
$header['css']          = [URL_ADMIN."/assets/plugins/prism/prism.css"];
$header['js']           = [URL_ADMIN."/assets/plugins/prism/prism.js"];
require_once 'admin-header.php';
?>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>Mã html Card <small>Mã html Card khi thêm mới</small></h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more-vert"></i> </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="#">Action Link</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                        <?php
                        echo sanitize_string_code_sample('<div class="card">
    <div class="header">
        <h2>Tiêu đề <small>Mô tả tiêu đề</small></h2>
        <ul class="header-dropdown m-r--5">
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more-vert"></i> </a>
                <ul class="dropdown-menu pull-right">
                    <li><a href="#">Action Link</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="body">
        Nội dung Card        
    </div>
</div>');
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- #END# Basic Examples -->
        <div class="col-lg-6">
            <div class="card">
                <div class="header">
                    <h2>Thêm bảng html</h2>
                </div>
                <div class="body">
                    Nội dung Card
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>Tạo và đóng Form trong Backend <small>Mã tạo nhanh Form trong admin</small></h2>
            </div>
            <div class="body">
                <p>Mở <code>Form</code> mới bằng 1 trong các cách sau. <small><code>$attribute</code> có thể là method, class, enctype, ...</small></p>
                <p><?=sanitize_string_code_sample('<?php echo formOpen($action, $attribute)?>', 'php')?>
                <p>Hoặc</p>
                <?=sanitize_string_code_sample('<?=formOpen($action, $attribute)?>', 'php')?>
                <p>Ví dụ:</p>
                <?=sanitize_string_code_sample('<?=formOpen(\'\', ["class" => "form-control", "enctype" => "true", "method" => "POST"])?>', 'php')?>
                <p>Đóng <code>Form</code> bằng cách sau.</p>
                <p><?=sanitize_string_code_sample('<?formClose()?>', 'php')?></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>Thẻ Input <small>Các thẻ Input</small></h2>
            </div>
            <div class="body">
                <?=formInputText('hello')?>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'admin-footer.php';