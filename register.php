<?php
require 'inc/func.php';
require 'theme-parts/header.php';
if(!isset($_SESSION))
{
    session_start();
}

if(isset($_POST['submit'])){
    if(!getPOST('username') && !getPOST('email') && !getPOST('password') && !getPOST('password2')){
        setSession('error','Kullanıcı adı, e-posta ve şifre kısımları boş bırakılamaz');
    }
    elseif (!getPOST('username')){
        setSession('error','Kullanıcı adı boş bırakılamaz');
    }
    elseif (!getPOST('email')){
        setSession('error','E posta boş bırakılamaz');
    }
    elseif (!getPOST('password')){
        setSession('error','Şifre boş bırakılamaz');
    }
    elseif (!getPOST('password2')){
        setSession('error','Şifre boş bırakılamaz');
    }
    else{
        $username = getPOST('username');
        $email = getPOST('email');
        $password = getPOST('password');

    }

    if(getPOST('password') != getPOST('password2')){
        setSession('error','Belirtilen şifreler aynı olmalıdır');
    }else{
        $register = $db->prepare('INSERT INTO users(username,password,email) VALUES (?,?,?)');
        $register->execute([strip_tags(trim($username)),$password,$email]);
        setSession('success','Başarıyla kayıt olundu! Hesabınıza giriş yapabilirsiniz.');
        goPage('login.php');
    }


}

?>
<body class="hold-transition login-page">
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>todo</b>APP</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Yeni bir üyelik oluştur</p>
            <?php
            echo getSession('error')
                ? '<div class="bg-danger text-white p-2 mb-4">'.getSession('error').'</div>'
                : null;
            ?>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="username" value="<?php echo isset($username) ? $username : null ?>" class="form-control" placeholder="Kullanıcı adınız">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" value="<?php echo isset($email) ? $email : null ?>" class="form-control" placeholder="E-Posta adresiniz">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Şifreniz">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password2" class="form-control" placeholder="Şifrenizin tekrarı">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                                       <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Kayıt Ol</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center">
                <a href="login.php" class="btn btn-block btn-success">
                    <i class="fa fa-user mr-2"></i>
                    Giriş Yap
                </a>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>

<?php
require 'theme-parts/footer.php';
setSession('error',null);
?>

