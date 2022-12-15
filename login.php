<?php

require 'inc/func.php';
require 'theme-parts/header.php';
if(!isset($_SESSION))
{
    session_start();
}

if(isset($_SESSION['username']) && getSession('userid')){
    goPage('index.php');
}

if(isset($_POST['submit'])){
    if(!getPOST('username') && !getPOST('password')){
        setSession('error','Kullanıcı adı veya şifre boş bırakılamaz');
    }
    elseif(!getPOST('username')){
        setSession('error','Kullanıcı adını girin');
    }
    elseif(!getPOST('password')){
        setSession('error','Şifrenizi girin');
    }
    else{
        setSession('username',strip_tags(trim($_POST['username'])));
        setSession('password',$_POST['password']);
        global $db;
        $usersAll = $db->prepare('SELECT * FROM todoapp.users WHERE username=? AND password=?');
        $usersAll->execute([trim(getSession('username')),getSession('password')]);
        if($usersAll->rowCount()){

            $user = $usersAll->fetch(PDO::FETCH_ASSOC);
            setSession('username',$_POST['username']);
            setSession('password',$_POST['password']);
            setSession('userid',$user['usersid']);
            setSession('userAge',$user['user_age']);
            setSession('profileDesc',$user['profile_desc']);
            goPage('index.php');
        }
        else{
            setSession('error','Kullanıcı adı veya şifre bulunamadı.');
        }
    }

}

?>

<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>todo</b>APP</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Giriş yapın</p>
            <?php
            if(isset($_SESSION['error'])) echo '<div class="bg-danger text-white p-2 mb-4">'.$_SESSION['error'].'</div>';
            ?>
            <?php
            if(isset($_SESSION['success'])) echo '<div class="bg-success text-white p-2 mb-4">'.$_SESSION['success'].'</div>';
            ?>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Şifre">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" name="submit" class="btn btn-success btn-block">Giriş Yap</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center">
                <a href="register.php" class="btn btn-block btn-danger">
                    <i class="fa fa-user mr-2"></i>
                    Kayıt Ol
                </a>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

<?php
require 'theme-parts/footer.php';
setSession('success',null);
setSession('error',null);

?>

