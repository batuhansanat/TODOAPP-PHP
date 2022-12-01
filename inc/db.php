<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=todoapp','root','root');
}catch (PDOException $e){
    echo $e;
}