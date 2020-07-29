<?php
define( 'MINUTE_IN_SECONDS' , 60 );
define( 'HOUR_IN_SECONDS'   , 60 * MINUTE_IN_SECONDS );
define( 'DAY_IN_SECONDS'    , 24 * HOUR_IN_SECONDS );
define( 'WEEK_IN_SECONDS'   , 7 * DAY_IN_SECONDS );
define( 'MONTH_IN_SECONDS'  , 30 * DAY_IN_SECONDS );
define( 'YEAR_IN_SECONDS'   , 365 * DAY_IN_SECONDS );


/**
 * Chuyển đổi tiêu đề sang slug url
 */
function sanitize_title( $str) {
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '-', $str);
    return $str;
}

/**
 * Hiển thị 1 chuỗi dạng html
 */
function sanitize_string_code_sample( $str , $language = 'html') {
    $text = '<figure class="highlight"><pre><code class="language-'. $language .'" data-lang="'. $language .'">';
    $text .= htmlentities($str);
    $text .= '</code></pre></figure>';
    return $text;
}


/**
 * Determines the difference between two timestamps.
 *
 * The difference is returned in a human readable format such as "1 hour",
 * "5 mins", "2 days".
 *
 * @since 1.5.0
 * @since 5.3.0 Added support for showing a difference in seconds.
 *
 * @param int $from Unix timestamp from which the difference begins.
 * @param int $to   Optional. Unix timestamp to end the time difference. Default becomes time() if not set.
 * @return string Human readable time difference.
 */
function human_time_diff( $from, $to = 0, $text = 'trước') {
    if ( empty( $to ) ) {
        $to = time();
    }

    $diff = (int) abs( $to - $from );

    if ( $diff < MINUTE_IN_SECONDS ) {
        $secs = $diff;
        if ( $secs <= 1 ) {
            $secs = 1;
        }
        /* translators: Time difference between two dates, in seconds. %s: Number of seconds. */
        $since = "$secs giây $text";
    } elseif ( $diff < HOUR_IN_SECONDS && $diff >= MINUTE_IN_SECONDS ) {
        $mins = round( $diff / MINUTE_IN_SECONDS );
        if ( $mins <= 1 ) {
            $mins = 1;
        }
        /* translators: Time difference between two dates, in minutes (min=minute). %s: Number of minutes. */
        $since = "$mins phút $text";
    } elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
        $hours = round( $diff / HOUR_IN_SECONDS );
        if ( $hours <= 1 ) {
            $hours = 1;
        }
        /* translators: Time difference between two dates, in hours. %s: Number of hours. */
        $since = "$hours giờ $text";
    } elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
        $days = round( $diff / DAY_IN_SECONDS );
        if ( $days <= 1 ) {
            $days = 1;
        }
        /* translators: Time difference between two dates, in days. %s: Number of days. */
        $since = "$days ngày $text";
    } elseif ( $diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
        $weeks = round( $diff / WEEK_IN_SECONDS );
        if ( $weeks <= 1 ) {
            $weeks = 1;
        }
        /* translators: Time difference between two dates, in weeks. %s: Number of weeks. */
        $since = "$weeks tuần $text";
    } elseif ( $diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS ) {
        $months = round( $diff / MONTH_IN_SECONDS );
        if ( $months <= 1 ) {
            $months = 1;
        }
        /* translators: Time difference between two dates, in months. %s: Number of months. */
        $since = "$months tháng $text";
    } elseif ( $diff >= YEAR_IN_SECONDS ) {
        $years = round( $diff / YEAR_IN_SECONDS );
        if ( $years <= 1 ) {
            $years = 1;
        }
        /* translators: Time difference between two dates, in years. %s: Number of years. */
        $since = "$years năm $text";
    }

    /**
     * Filters the human readable difference between two timestamps.
     *
     * @since 4.0.0
     *
     * @param string $since The difference in human readable text.
     * @param int    $diff  The difference in seconds.
     * @param int    $from  Unix timestamp from which the difference begins.
     * @param int    $to    Unix timestamp to end the time difference.
     */
    return $since;
}

function get_date_time($type = ''){
    switch ($type){
        case 'timestamp':
            $text = time();
            break;
        default:
            $text = date('Y-m-d H:i:s', time());
            break;
    }
    return $text;
}

// Cắt chuỗi ký tự hoặc văn bản
function text_truncate($text, $limit, $type = 'words', $ellipsis = ' ...'){
    switch ($type) {
        case 'words':
            $words = preg_split("/[\n\r\t ]+/", $text, $limit + 1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_OFFSET_CAPTURE);
            if (count($words) > $limit) {
                end($words); //ignore last element since it contains the rest of the string
                $last_word = prev($words);

                $text = substr($text, 0, $last_word[1] + strlen($last_word[0])) . $ellipsis;
            }
            return $text;
            break;
        case 'text':
            if (strlen($text) > $limit) {
                $endpos = strpos(str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $text), ' ', $limit);
                if ($endpos !== FALSE)
                    $text = trim(substr($text, 0, $endpos)) . $ellipsis;
            }
            return $text;
            break;
    }
}

function view_date_time($date_time){
    return date('d/m/Y', strtotime($date_time));
}