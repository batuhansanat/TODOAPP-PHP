<?php
require 'inc/func.php';
if(!isset($_SESSION))
{
    session_start();
}

if(isset($_GET['user'])){

    if(getGET('user') == 'logout'){
        session_destroy();
        session_start();
        setSession('success','Başarıyla çıkış yaptınız!');
        goPage('login.php');
    }
}