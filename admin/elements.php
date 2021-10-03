<?php
$header['title']        = 'Các phần tử trong trang quản trị';
$header['css']          = [URL_ADMIN_ASSETS."plugins/custom/prismjs/prismjs.bundle.css?v=7.2.8"];
$header['js']           = [URL_ADMIN_ASSETS."plugins/custom/prismjs/prismjs.bundle.js?v=7.2.8"];
$header['toolbar']      = admin_breadcrumbs('Các phần tử', [URL_ADMIN."/elements/" => 'Phần tử'], 'Chi tiết');
require_once 'admin-header.php';
?>
<div class="row">
    <div class="col-lg-6">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title"><h3 class="card-label">Tiêu đề</h3></div>
                <div class="card-toolbar">Toolbar</div>
            </div>
            <div class="card-body">
                Nội dung<br />
                <!--begin::Code example-->
                <div class="example example-compact mt-2 gutter-b">
                    <div class="example-tools">
                        <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                        <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                    </div>
                    <div class="example-code">
                        <div class="example-highlight">
													<pre>
<code class="language-html">
                &lt;div class="card card-custom gutter-b"&gt;
                 &lt;div class="card-header"&gt;
                  &lt;div class="card-title"&gt;
                   &lt;h3 class="card-label"&gt;
                    Basic Card
                    &lt;small&gt;sub title&lt;/small&gt;
                   &lt;/h3&gt;
                  &lt;/div&gt;
                 &lt;/div&gt;
                 &lt;div class="card-body"&gt;
                  ...
                 &lt;/div&gt;
                &lt;/div&gt;
                </code>
</pre>
                        </div>
                    </div>
                </div>
                <!--end::Code example-->
                <!--end::Example-->
            </div>
        </div>
    </div>
</div>
<!-- -------------------------------------------------------------------------------- -->
<?php
require_once 'admin-footer.php';