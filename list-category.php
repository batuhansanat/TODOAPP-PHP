<?php
session_start();
require 'inc/func.php';
require 'theme-parts/header.php';
global $db;
if(!getSession('username')) {
    setSession('error', 'Sayfayı görüntüleyebilmek için giriş yapmalısınız.');
    goPage('login.php');
}else{
    $categories = $db->prepare('SELECT * FROM category WHERE user_id=?');
    $categories->execute([getSession('userid')]);
    $cat = $categories->fetchAll(PDO::FETCH_ASSOC);
    $catCount = $categories->rowCount();
}
/*---> KATEGORİ SİLME <----*/
if(isset($_GET['q'])){
    if(getGET('q') == 'delete'){
        $deleteCat = $db->prepare('DELETE FROM category WHERE id=? && user_id=?');
        $deleteCat->execute([getGET('id'),getSession('userid')]);
        goPage('list-category.php');
    }
}
/*---> KATEGORİ SİLME <----*/

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

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-header bg-cyan">
                                <h3 class="card-title text-bold">Kategorileriniz</h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Kategori Adı</th>
                                        <th>Oluşturma Tarihi</th>
                                        <th>Açıklaması</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i = 0; $i < $catCount; $i++): ?>
                                    <tr>

                                        <td style="background-color: <?= $cat[$i]['cat_color'] ?>;
                                                width: 60px;
                                                -webkit-text-stroke: 1px black;
                                                font-size:
                                                1.6rem"
                                            class="text-bold text-white"> </td>
                                        <td><?= $cat[$i]['cat_name']?></td>
                                        <td><?= $cat[$i]['cat_create_date']?></td>
                                        <td style="max-width: 300px; overflow: auto"><?= $cat[$i]['cat_desc'] ?></td>
                                        <td>
                                            <div>
                                            <a href="update-category.php?q=edit&id=<?= $cat[$i]['id'] ?>" class="btn btn-success">Düzenle</a>
                                            <a href="?q=delete&id=<?= $cat[$i]['id'] ?>" class="btn btn-danger" >Sil</a>
                                            </div>
                                        </td>

                                    </tr>
                                    <?php endfor; ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
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