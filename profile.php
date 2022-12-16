<?php
require 'inc/func.php';
require 'theme-parts/header.php';
if(!isset($_SESSION))
{
    session_start();
}

global $db;
$get_users = $db->prepare('SELECT * FROM users WHERE usersid=?');
$get_users->execute([getSession('userid')]);
$user = $get_users->fetchAll(2);

?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php require 'theme-parts/navbar.php'?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <span class="brand-text font-weight-light">todoAPP</span>
        </a>

        <!-- Sidebar -->
        <?php require 'theme-parts/sidebar.php'?>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Profilini Düzenle</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="" id="updateProfile" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="username">Kullanıcı Adı</label> <span class="text-xs text-danger">(Kullanıcı adı şuan için değiştirilemez)</span>
                                        <input type="text" class="form-control" id="username" value="<?= $user[0]['username'] ?>" disabled>
                                        <label for="userEmail">E-Posta Adresi</label>
                                        <input type="email" class="form-control" id="userEmail" value="<?= $user[0]['email'] ?>">
                                        <label for="profileDesc" class="mt-3">Profil Açıklaması</label>
                                        <textarea id="profileDesc" class="form-control" rows="3"><?= $user[0]['profile_desc'] ?? null ?></textarea>
                                        <label for="userAge" class="mt-3">Yaş</label>
                                        <input type="text" class="form-control" id="userAge" value="<?= $user[0]['user_age'] ?? null ?>">
                                    </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer mb-5">
                                    <button type="submit" class="btn btn-success w-100">Güncelle</button>
                                </div>
                            </form>

                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Şifre Değiştir</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="" id="updatePassword" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="oldPassword">Eski şifreniz</label>
                                        <input type="text" class="form-control" id="oldPassword">
                                        <label for="newPassword">Yeni şifreniz</label>
                                        <input type="password" class="form-control" id="newPassword">
                                        <label for="newPassword2">Yeni şifreniz</label>
                                        <input type="password" class="form-control" id="newPassword2">
                                    </div>
                                </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer mb-5">
                            <button type="submit" class="btn btn-danger w-100">Şifremi Değiştir</button>
                        </div>
                        </form>
                        </div>
                        <!-- /.card -->


                    </div>
                    <!--/.col (left) -->
                    <!-- right column --><!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div><!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="../../plugins/sweetalert2/sweetalert2.all.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.0/axios.min.js" integrity="sha512-OdkysyYNjK4CZHgB+dkw9xQp66hZ9TLqmS2vXaBrftfyJeduVhyy1cOfoxiKdi4/bfgpco6REu6Rb+V2oVIRWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Page specific script -->
<script>

    const updateProfile = document.getElementById('updateProfile');
    const updatePassword = document.getElementById('updatePassword');

    updateProfile.addEventListener('submit',(e)=>{

        let userEmail = document.getElementById('userEmail').value;
        let profileDesc = document.getElementById('profileDesc').value;
        let userAge = document.getElementById('userAge').value;

        let updateForm = new FormData();

        updateForm.append('userEmail',userEmail);
        updateForm.append('profileDesc',profileDesc);
        updateForm.append('userAge',userAge);

        axios.post('api.php?q=profileUpdate',updateForm).then(res => {

            Swal.fire(
                res.data.title,
                res.data.message,
                res.data.status
            ).then(() =>{
                window.location = 'profile.php';
            });
        }).catch(err => console.log(err));

        e.preventDefault();
    })

    updatePassword.addEventListener('submit',(e)=>{
        let oldPassword = document.getElementById('oldPassword').value;
        let newPassword = document.getElementById('newPassword').value;
        let newPassword2 = document.getElementById('newPassword2').value;

        let passwordUpdate = new FormData();

        passwordUpdate.append('oldPassword',oldPassword);
        passwordUpdate.append('newPassword',newPassword);
        passwordUpdate.append('newPassword2',newPassword2);

        axios.post('api.php?q=passwordUpdate',passwordUpdate).then(res => {

            Swal.fire(
                res.data.title,
                res.data.message,
                res.data.status
            ).then(() =>{
                window.location = 'profile.php';
            });
        }).catch(err => console.log(err));


        e.preventDefault();
    })

</script>
</body>


<?php
require 'theme-parts/footer.php';
setSession('success',null);
setSession('error',null);
?>