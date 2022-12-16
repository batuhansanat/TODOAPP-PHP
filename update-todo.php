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
        $list_todo = $db->prepare('SELECT * FROM todos 
         LEFT JOIN category c on categoryid = todos.cat_id
         WHERE todos.user_id=? && todos.todosid=?');
        $list_todo->execute([getSession('userid'),getGET('id')]);
        $todo = $list_todo->fetch(PDO::FETCH_ASSOC);

        $list_cat = $db->prepare('SELECT * FROM category WHERE user_id=?');
        $list_cat->execute([getSession('userid')]);
        $cat = $list_cat->fetchAll(PDO::FETCH_ASSOC);


    }
}
else{
    goPage('list-todo.php');
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
                                <h3 class="card-title">Yapılacaklar Öğesini Güncelle</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="" id="updateTodoForm" method="post">
                                <div class="card-body">
                                    <?php
                                    if(isset($_SESSION['error'])) echo '<div class="bg-danger text-white p-2 mb-4">'.$_SESSION['error'].'</div>';
                                    ?>
                                    <?php
                                    if(isset($_SESSION['success'])) echo '<div class="bg-success text-white p-2 mb-4">'.$_SESSION['success'].'</div>';
                                    ?>
                                    <div class="form-group">
                                        <label for="todoName">Yapılacaklar Başlığı</label>
                                        <input type="text" class="form-control" name="todoName" id="todoName" value="<?= $todo['todo_title'] ?>">
                                        <label for="todoDesc" class="mt-3">Yapılacaklar Açıklaması</label>
                                        <textarea name="todoDesc" id="todoDesc" class="form-control" rows="3"><?= $todo['todo_desc'] ?></textarea>
                                        <label for="todoCat" class="mt-3">Yapılacaklar Kategorisi</label>
                                        <select class="form-control" name="todoCat" id="todoCat">
                                            <?php global $cat; if($todo['cat_id'] != 0): ?>
                                                <option class="text-bold" value="<?= $todo['cat_id'] ?>"><?= $todo['cat_name'] ?></option>
                                             <?php endif;?>
                                            <?php global $cat;
                                            foreach ($cat as $key => $value): ?>
                                                <option value="<?= $value['categoryid'] ?>"> <?= $value['cat_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="todoColor" class="mt-3">Yapılacaklar Rengi</label>
                                        <input type="color" class="form-control w-25" name="todoColor" id="todoColor" value="<?= $todo['todo_color'] ?>">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="todoEndDate" class="mt-3">Bitiş Tarihi</label>
                                                <input type="date" class="form-control" name="todoEndDate" id="todoEndDate" value="<?= explode(' ',$todo['todo_end_date'])[0]; ?>">
                                            </div>
                                        </div>
                                        <label for="todoStatus" class="mt-3">Durumu</label>
                                        <select class="form-control w-25" id="todoStatus" name="todoStatus">
                                            <option value="1">Devam Eden</option>
                                            <option value="0">Biten</option>
                                        </select>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.0/axios.min.js" integrity="sha512-OdkysyYNjK4CZHgB+dkw9xQp66hZ9TLqmS2vXaBrftfyJeduVhyy1cOfoxiKdi4/bfgpco6REu6Rb+V2oVIRWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="../../plugins/sweetalert2/sweetalert2.all.js"></script>

<script>

    const updateTodoForm = document.getElementById('updateTodoForm');

    updateTodoForm.addEventListener('submit',(e) =>{
        let todoName = document.getElementById('todoName').value;
        let todoDesc = document.getElementById('todoDesc').value;
        let todoCat = document.getElementById('todoCat').value;
        let todoColor = document.getElementById('todoColor').value;
        let todoEndDate = document.getElementById('todoEndDate').value;
        let todoStatus = document.getElementById('todoStatus').value;

        let formData = new FormData();

        formData.append('todoName',todoName);
        formData.append('todoDesc',todoDesc);
        formData.append('todoCat',todoCat);
        formData.append('todoColor',todoColor);
        formData.append('todoEndDate',todoEndDate);
        formData.append('todoStatus',todoStatus);

        axios.post('api.php?q=updateTodo&id=<?= $_GET['id']?>',formData).then(res => {

            Swal.fire(
                res.data.title,
                res.data.message,
                res.data.status
            ).then(()=>{
                window.location = "update-todo.php?q=edit&id=<?=$_GET['id'] ?>"
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