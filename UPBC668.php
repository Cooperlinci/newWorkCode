<?php

// backup
function get_ip_config($istry=0){    //浏览者IP
    if (isset($_SERVER['HTTP_CF_PSEUDO_IPV4']) && $_SERVER['HTTP_CF_PSEUDO_IPV4']) { //返回IPV6地址时用IPV4的地址
        $ip = $_SERVER['HTTP_CF_PSEUDO_IPV4'];
    } else if (isset($_SERVER['HTTP_TRUE_CLIENT_IP']) && $_SERVER['HTTP_TRUE_CLIENT_IP']) {
        $ip = $_SERVER['HTTP_TRUE_CLIENT_IP'];
    } else if ($istry || (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = @trim(reset(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])));
    } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    }
    return preg_match('/^[\d]([\d\.]){5,13}[\d]$/', $ip) ? $ip : '';
}
$_ip = get_ip_config();
if(in_array($_ip, ['170.231.251.173', '95.164.234.11'])){
    @header('HTTP/1.1 403');
    exit;
}

$path = dirname($_SERVER['SCRIPT_FILENAME']);
$pos = strpos($path, "manage");
if ($pos === false) {
    session_start();

    $restrictedEmails = ['hristopher.hughes@jmailservice.com', 'william.grant@jmailservice.com'];
    $fieldsToCheck = [3, 9];
    foreach ($fieldsToCheck as $field) {
        if (isset($_POST['Field'][$field]) && in_array($_POST['Field'][$field], $restrictedEmails)) {
            header('HTTP/1.1 403');
            exit;
        }
    }
}

// modify
function get_ip_config($istry=0){    //浏览者IP
    if (isset($_SERVER['HTTP_CF_PSEUDO_IPV4']) && $_SERVER['HTTP_CF_PSEUDO_IPV4']) { //返回IPV6地址时用IPV4的地址
        $ip = $_SERVER['HTTP_CF_PSEUDO_IPV4'];
    } else if (isset($_SERVER['HTTP_TRUE_CLIENT_IP']) && $_SERVER['HTTP_TRUE_CLIENT_IP']) {
        $ip = $_SERVER['HTTP_TRUE_CLIENT_IP'];
    } else if ($istry || (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = @trim(reset(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])));
    } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    }
    return preg_match('/^[\d]([\d\.]){5,13}[\d]$/', $ip) ? $ip : '';
}
$_ip = get_ip_config();
if(in_array($_ip, ['170.231.251.173', '95.164.234.11'])){
    @header('HTTP/1.1 403');
    exit;
}

$path = dirname($_SERVER['SCRIPT_FILENAME']);
$pos = strpos($path, "manage");
if ($pos === false) {
    session_start();
    $restrictedSuffix = '@jmailservice.com';
    $fieldsToCheck = [3, 9];
    foreach ($fieldsToCheck as $field) {
        if (isset($_POST['Field'][$field]) && !empty($_POST['Field'][$field])) {
            $email = trim($_POST['Field'][$field]);
            if (strrpos($email, $restrictedSuffix) === strlen($email) - strlen($restrictedSuffix)) {
                header('HTTP/1.1 403');
                exit;
            }
        }
    }
}