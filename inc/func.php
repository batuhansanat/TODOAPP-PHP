<?php
require 'db.php';

function getPOST($post){
    return $_POST[$post];
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

function getStatus($status){
    if($status == 1){
        return [
            'title' => 'Devam Eden',
            'color' => 'success',
            'icon' => 'fa fa-check'
        ];
    }elseif($status == 0){
        return [
            'title' => 'Biten',
            'color'=> 'danger',
            'icon' => 'fa fa-trash'
        ];
    }
}
