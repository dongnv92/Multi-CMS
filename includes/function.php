<?php
function get_status_header_desc($code){
    $desc = array(
        100 => 'Continue', // Tiếp tục
        101 => 'Switching Protocols', // Đang đổi Protocols
        102 => 'Processing', // Đang xử lý
        103 => 'Early Hints', // Gợi ý

        200 => 'OK', // Done
        201 => 'Created', // Đã được tạo
        202 => 'Accepted', // Được chấp nhận
        203 => 'Non-Authoritative Information', // Thông tin không xác nhận
        204 => 'No Content', // Không có nội dung
        205 => 'Reset Content', // Đặt lại nội dung
        206 => 'Partial Content', // Một phần nội dung
        207 => 'Multi-Status', // Nhiều trạng thái
        208 => 'Action False', // Hành động không được thực hiện
        226 => 'IM Used',

        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found', // Lỗi
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        309 => 'Miss field', // Thiếu trường
        310 => 'Already Exist', // Dữ liệu đã tồn tại
        311 => 'Wrong Format', // Sai định dạng

        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',

        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    );
    if(!$desc[$code])
        return '';
    return $desc[$code];
}

function role_structure($type = '', $des = ''){
    $list_plugin = get_list_plugin();
    switch ($type){
        case 'des':
            $text = '';
            switch ($des[0]){
                case 'user':
                    switch ($des[1]){
                        case 'manager': $text = 'Quản lý thành viên';   break;
                        case 'add':     $text = 'Thêm thành viên';      break;
                        case 'update':  $text = 'Cập nhật thành viên';  break;
                        case 'delete':  $text = 'Xóa thành viên';       break;
                        case 'role':    $text = 'Quản lý phân quyền';   break;
                        default:        $text = 'Quản lý thành viên';   break;
                    }
                    break;
                case 'blog':
                    switch ($des[1]){
                        case 'manager':     $text = 'Xem bài viết';                 break;
                        case 'add':         $text = 'Thêm bài viết';                break;
                        case 'update':      $text = 'Sửa bài viết';                 break;
                        case 'delete':      $text = 'Xoá bài viết';                 break;
                        case 'category':    $text = 'Quản lý chuyên mục bài viết';  break;
                        default:            $text = 'Bài viết';                     break;
                    }
                    break;
                case 'plugin':
                    switch ($des[1]){
                        case 'manager':     $text = 'Quản lý Plugin';   break;
                        default:            $text = 'Plugin';           break;
                    }
                    break;
                default:
                    if(in_array($des[0], $list_plugin)){
                        $config = file_get_contents(ABSPATH . PATH_PLUGIN . "{$des[0]}/config.json");
                        $config = json_decode($config, true);
                        if($config['status'] == 'active'){
                            $text   = $config['role_text'][$des[1]];
                        }
                    }
                    break;
            }
            return $text;
            break;
        default:
            $structure = [
                'user' => [
                    'manager'   => false,
                    'add'       => false,
                    'update'    => false,
                    'role'      => false,
                    'delete'    => false
                ],
                'blog' => [
                    'manager'   => false,
                    'add'       => false,
                    'update'    => false,
                    'delete'    => false,
                    'category'  => false
                ],
                'plugin' => [
                    'manager'   => false
                ]
            ];

            // Lấy cấu trúc phân quyền từ các Plugin
            foreach ($list_plugin AS $plugin){
                $config = file_get_contents(ABSPATH . PATH_PLUGIN . "{$plugin}/config.json");
                $config = json_decode($config, true);
                if($config['status'] == 'active'){
                    $structure = array_merge($structure, $config['role_structure']);
                }
            }

            return $structure;
            break;
    }
}

// Function hiển thị JSON
function encode_json(array $array){
    return json_encode($array, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
}

// Function hiển thị output API
function get_response_json($response = 200, $message = ''){
    return encode_json(['response' => $response, 'message' => $message ? $message : get_status_header_desc($response)]);
}

function get_response_array($response = 200, $message = ''){
    return ['response' => $response, 'message' => $message ? $message : get_status_header_desc($response)];
}

/*
 * Thêm 1 chuỗi mã hóa các ký tự đặc biệt
 * */
function add_magic_quotes( $array ) {
    foreach ( (array) $array as $k => $v ) {
        if ( is_array( $v ) ) {
            $array[ $k ] = add_magic_quotes( $v );
        } else {
            $array[ $k ] = addslashes( $v );
        }
    }
    return $array;
}

function cms_magic_quotes() {
    // Escape with wpdb.
    //$_GET       = add_magic_quotes( $_GET );
    //$_POST      = add_magic_quotes( $_POST );
    $_COOKIE    = add_magic_quotes( $_COOKIE );
    $_SERVER    = add_magic_quotes( $_SERVER );
    $_SESSION   = add_magic_quotes( $_SESSION );
    // Force REQUEST to be GET + POST.
    $_REQUEST = array_merge( $_GET, $_POST );
}

function get_query_search($text, $fields){
    foreach ($fields as $data) {
        $colums[] = "`". add_magic_quotes($data) ."` LIKE '%". add_magic_quotes($text) ."%'";
    }
    $colums = implode(' OR ', $colums);
    $colums = "($colums)";
    return $colums;
}

/*
 * Check xem request gửi lên có phải request kiểu JSON không
 * */

function cms_is_json_request() {
    if ( isset( $_SERVER['HTTP_ACCEPT'] ) && false !== strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) ) {
        return true;
    }
    if ( isset( $_SERVER['CONTENT_TYPE'] ) && 'application/json' === $_SERVER['CONTENT_TYPE'] ) {
        return true;
    }
    return false;
}

/**
 * Build URL query based on an associative and, or indexed array.
 *
 * This is a convenient function for easily building url queries. It sets the
 * separator to '&' and uses _http_build_query() function.
 *
 * @since 2.3.0
 *
 * @see _http_build_query() Used to build the query
 * @link https://secure.php.net/manual/en/function.http-build-query.php for more on what
 *       http_build_query() does.
 *
 * @param array $data URL-encode key/value pairs.
 * @return string URL-encoded string.
 */
function build_query($data, $plus = '') {
    if(is_array($plus)){
        foreach ($plus AS $key => $value){
            if(isset($value) && !empty($value)){
                $data[$key] = $value;
            }else{
                unset($data[$key]);
            }
        }
    }
    return '?'._http_build_query( $data, null, '&', '', false );
}

/**
 * From php.net (modified by Mark Jaquith to behave like the native PHP5 function).
 *
 * @since 3.2.0
 * @access private
 *
 * @see https://secure.php.net/manual/en/function.http-build-query.php
 *
 * @param array|object  $data       An array or object of data. Converted to array.
 * @param string        $prefix     Optional. Numeric index. If set, start parameter numbering with it.
 *                                  Default null.
 * @param string        $sep        Optional. Argument separator; defaults to 'arg_separator.output'.
 *                                  Default null.
 * @param string        $key        Optional. Used to prefix key name. Default empty.
 * @param bool          $urlencode  Optional. Whether to use urlencode() in the result. Default true.
 *
 * @return string The query string.
 */
function _http_build_query( $data, $prefix = null, $sep = null, $key = '', $urlencode = true ) {
    $ret = array();

    foreach ( (array) $data as $k => $v ) {
        if ( $urlencode ) {
            $k = urlencode( $k );
        }
        if ( is_int( $k ) && $prefix != null ) {
            $k = $prefix . $k;
        }
        if ( ! empty( $key ) ) {
            $k = $key . '%5B' . $k . '%5D';
        }
        if ( $v === null ) {
            continue;
        } elseif ( $v === false ) {
            $v = '0';
        }

        if ( is_array( $v ) || is_object( $v ) ) {
            array_push( $ret, _http_build_query( $v, '', $sep, $k, $urlencode ) );
        } elseif ( $urlencode ) {
            array_push( $ret, $k . '=' . urlencode( $v ) );
        } else {
            array_push( $ret, $k . '=' . $v );
        }
    }

    if ( null === $sep ) {
        $sep = ini_get( 'arg_separator.output' );
    }

    return implode( $sep, $ret );
}

function get_config($key){
    global $database;
    $setting = $database->select('setting_value')->from('dong_setting')->where('setting_key', $key)->fetch_first();
    if(!$setting)
        return false;
    switch ($key){
        case 'logo':
            return URL_HOME . '/' . $setting['setting_value'];
            break;
        default:
            return $setting['setting_value'];
            break;
    }
}

// Chuyển hướng đến 1 trang khác
function redirect($url){
    header('location:'.$url);
}

function get_path_uri($type = 'domain'){
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $path = explode('/', $path);

    switch ($type){
        case 'domain':
            array_shift($path);
            break;
        case 'local':
            $root = ROOTPATH;
            foreach ($path AS $key => $value){
                if($value == $root){
                    unset($path[$key]);
                    break;
                }else{
                    unset($path[$key]);
                }
            }
            $path = implode('/', $path);
            $path = explode('/', $path);
            break;
    }

    return $path;
}

function get_current_url(){
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

// Tạo chuỗi URL từ các tham số
function buildQuery($params, $plus = ['']){
    if(!is_array($params)){
        return '';
    }
    $data = [];
    foreach ($params AS $key => $value){
        if(isset($value) && !empty($value)){
            $data[$key] = $value;
        }
    }
    if(is_array($plus)){
        foreach ($plus AS $key => $value){
            if(isset($value) && !empty($value)){
                $data[$key] = $value;
            }else{
                unset($data[$key]);
            }
        }
    }
    return '?'.http_build_query($data);
}

// Thay thế link phân trang
function replaceUrlPagination($url, $page_number, $option = ''){
    $option['class_li'] = $option['class_li']   ? $option['class_li']   : 'page-item';
    $option['class_a']  = $option['class_a']    ? $option['class_a']    : 'page-link';
    $url = str_replace(['%7Bpage%7D', '{page}'], $page_number, $url);
    $url = "<li class=\"{$option['class_li']}\"><a href=\"{$url}\" class=\"{$option['class_a']}\">{$option['text']}</a></li>";
    return $url;
}

// Phân Trang
function pagination($page_curent, $page_count, $url){
    $link = '';
    for ($i = $page_curent; $i <= ($page_curent + 4) && $i <= $page_count; $i++) {
        if ($page_curent == $i) {
            $link .= replaceUrlPagination("javascript:;", $i, ['class_li' => 'page-item active', 'text' => $i]);
        } else {
            $link .= replaceUrlPagination($url, $i, ['text' => $i]);
        }
    }
    if ($page_curent > 4) {
        $page4 = replaceUrlPagination($url, ($page_curent - 4), ['text' => ($page_curent - 4)]);
    }
    if ($page_curent > 3) {
        $page3 = replaceUrlPagination($url, ($page_curent - 3), ['text' => ($page_curent - 3)]);
    }
    if ($page_curent > 2) {
        $page2 = replaceUrlPagination($url, ($page_curent - 2), ['text' => ($page_curent - 2)]);
    }
    if ($page_curent > 1) {
        $page1 = replaceUrlPagination($url, ($page_curent - 1), ['text' => ($page_curent - 1)]);
        $link1 = replaceUrlPagination($url, ($page_curent - 1), ['text' => "« Trang sau"]);
    }
    if ($page_curent < $page_count) {
        $link2 = replaceUrlPagination($url, ($page_curent + 1), ['text' => "Trang tiếp »"]);
    }
    $linked = $page4 . $page3 . $page2 . $page1;
    if ($page_curent < $page_count - 4) {
        $page_end_pt = replaceUrlPagination($url, $page_count, ['text' => $page_count]);
    }
    if ($page_curent > 5) {
        $page_start_pt = replaceUrlPagination($url, 1, ['text' => '1']);
    }
    if ($page_count > 1 && $page_curent <= $page_count) {
        return '<nav><ul class="pagination justify-content-center">' . $link1 . $page_start_pt . $linked . $link . $page_end_pt . $link2 . '</ul></nav>';
    } else {
        return false;
    }
}

function get_param_defaul(){
    $page       = (validate_int($_REQUEST['page']) && $_REQUEST['page'] > 1 ? $_REQUEST['page'] : 1); // Nếu không truyền tham số page thì mặc định là 1 (Số trang hiện tại)
    $limit      = (validate_int($_REQUEST['limit']) ? $_REQUEST['limit'] : 100); // Nếu không truyền tham số limit thì mặc định là 100 (Số bản ghi trên 1 trang)
    $offset     = (validate_int($_REQUEST['offset'])? $_REQUEST['offset'] : 0); // Nếu không truyền tham số offset thì mặc định là 0 (Từ bản ghi thứ ...)
    return [
        'page'      => $page,
        'limit'     => $limit,
        'offset'    => $offset
    ];
}

function get_status($type, $data){
    switch ($type){
        case 'blog':
            switch ($data){
                case 'public':
                    return '<span class="text-success">Đang hoạt động</span>';
                    break;
                case 'not_active':
                    return '<span class="text-danger">Đang tạm khoá</span>';
                    break;
            }
            break;
        case 'user':
            switch ($data){
                case 'active':
                    return '<span class="text-success">Đang hoạt động</span>';
                    break;
                case 'not_active':
                    return '<span class="text-success">Chưa kích hoạt</span>';
                    break;
                case 'block':
                    return '<span class="text-danger">Đang tạm khóa</span>';
                    break;
                case 'block_forever':
                    return '<span class="text-danger">Đang bị khóa</span>';
                    break;
            }
            break;
    }
}

function get_list_plugin(){
    $directory = array_diff(scandir( ABSPATH . "/content/plugin" ), array('..', '.'));
    return $directory;
}

// Lấy cấu hình của Plugin, nếu không tồn tại plugin hoặc plugin chưa được kích hoạt thì trả về false
function get_config_plugin($plugin_directory){
    $file_config = ABSPATH . PATH_PLUGIN . $plugin_directory . '/config.json';
    if(!file_exists($file_config))
        return false;

    $config = file_get_contents($file_config);
    $config = json_decode($config, true);
    if($config['status'] != 'active')
        return false;

    return $config;
}

// Gọi CURL để lấy data
function curl($url, $data = '', $method = 'GET'){
    if ($method == 'GET') {
        $ch = curl_init($url.($data ? '?'.http_build_query($data) : ''));
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept-Language: *']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result === FALSE) {
            return false;
        } else {
            return $result;
        }
    }else if($method == 'POST'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_URL             => $url,
            CURLOPT_USERAGENT       => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)",
            CURLOPT_POST            => 1,
            CURLOPT_SSL_VERIFYPEER  => false, //Bỏ kiểm SSL
            CURLOPT_POSTFIELDS      => http_build_query($data)
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        if ($result === FALSE) {
            return false;
        } else {
            return $result;
        }
    } else {
        $curl = curl_init();
        $data = json_encode($data);
        $options = array(
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_URL             => $url,
            CURLOPT_POST            => true,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_USERAGENT       => "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)",
            CURLOPT_POSTFIELDS      => $data,
            CURLOPT_HTTPHEADER      => ['Content-Type: application/json', 'Content-Length: ' . strlen($data)]
        );
        curl_setopt_array($curl, $options);
        $result = curl_exec($curl);
        if ($result === FALSE) {
            return false;
        } else {
            return $result;
        }
    }
}

// Function hiển thị tiền thêm dấu chấm
function convert_number_to_money($number){
    return number_format($number, 0, '', '.').' ₫';
}