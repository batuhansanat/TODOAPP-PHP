<?php
session_start();
require 'inc/func.php';
require 'theme-parts/header.php';

if(!getSession('username')) {
    setSession('error', 'Sayfayı görüntüleyebilmek için giriş yapmalısınız.');
    goPage('login.php');
}

if(isset($_POST['submit'])){
    if(!getPOST('categoryName')){
        setSession('error','Kategorinin adı boş bırakılamaz!');
    }
    else{
        global $db;
        $add_category= $db->prepare('INSERT INTO category(user_id,cat_name,cat_color,cat_desc) VALUES(?,?,?,?)');
        $add_category->execute([getSession('userid'),getPOST('categoryName'),getPOST('categoryColor'),getPOST('categoryDesc')]);
        setSession('success','Kategori başarıyla oluşturuldu!');
    }
}
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
                    <div class="col-md-8">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Kategori Ekle</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="" method="post">
                                <div class="card-body">
                                    <?php
                                    if(isset($_SESSION['error'])) echo '<div class="bg-danger text-white p-2 mb-4">'.$_SESSION['error'].'</div>';
                                    ?>
                                    <?php
                                    if(isset($_SESSION['success'])) echo '<div class="bg-success text-white p-2 mb-4">'.$_SESSION['success'].'</div>';
                                    ?>
                                    <div class="form-group">
                                        <label for="categoryName">Kategori Adı</label>
                                        <input type="text" class="form-control" name="categoryName" placeholder="Kategorinin adını girin">
                                        <label for="categoryName">Kategori Açıklaması</label>
                                        <textarea name="categoryDesc" class="form-control" rows="3"></textarea>
                                        <label for="categoryColor">Kategorinin Rengi</label>
                                        <input type="color" class="form-control w-25" name="categoryColor">
                                    </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-success w-25">Ekle</button>
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
<!-- Page specific script -->
<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>
</body>


<?php
require 'theme-parts/footer.php';
setSession('success',null);
setSession('error',null);
?>