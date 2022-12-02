<?php
session_start();
require 'inc/func.php';
require 'theme-parts/header.php';

if(!getSession('username')) {
    setSession('error', 'Sayfayı görüntüleyebilmek için giriş yapmalısınız.');
    goPage('login.php');
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
                                <h3 class="card-title">Yapılacak Ekle</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="addTodo" action="" method="post">
                                <div class="card-body">
                                    <?php
                                    if(isset($_SESSION['error'])) echo '<div class="bg-danger text-white p-2 mb-4">'.$_SESSION['error'].'</div>';
                                    ?>
                                    <?php
                                    if(isset($_SESSION['success'])) echo '<div class="bg-success text-white p-2 mb-4">'.$_SESSION['success'].'</div>';
                                    ?>
                                    <div class="form-group">
                                        <label for="todoName">Yapılacaklar Başlığı</label>
                                        <input type="text" class="form-control" name="todoName" id="todoName" placeholder="Yapılacakların başlığı">
                                        <label for="todoDesc" class="mt-3">Yapılacaklar Açıklaması</label>
                                        <textarea name="todoDesc" id="todoDesc" class="form-control" rows="3"></textarea>
                                        <label for="todoCat" class="mt-3">Yapılacaklar Kategorisi</label>
                                        <select class="form-control" name="todoCat" id="todoCat">
                                            <option> -- Kategori Seçin --</option>
                                        </select>
                                        <label for="todoColor" class="mt-3">Yapılacaklar Rengi</label>
                                        <input type="color" class="form-control w-25" name="todoColor" id="todoColor">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label for="todoStartDate" class="mt-3">Başlangıç Tarihi</label>
                                                <input type="date" class="form-control" name="todoStartDate" id="todoStartDate">
                                            </div>
                                            <div class="col md-4">
                                                <label for="todoStartTime" class="mt-3">Başlangıç Saati</label>
                                                <input type="time" class="form-control" name="todoStartTime" id="todoStartTime">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label for="todoEndDate" class="mt-3">Bitiş Tarihi</label>
                                                <input type="date" class="form-control" name="todoEndDate" id="todoEndDate">
                                            </div>
                                            <div class="col md-4">
                                                <label for="todoEndTime" class="mt-3">Bitiş Saati</label>
                                                <input type="time" class="form-control" name="todoEndTime" id="todoEndTime">
                                            </div>
                                        </div>
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
<script src="../../plugins/sweetalert2/sweetalert2.all.js"></script>

<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.0/axios.min.js" integrity="sha512-OdkysyYNjK4CZHgB+dkw9xQp66hZ9TLqmS2vXaBrftfyJeduVhyy1cOfoxiKdi4/bfgpco6REu6Rb+V2oVIRWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    const addTodo = document.getElementById('addTodo');

    addTodo.addEventListener('submit',(e) => {
        let todoName = document.getElementById('todoName').value;
        let todoDesc = document.getElementById('todoDesc').value;
        let todoCat = document.getElementById('todoCat').value;
        let todoColor = document.getElementById('todoColor').value;
        let todoStartDate = document.getElementById('todoStartDate').value;
        let todoStartTime = document.getElementById('todoStartTime').value;
        let todoEndDate = document.getElementById('todoEndDate').value;
        let todoEndTime = document.getElementById('todoEndTime').value;

        let formData = new FormData();

        formData.append('todoName',todoName);
        formData.append('todoDesc',todoDesc);
        formData.append('todoCat',todoCat);
        formData.append('todoColor',todoColor);
        formData.append('todoStartDate',todoStartDate);
        formData.append('todoStartTime',todoStartTime);
        formData.append('todoEndDate',todoEndDate);
        formData.append('todoEndTime',todoEndTime);

        axios.post('api.php?q=addTodo',formData).then(res => {

            Swal.fire(
                res.data.title,
                res.data.message,
                res.data.status
            );
            console.log(res)
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