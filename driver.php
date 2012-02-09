<?php
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
$time_start = microtime_float();

require_once("hacoo.php");
echo "<pre>";
$me = new HAC(/* your studentid get variable*/);
print_r($me->courses);
$time_end = microtime_float();
$time = $time_end - $time_start;
echo "Did nothing in $time seconds\n";
echo memory_get_peak_usage();
