<?php
/*
 * Template Name: Test template
 */ 

$address = "India+Panchkula";
$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=India";
$myaddress = urlencode($url);
    $cmpltadd	= array();
//here is the google api url
    	 $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$myaddress.",USA&sensor=false";
    	 $ch1 = curl_init();
         curl_setopt($ch1, CURLOPT_URL, $url);
         curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch1, CURLOPT_PROXYPORT, 3128);
         curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 0);
         $response = curl_exec($ch1);
         curl_close($ch1);
         $response_a = json_decode($response);
         echo '<pre>';print_r($response_a); echo '</pre>';
         $account_lat = $response_a->results[0]->geometry->location->lat;
         $account_long = $response_a->results[0]->geometry->location->lng;
   
    if(!empty($account_lat) && !empty($account_long)) {
    $cmpltadd['lat'] = $account_lat;
    $cmpltadd['lng'] = $account_long;  
   } 
