<?php


require_once("hacoo.php");
echo "<pre>";
$me = new HAC(/* your studentid get variable*/);
print_r($me->courses);

echo memory_get_peak_usage();
