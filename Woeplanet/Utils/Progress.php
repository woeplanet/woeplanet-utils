<?php

namespace Woeplanet\Utils;

class Progress {
    static protected $spinner = [
        '/',
        '-',
        '\\',
        '|',
        '/',
        '-',
        '\\',
        '|'
    ];

    public static function spinner($count, $title, $init=false) {
        static $i = 0;
        if ($init) {
            $i = 0;
        }
        echo sprintf("\r(%s) %s: %s", self::$spinner[ (($i++ > 7) ? ($i = 1) : ($i % 8)) ], $title, $count); //restore cursor position and print
        flush();
    }

    // Thanks to Brian Moon for this - http://brian.moonspot.net/php-progress-bar
    public static function bar($done, $total, $size=30) {
        if ($done === 0) {
            $done = 1;
        }
        static $start_time;
        if ($done > $total) {
            return; // if we go over our bound, just ignore it
        }
        if (empty ($start_time)) {
            $start_time = time();
        }
        $now = time();
        $perc = (double) ($done / $total);
        $bar = floor($perc * $size);
        $status_bar = "\r[";
        $status_bar .= str_repeat("=", $bar);
        if ($bar < $size) {
            $status_bar .= ">";
            $status_bar .= str_repeat(" ", $size - $bar);
        } else {
            $status_bar .= "=";
        }
        $disp = number_format($perc * 100, 0);
        $status_bar .= "] $disp%  $done/$total";
        if ($done === 0){$done = 1;}//avoid div zero warning
        $rate = ($now - $start_time) / $done;
        $left = $total - $done;
        $eta = round($rate * $left, 2);
        $elapsed = $now - $start_time;

        echo "$status_bar  ";
        flush();
        // when done, send a newline
        if($done == $total) {
            echo "\n";
        }
    }
}

?>
