<?php
require 'db.php';

$errorMessage = '';

function getPOST($post){
    return $_POST[$post];
}

function setPOST($post,$value){
    $_POST[$post] = $value;
}

function getGET($get){
    return $_GET[$get];
}

function getSession($session){
    return $_SESSION[$session];
}

function setSession($session,$value){
    $_SESSION[$session] = $value;
}

function goPage($page){
    header('Location:'.$page);
}
