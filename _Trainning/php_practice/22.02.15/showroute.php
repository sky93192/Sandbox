<?php

// display arp information
exec("/sbin/route", $route_arr);
array_splice($route_arr, 0, 2); // drop title
foreach($route_arr as $key => $line){
	$line = preg_split("/[\s]+/", $line);
	$route[$key]['ip'] = $line[0];
	$route[$key]['gateway'] = $line[1];
	$route[$key]['genmask'] = $line[2];
	$route[$key]['flags'] = $line[3];
	$route[$key]['metric'] = $line[4];
	$route[$key]['ref'] = $line[5];
	$route[$key]['use'] = $line[6];
	$route[$key]['interface'] = $line[7];
}

include('./xhtml/showroute.html');