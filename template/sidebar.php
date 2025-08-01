<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion bg-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">

                    <!-- Menu HOME -->
                    <div class="sb-sidenav-menu-heading">Home</div>
                    <a class="nav-link" href="<?= $main_url ?>index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <hr class="mb-0">

                    <!-- ✅ Hanya Admin -->
                        <div class="sb-sidenav-menu-heading">Admin</div>
                        <a class="nav-link" href="<?= $main_url ?>user/add-user.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            User
                        </a>
                        <a class="nav-link" href="<?= $main_url ?>user/password.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-key"></i></div>
                            Ganti Password
                        </a>
                        <hr class="mb-0">

                    <!-- Menu Data (Semua Role Bisa Akses) -->
                    <div class="sb-sidenav-menu-heading">Data</div>
                    <a class="nav-link" href="<?= $main_url ?>siswa/siswa.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Siswa
                    </a>
                    <a class="nav-link" href="<?= $main_url ?>guru/guru.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                        Guru
                    </a>
                    <a class="nav-link" href="<?= $main_url ?>pelajaran/pelajaran.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                        Mata Pelajaran
                    </a>
                    <a class="nav-link" href="<?= $main_url ?>ujian/ujian.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user-graduate"></i></div>
                        Ujian
                    </a>
                </div>
            </div>

            <!-- Footer Sidebar -->
            <div class="sb-sidenav-footer border">
                <div class="small">Logged in as:</div>
                <?= isset($_SESSION["ssUser"]) ? htmlspecialchars($_SESSION["ssUser"]) : "-" ?>
            </div>
        </nav>
    </div>
</div>
