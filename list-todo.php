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
}else{
    $todos = $db->prepare('SELECT * FROM todos 
         LEFT JOIN category c on c.categoryid = todos.cat_id                     
         WHERE todos.user_id=?');
    $todos->execute([getSession('userid')]);
    $todo = $todos->fetchAll(PDO::FETCH_ASSOC);
    $todoCount = $todos->rowCount();

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

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-header bg-gradient-orange">
                                <h3 class="card-title text-bold text-center">Yapılacaklar Listeniz</h3>
                                <a href="add-todo.php" style="font-size: 0.8rem; padding: 2px" class="btn btn-success ml-3"> Yeni Ekle </a>

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
                            <?php
                            if(isset($_SESSION['error'])) echo '<div class="bg-danger text-white p-2 mb-4">'.$_SESSION['error'].'</div>';
                            ?>
                            <?php
                            if(isset($_SESSION['success'])) echo '<div class="bg-success text-white p-2 mb-4">'.$_SESSION['success'].'</div>';
                            ?>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kategori</th>
                                        <th>Yapılacak Adı</th>
                                        <th>Yapılacak Açıklama</th>
                                        <th>Oluşturma Tarihi</th>
                                        <th>Bitiş Tarihi</th>
                                        <th>Durum</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php global $todo; foreach ($todo as $key => $value):?>
                                    <tr>

                                        <td style="background-color: <?= $value['todo_color'] ?>;
                                                width: 60px;
                                                -webkit-text-stroke: 1px black;
                                                font-size: 1.6rem" class="text-bold text-white">
                                        </td>
                                        <td class="text-bold text-center text-maroon"><?= $value['cat_name'] ?></td>
                                        <td><?= $value['todo_title']?></td>
                                        <td style="max-width: 300px; overflow: auto"><?= $value['todo_desc'] ?></td>
                                        <td><?= $value['todo_start_date']?></td>
                                        <td><?= $value['todo_end_date']?></td>
                                        <td>
                                            <?php
                                            if ($value['todo_status'] == 0):
                                            ?>
                                            <div class="bg-danger text-white text-center text-bold rounded">Biten</div>
                                            <?php else: ?>
                                            <div class="bg-success text-white text-center text-bold rounded">Devam Eden</div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div>
                                            <a href="update-todo.php?q=edit&id=<?= $value['todosid'] ?>" class="btn btn-primary float-right ml-1">Düzenle</a>
                                            <a href="api.php?q=deleteTodo&id=<?= $value['todosid'] ?>" class="btn btn-outline-danger float-right">Sil</a>
                                            </div>
                                        </td>

                                    </tr>
                                    <?php endforeach; ?>

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

    function addTodoMsg(){
        Swal.fire(
            'Başarılı!',
            'Öğeyi başarıyla sildiniz.',
            'success'
        ).then(()=>{
            window.location = 'list-todo.php';
        })
    }
</script>
</body>


<?php
require 'theme-parts/footer.php';
setSession('success',null);
setSession('error',null);
?>