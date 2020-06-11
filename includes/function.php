<?php
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

function cms_get_path(){

    $url_path   = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    return $url_path;
}