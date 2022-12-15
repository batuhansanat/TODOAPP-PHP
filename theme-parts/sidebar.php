<

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <span class="brand-text font-weight-light">todoAPP</span>
    </a>

    <!-- Sidebar -->

    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="upload/users/01112022/avatar.png" class="img-circle elevation-3" alt="User Image">
            </div>
            <div class="info">
                <a href="profile.php?profile=<?= getSession('username') ?>" class="d-block text-bold"><?= getSession('username') ?> (<?php if(isset($_SESSION['userAge'])) echo getSession('userAge'); ?>)</a>
            </div>

        </div>
        <div class="info-box">
            <p><?php if(isset($_SESSION['profileDesc'])) echo getSession('profileDesc'); ?></p>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Kategoriler
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-category.php" class="nav-link">
                                <i class="far fa-plus-square nav-icon"></i>
                                <p>Kategori Ekle</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="list-category.php" class="nav-link">
                                <i class="far fa-list-alt nav-icon"></i>
                                <p>Listele / Düzenle</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            Yapılacaklar
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="add-todo.php" class="nav-link">
                                <i class="far fa-plus-square nav-icon"></i>
                                <p>Yapılacak Ekle</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="list-todo.php" class="nav-link">
                                <i class="far fa-list-alt nav-icon"></i>
                                <p>Listele / Düzenle</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="statistics.php" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            İstatistikler
                            <span class="right badge badge-danger">Yeni</span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

>