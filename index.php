<?php

require 'inc/func.php';
require 'theme-parts/header.php';
if(!isset($_SESSION))
{
    session_start();
}

if(!getSession('username')){
    setSession('error','Sayfayı görüntüleyebilmek için giriş yapmalısınız.');
    goPage('login.php');
}else{
    global $db;
    $q = $db->prepare('SELECT todo_status, COUNT(user_id) as toplamlar FROM todos
                                WHERE user_id=?
                                GROUP BY todo_status');
    $q->execute([getSession('userid')]);
    $todoInfo = $q->fetchAll(PDO::FETCH_ASSOC);

    $q2 = $db->query('SELECT * FROM todos WHERE user_id='.getSession('userid'));
    $fullTodos = $q2->fetchAll(PDO::FETCH_ASSOC);
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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <?php foreach ($todoInfo as $value): ?>
                    <div class="col-md-6 col-sm-12 col-12">
                        <div class="info-box bg-gradient-<?=getStatus($value['todo_status'])['color'] ?>">
                            <span class="info-box-icon"><i class="<?=getStatus($value['todo_status'])['icon'] ?>"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><?= getStatus($value['todo_status'])['title'] ?></span>
                                <span class="info-box-number text-bold text-xl"><?= $value['toplamlar'] ?></span>

                                <span class="progress-description">
                 <?= 'Toplam '.getStatus($value['todo_status'])['title'].' sayısı '.$value['toplamlar'].' adet.' ?>
                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <?php endforeach; ?>

                </div>

                <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                            <div class="info-box bg-gradient-gray-dark">
                                <span class="info-box-icon"><i class="fa fa-archive"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Toplam Yapılacaklar</span>
                                    <span class="info-box-number text-bold text-xl"><?= $todoInfo[0]['toplamlar'] + $todoInfo[1]['toplamlar'] ?></span>

                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                </div>
                <hr class="my-5">


                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script src="plugins/fullcalendar/main.min.js"></script>
<script src="plugins/fullcalendar/locales/tr.js"></script>



</body>


<?php
require 'theme-parts/footer.php';
?>
