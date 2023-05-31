<?php

//session start
session_start();

//config
define('BASE_PATH', __DIR__);
define('CURRENT_DOMAIN', currentDomain() . '/project/');
define('DISPLAY_ERROR', true);
define('DB_HOST', 'localhost');
define('DB_NAME', 'project');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

//helpers

function protocol()
{
    return stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
}

function currentDomain()
{

    $domain = $_SERVER['HTTP_HOST'];
    return protocol() . $domain;
}


function asset($path)
{
    $domain = trim(CURRENT_DOMAIN, '/');
    $path = $domain . '/' . trim($path, '/');
    return $path;

}

function url($path)
{
    $domain = trim(CURRENT_DOMAIN, '/');
    $path = $domain . '/' . trim($path, '/');
    return  $path;
}

function currentUrl()
{
    return currentDomain() . $_SERVER['REQUEST_URI'];
}

function redirect($path)
{
    header('Location: ' . url($path));
    exit;
}