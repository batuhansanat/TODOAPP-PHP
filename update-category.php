<?php
require 'inc/func.php';
require 'theme-parts/header.php';
global $db;
if(!isset($_SESSION))
{
    session_start();
}
if(!getSession('username')) {
    setSession('error', 'Sayfayı görüntüleyebilmek için giriş yapmalısınız.');
    goPage('login.php');
}

if(isset($_GET['q'])){
    if($_GET['q'] == 'edit'){
        $list_cat = $db->prepare('SELECT * FROM category WHERE user_id=? && category.categoryid=?');
        $list_cat->execute([getSession('userid'),getGET('id')]);
        $cat = $list_cat->fetch(PDO::FETCH_ASSOC);
    }
}
else{
    goPage('list-category.php');
}


if(isset($_POST['submit'])){
    if(!getPOST('categoryName')){
        setSession('error','Kategorinin adı boş bırakılamaz!');
    }
    else{
        $update_category= $db->prepare('UPDATE category SET cat_name=?,cat_color=?,cat_desc=? WHERE user_id=? && category.categoryid=?');
        $update_category->execute([getPOST('categoryName'),getPOST('categoryColor'),getPOST('categoryDesc'),getSession('userid'),$_GET['id']]);
        goPage('update-category.php?q=edit&id='.getGET('id'));
    }
}
?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php require 'theme-parts/navbar.php'?>
    <!-- /.navbar -->

        <?php require 'theme-parts/sidebar.php'?>

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
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Kategori Güncelle</h3>
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
                                        <input type="text" class="form-control" name="categoryName" value="<?= $cat['cat_name'] ?>">
                                        <label for="categoryName">Kategori Açıklaması</label>
                                        <textarea name="categoryDesc" class="form-control" rows="3"><?= $cat['cat_desc'] ?></textarea>
                                        <label for="categoryColor">Kategorinin Rengi</label>
                                        <input type="color" class="form-control w-25" name="categoryColor" value="<?= $cat['cat_color'] ?>">
                                    </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-success w-25">Güncelle</button>
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