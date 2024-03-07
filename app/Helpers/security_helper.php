<?php

function encrypt($string)
{

    $output = false;
    /*
     * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
     */
    $security = parse_ini_file("security.ini");
    $secret_key = $security["encryption_key"];
    $secret_iv = $security["iv"];
    $encrypt_method = $security["encryption_mechanism"];

    // hash
    $key = hash("sha256", $secret_key);

    // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
    $iv = substr(hash("sha256", $secret_iv), 0, 16);

    //do the encryption given text/string/number
    $result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($result);
    return $output;
}

function decrypt($string)
{

    $output = false;
    /*
     * read security.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
     */

    $security = parse_ini_file("security.ini");
    $secret_key = $security["encryption_key"];
    $secret_iv = $security["iv"];
    $encrypt_method = $security["encryption_mechanism"];

    // hash
    $key = hash("sha256", $secret_key);

    // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
    $iv = substr(hash("sha256", $secret_iv), 0, 16);

    //do the decryption given text/string/number

    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    return $output;
}

function slug($string)
{
    $slug = url_title($string, '-', true);
    return $slug;
}

function short_string($string, $wordsreturned)
{
    $retval = $string;
    $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $string);
    $string = str_replace("\n", " ", $string);
    $array = explode(" ", $string);
    if (count($array) <= $wordsreturned) {
        $retval = $string;
    } else {
        array_splice($array, $wordsreturned);
        $retval = implode(" ", $array) . " ...";
    }
    return strip_tags($retval);
}

function youtube_id($string)
{
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $string, $match)) {
        $video_id = $match[1];
    }
    return $video_id;
}

function youtube_thumnail($video_id, $quality)
{
    //QUALITY
    //sddefault
    //mqdefault
    //hqdefault
    //maxresdefault

    $thumnail = "https://img.youtube.com/vi/$video_id/$quality.jpg";
    return $thumnail;
}

function thisIP()
{
    $ip = 'none';
    //ip from share internet
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    //ip pass from proxy
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //remot ip
    if (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function useragent($string)
{
    $agent = \Config\Services::request()->getUserAgent();
    if ($string == 'agent') {
        if ($agent->isBrowser()) {
            $currentAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
        } elseif ($agent->isRobot()) {
            $currentAgent = $agent->getRobot();
        } elseif ($agent->isMobile()) {
            $currentAgent = $agent->getMobile();
        } else {
            $currentAgent = 'Unidentified User Agent';
        }
        return $currentAgent;
    } else if ($string == 'platform') {
        return $agent->getPlatform();
    } else if ($string == 'referrer') {
        return $agent->getReferrer();
    } else if ($string == 'all') {
        return $agent->getAgentString();
    } else {
        return 'Function not suport';
    }
}

function getcountry($string, $ip)
{
    $ipl = new \App\Libraries\IP2Location_lib();
    if ($string == 'code') {
        return $ipl->getCountryCode($ip);
    } else if ($string == 'name') {
        return $ipl->getCountryName($ip);
    } else if ($string == 'region') {
        return $ipl->getRegionName($ip);
    } else if ($string == 'city') {
        return $ipl->getCityName($ip);
    } else if ($string == 'lat') {
        return $ipl->getLatitude($ip);
    } else if ($string == 'long') {
        return $ipl->getLongitude($ip);
    } else {
        return 'Function not suport';
    }
}
