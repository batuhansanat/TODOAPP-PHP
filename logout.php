<?php
require 'inc/func.php';
session_start();

if(isset($_GET['user'])){

    if(getGET('user') == 'logout'){
        session_destroy();
        session_start();
        setSession('success','Başarıyla çıkış yaptınız!');
        goPage('login.php');
    }
}