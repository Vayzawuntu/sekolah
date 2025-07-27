<?php
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../config.php';

$title = "Data Ujian - SMP PGRI 363";
require_once '../template/header.php';
require_once '../template/navbar.php';
require_once '../template/sidebar.php';
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Ujian</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Data Ujian</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-list"></i> Data Ujian
                    <?php if ($_SESSION['ssJabatan'] === 'admin' || $_SESSION['ssJabatan'] === 'guru') : ?>
                        <a href="nilai-ujian.php" class="btn btn-sm btn-primary float-end">
                            <i class="fa-solid fa-plus"></i> Tambah Data Ujian
                        </a>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No Ujian</th>
                                <th>NIS</th>
                                <th>Kelas</th>
                                <th>Nilai Terendah</th>
                                <th>Nilai Tertinggi</th>
                                <th>Nilai Rata-rata</th>
                                <th>Hasil Ujian</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <!-- Contoh data kosong, nanti ganti dengan query dari DB -->
                            <tr>
                                <td colspan="7">Belum ada data ujian.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<?php require_once '../template/footer.php'; ?>
