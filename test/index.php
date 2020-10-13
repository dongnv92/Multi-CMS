<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>CITYPOST</title>
</head>
<body>
<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="http://citypost.com.vn/images/logo/logocitypost.png" alt="" style="max-height: 72px">
        <h2>CÔNG CỤ LỌC SỐ ĐIỆN THOẠI</h2>
        <p class="lead">Bước 1: Copy URL Group Facebook cần lấy danh sách số điện thoại.</p>
        <p class="lead">Bước 2: Truy cập <a href="https://lookup-id.com/" target="_blank">Vào đây</a> dán URL vừa copy bấm <strong>Lookup</strong> để lấy mã ID Group.</p>
        <p class="lead">Bước 3: COPY ID Group và dán vào ô dưới đây và bấm <strong>SEARCH</strong>, đợi  30s - 1p hệ thống sẽ lọc và hiển thị các comment có điện thoại trong các bài viết.</p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form class="needs-validation" novalidate>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="id" id="id" autofocus placeholder="Nhập ID Group. VD: 1735757083333185" aria-label="Nhập ID Group" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" id="search" type="button">SEARCH</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="result">

        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="js.js"></script>
</body>
</html>