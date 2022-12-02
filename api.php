<?php

if(isset($_GET)){
    if($_GET['q'] == 'addTodo'){

        if(!$_POST['todoName']){
            $status = 'error';
            $title = 'Uyarı';
            $message = 'Yapılacaklar listesine isimsiz ekleme yapılamaz!';
            echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
            exit();
        }


    }
}