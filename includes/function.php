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
    switch ($type){
        case 'des':
            $text = '';
            switch ($des[0]){
                case 'user':
                    switch ($des[1]){
                        case 'manager': $text = 'Quản lý thành viên';   break;
                        case 'add':     $text = 'Thêm thành viên';      break;
                        case 'update':  $text = 'Cập nhật thành viên';      break;
                        case 'delete':  $text = 'Xóa thành viên';      break;
                        default:        $text = 'Quản lý thành viên';   break;
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
                    'delete'    => false
                ]
            ];
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
    $_GET       = add_magic_quotes( $_GET );
    $_POST      = add_magic_quotes( $_POST );
    $_COOKIE    = add_magic_quotes( $_COOKIE );
    $_SERVER    = add_magic_quotes( $_SERVER );
    $_SESSION   = add_magic_quotes( $_SESSION );
    // Force REQUEST to be GET + POST.
    $_REQUEST = array_merge( $_GET, $_POST );
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
function build_query( $data ) {
    return _http_build_query( $data, null, '&', '', false );
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

function get_path_uri(){
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $root = ROOTPATH;
    $path = explode('/', $path);
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
    return $path;
}