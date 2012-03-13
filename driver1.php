<?php


require_once("hacoo.php");
echo "<pre>";
$me = new HAC("UZ8jld5Vh6I=");
print_r(json_encode($me->courses));

echo memory_get_peak_usage();
