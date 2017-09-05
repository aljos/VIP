<?php
/*if(isset($_GET['mode']) and $_GET['mode'] == "analitics" and $_GET['url']  == "prices"){
    header ("HTTP/1.1 301 Moved Permanently");
    header ("Location: https://info.shuvar.com/price");
    die;
}elseif(isset($_GET['mode']) and $_GET['mode']  == "analitics" and $_GET['url']  == "amounts"){
    header ("HTTP/1.1 301 Moved Permanently");
    header ("Location: https://info.shuvar.com/amounts");
    die;
}elseif(isset($_GET['mode']) and $_GET['mode']  == "webcams"){
    header ("HTTP/1.1 301 Moved Permanently");
    header ("Location: /webcams");
    die;
}elseif(isset($_GET['mode']) and $_GET['mode']  == "pages" and $_GET['url']  == "working_hous"){
    header ("HTTP/1.1 301 Moved Permanently");
    header ("Location: /workhours");
    die;
}
elseif(isset($_GET['mode']) and $_GET['mode']  == "pages" and $_GET['url']  == "tariff"){
    header ("HTTP/1.1 301 Moved Permanently");
    header ("Location: /tariffs");
    die;
}*/
/*
if ($_SERVER['QUERY_STRING'] == "mode=analitics&url=prices﻿") {
    header ("HTTP/1.1 301 Moved Permanently");
    header ("Location: https://info.shuvar.com/price");
    exit();
}*/
session_start ();
/*
********************************************************************************
*   Project:        vip.shuvar.com by PhpStorm
*   Description:    index.php
*   Author:         Matsiyevskyy Oleg
*   Created:        01.09.2017 11:48
*   Mail:           aljos@shuvar.com
********************************************************************************
*/


//error_reporting(E_ALL|0);
//clearstatcache();

require ("classes/TCoreClass.php");

$Core = new TCore(); # Ініціалізація ядра, підключення всіх класів


//$Core->lang->setLang ();

if ($_GET['control'] and is_file (DOC_ROOT."controller/".$_GET['control']."/".$_GET['control']."Controller.php")) {
    $controller = $Core->db->prepare ($_GET['control'], FALSE);
    require ("controller/".$controller."/".$controller."Controller.php");

    $action = isset($_GET['action']) ? $Core->db->prepare ($_GET['action'], FALSE) : DEFAULT_ACTION;
} else {
    $controller = DEFAULT_CONTROLLER;
    $action     = DEFAULT_ACTION;
    require ("controller/".$controller."/".$controller."Controller.php");
}

$Class = $controller."Controller";

$app = new $Class ();

$app->$action ();

//ToDo: Make SEO Module



