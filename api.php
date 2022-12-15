<?php
if(!isset($_SESSION))
{
    session_start();
}
require 'inc/func.php';
global $db;

if(isset($_GET)){
    if($_GET['q'] == 'addTodo'){

        if(!$_POST['todoName']){
            $status = 'error';
            $title = 'Uyarı';
            $message = 'Yapılacaklar listesine isimsiz ekleme yapılamaz!';
            echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
            exit();
        }

        $addTodo =$db ->prepare('INSERT INTO todos(user_id,cat_id,todo_title,todo_desc,todo_color,todo_start_date,todo_end_date,todo_status)
                                          VALUES(?,?,?,?,?,?,?,?)');
        $insert = $addTodo->execute([
            getSession('userid'),
            getPOST('todoCat') ?? 0,
            getPOST('todoName'),
            getPOST('todoDesc'),
            getPOST('todoColor'),
            getPOST('todoStartDate') ?: date('Y-m-d H:i:s'),
            getPOST('todoEndDate'),
            1
        ]);

        if(getPOST('todoCat')){
            $q = $db->prepare('SELECT cat_name,categoryid FROM category WHERE user_id=? && categoryid=?');
            $q->execute([getSession('userid'),getPOST('todoCat')]);
            $cat = $q->fetchAll(PDO::FETCH_ASSOC);
            if(!$cat){
                $status = 'error';
                $title = 'Hata';
                $message = 'Yalnızca oluşturmuş olduğunuz kategorilere ekleme yapabilirsiniz. Sayfayı yenileyip tekrar deneyin!';
                echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
                exit();
            }
        }

        if($insert){
            $status = 'success';
            $title = 'Başarılı';
            $message = '<b>"'.getPOST('todoName').'"</b> başarıyla yapılacaklar listenize eklendi!';
            echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
            exit();
        }
        else{
            $status = 'error';
            $title = 'Hata';
            $message = 'Beklenmedik bir hata meydana geldi. Sayfayı yenileyip tekrar deneyin!';
            echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
            exit();
        }
    }

    if($_GET['q'] == 'updateTodo'){
        if(!getPOST('todoName')){
            setSession('error','Kategorinin adı boş bırakılamaz!');
        }

            $update_todo= $db->prepare('UPDATE todos SET todo_title=?,todo_desc=?,todo_color=?,todo_end_date=?,todo_status=?
            WHERE user_id=? && todosid=?');
            $insert = $update_todo->execute([
                getPOST('todoName'),
                getPOST('todoDesc'),
                getPOST('todoColor'),
                getPOST('todoEndDate'),
                getPOST('todoStatus'),
                getSession('userid'),
                $_GET['id']]);

        if($insert){
            $status = 'success';
            $title = 'Başarılı';
            $message = '<b>"'.getPOST('todoName').'"</b> başarıyla güncellendi!';
            echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
            exit();
        }
        else{
            $status = 'error';
            $title = 'Hata';
            $message = 'Beklenmedik bir hata meydana geldi. Sayfayı yenileyip tekrar deneyin!';
            echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
            exit();
        }



    }

    if($_GET['q'] == 'profileUpdate'){

            $update_profile= $db->prepare('UPDATE users SET email=?,profile_desc=?,user_age=?
            WHERE usersid=?');
            $update_profile->execute([
                getPOST('userEmail'),
                getPOST('profileDesc'),
                getPOST('userAge'),
                getSession('userid')
            ]);
            $insert = $update_profile->rowCount();

            setSession('profileDesc',getPOST('profileDesc'));
            setSession('userAge',getPOST('userAge'));

        if($insert > 0){
            $status = 'success';
            $title = 'Başarılı';
            $message = 'Profiliniz başarıyla güncellendi!';
            echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
            exit();
        }
        else{
            $status = 'error';
            $title = 'Hata';
            $message = 'Profiliniz güncellenirken bir hata oluştu.';
            echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
            exit();
        }

    }

    if ($_GET['q'] == 'passwordUpdate'){

        if(getPOST('oldPassword')){
            if(getPOST('oldPassword') == getSession('password')){
                if(getPOST('newPassword') == getPOST('newPassword2')){
                    if(strlen(getPOST('newPassword')) >= 8){
                        $update_password= $db->prepare('UPDATE users SET password=?
                                                          WHERE usersid=? && password=?');
                        $update_password->execute([
                            getPOST('newPassword'),

                            getSession('userid'),
                            getPOST('oldPassword')
                        ]);
                        $insert = $update_password->rowCount();
                        setSession('password',getPOST('newPassword'));

                        if($insert > 0){
                            $status = 'success';
                            $title = 'Başarılı';
                            $message = 'Şifreniz başarıyla değiştirildi!';
                            echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
                            exit();
                        }

                    }
                    else{
                        $status = 'error';
                        $title = 'Hata';
                        $message = 'Şifreniz en az 8 karakterden oluşmalıdır.';
                        echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
                        exit();
                    }
                }
                else{
                    $status = 'error';
                    $title = 'Hata';
                    $message = 'Yeni şifrelerinizin ikisi de aynı olmalı.';
                    echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
                    exit();
                }
            }
            else{

                $status = 'error';
                $title = 'Hata';
                $message = 'Eski şifrenizi doğru girdiğinizden emin olun!';
                echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
                exit();
            }
        }
        else{
            $status = 'error';
            $title = 'Hata!';
            $message = 'Eski şifre kısmı boş bırakılamaz!';
            echo json_encode(['status' => $status, 'title' => $title, 'message' => $message]);
            exit();
        }

    }



    /*---> TODO SİLME <----*/
        if(getGET('q') == 'deleteTodo'){
            $deleteTodo = $db->prepare('DELETE FROM todos WHERE todosid=? && user_id=?');
            $deleteTodo->execute([getGET('id'),getSession('userid')]);
            setSession('error','Öğe başarıyla silindi!');
            goPage('list-todo.php');
        }

    /*---> TODO SİLME <----*/

}


