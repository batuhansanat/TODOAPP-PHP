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

    $q2 = $db->prepare('SELECT * FROM todos
                            LEFT JOIN category c on categoryid = todos.cat_id
                            WHERE todos.user_id=? 
                            ORDER BY todo_end_date ASC');
    $q2->execute([getSession('userid')]);
    $fullTodos = $q2->fetchAll(PDO::FETCH_ASSOC);
    $todosCount = $q2->rowCount();
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
                                <span class="info-box-number text-bold text-xl">
                                            <?php
                                            if(!array_key_exists('0',$todoInfo)){
                                                $todoInfo[0]['toplamlar'] = 0;
                                            }

                                            if(!array_key_exists('1',$todoInfo)){
                                                $todoInfo[1]['toplamlar'] = 0;
                                            }

                                            echo $todoInfo[0]['toplamlar'] + $todoInfo[1]['toplamlar'];
                                            ?>
                                        </span>

                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>


                <hr class="my-5">
                <div class="row">
                    <div class="col-md-12">
                        <!-- SÜRESİ DEVAM EDENLER -->
                        <?php if($todosCount > 0): ?>
                        <?php foreach ($fullTodos as $key => $value): ?>
                        <?php if(date('Y-m-d') < $value['todo_end_date']): ?>
                            <?php
                            $endDate= explode(' ',$value['todo_end_date']);
                            $endDateTime = explode('-',$endDate[0]);
                            $day = $endDateTime[2];
                            $month = $endDateTime[1];
                            $year = $endDateTime[0];
                            $todayDate = date('Y-m-d');
                            $time = date_create($todayDate);
                            $time2 = date_create($endDate[0]);
                            $timeDiff = date_diff($time,$time2);
                            ?>
                        <div class="timeline">
                            <div class="time-label">
                                <span class="text-white shadow" style="background-color: <?= $value['cat_color'] ?>">Kategori: <?= $value['cat_name'] ?></span>
                                <span class="bg-gradient-info shadow text-white"><?= $day.'.'.$month.'.'.$year ?></span>
                                <span class="bg-gradient-blue shadow">
                                    <?php
                                    if($timeDiff->m > 0 && $timeDiff->y <= 0){
                                        echo 'Bitmesine '. $timeDiff->m.' ay '.$timeDiff->d.' gün kaldı';
                                    }
                                    elseif($timeDiff->m > 0 && $timeDiff->y > 0){
                                        echo 'Bitmesine '.$timeDiff->y.' yıl '. $timeDiff->m.' ay '.$timeDiff->d.' gün kaldı';
                                    }
                                    else{
                                        echo 'Bitmesine '.$timeDiff->d.' gün kaldı';
                                    }
                                    ?>

                                </span>
                            </div>
                            <div>
                                <i class="fa fa-li" style="background-color: <?= $value['todo_color'] ?>"></i>
                                <div class="timeline-item">
                                    <span class="time text-white"><i class="fas fa-clock"></i> <?= $endDate[1] ?></span>
                                    <h3 class="timeline-header text-white bg-gradient-dark"><b><?= $value['todo_title'] ?></b></h3>

                                    <div class="timeline-body text-bold">
                                        <?= $value['todo_desc'] ?>
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-success" href="update-todo.php?q=edit&id=<?= $value['todosid'] ?>">Düzenle</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- SÜRESİ DEVAM EDENLER -->

                        <!-- SÜRESİ BİTENLER -->
                        <?php if($todosCount > 0): ?>
                        <?php foreach ($fullTodos as $key => $value): ?>
                            <?php if(date('Y-m-d') >= $value['todo_end_date']): ?>
                                <?php
                                $endDate= explode(' ',$value['todo_end_date']);
                                $endDateTime = explode('-',$endDate[0]);
                                $day = $endDateTime[2];
                                $month = $endDateTime[1];
                                $year = $endDateTime[0];
                                $todayDate = date('Y-m-d');
                                $time = date_create($todayDate);
                                $time2 = date_create($endDate[0]);
                                $timeDiff = date_diff($time,$time2);
                                ?>
                                <div class="timeline">
                                    <div class="time-label">
                                        <span class="text-white shadow" style="background-color: <?= $value['cat_color'] ?>">Kategori: <?= $value['cat_name'] ?></span>
                                        <span class="bg-gradient-red"><?= $day.'.'.$month.'.'.$year ?></span>
                                        <span class="bg-gradient-red">Süresi Bitti</span>
                                    </div>
                                    <div>
                                        <i class="fa fa-li" style="background-color: <?= $value['todo_color'] ?>"></i>
                                        <div class="timeline-item">
                                            <span class="time text-white"><i class="fas fa-clock"></i> <?= $endDate[1] ?></span>
                                            <h3 class="timeline-header bg-gradient-dark text-white"><b><?= $value['todo_title'] ?></b></h3>

                                            <div class="timeline-body text-bold">
                                                <?= $value['todo_desc'] ?>
                                            </div>
                                            <div class="timeline-footer">
                                                <a class="btn btn-success" href="update-todo.php?q=edit&id=<?= $value['todosid'] ?>">Düzenle</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- SÜRESİ BİTENLER -->
                    </div>
                    <!-- /.col -->
                </div>


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
        <div class="float-right d-none d-sm-inline">PLANLA VE YAP</div>
        <!-- Default to the left -->
        <strong><a href="#">todoAPP</a> - BATUHAN SANAT</strong>
    </footer>
</div>
<!-- ./wrapper -->
</body>


<?php
require 'theme-parts/footer.php';
?>
