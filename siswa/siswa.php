<?php   
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("location: ../auth/login.php");
    exit();
}

require_once '../config.php';

$title = "Siswa - SMP PGRI 363";

// Cek role admin secara aman
$isAdmin = isset($_SESSION['ssJabatan']) && $_SESSION['ssJabatan'] === 'admin';

require_once '../template/header.php';
require_once '../template/navbar.php';
require_once '../template/sidebar.php';
?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-0">
            <h1 class="mt-4 px-4">Siswa</h1>
            <ol class="breadcrumb mb-4 px-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Siswa</li>
            </ol>

            <div class="card mx-4 mb-4 w-100">
                <div class="card-header">
                    <?php if ($isAdmin): ?>
                    <a href="<?= $main_url ?>/siswa/add-siswa.php" class="btn btn-sm btn-primary float-end">
                        <i class="fa-solid fa-plus"></i> Tambah Siswa
                    </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabelSiswa" class="table table-bordered table-hover">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Alamat</th>
                                    <?php if ($isAdmin): ?>
                                    <th>Operasi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $querySiswa = mysqli_query($koneksi, "SELECT * FROM tbl_siswa ORDER BY nis DESC");

                                while ($data = mysqli_fetch_assoc($querySiswa)) {
                                    $foto = (!empty($data['foto']) && file_exists("../asset/image/" . $data['foto']))
                                        ? $data['foto']
                                        : "default.png";

                                    $nis    = $data['nis'] ?? '-';
                                    $nama   = $data['nama'] ?? '-';
                                    $kelas  = $data['kelas'] ?? '-';
                                    $alamat = $data['alamat'] ?? '-';
                                ?>
                                <tr class="align-middle text-center">
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <img src="../asset/image/<?= htmlspecialchars($foto) ?>" 
                                             class="rounded-circle" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td><?= htmlspecialchars($nis) ?></td>
                                    <td><?= htmlspecialchars($nama) ?></td>
                                    <td><?= htmlspecialchars($kelas) ?></td>
                                    <td><?= htmlspecialchars($alamat) ?></td>
                                    <?php if ($isAdmin): ?>
                                    <td>
                                        <a href="edit-siswa.php?nis=<?= urlencode($nis) ?>" class="btn btn-sm btn-warning" title="Edit Siswa">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="hapus-siswa.php?nis=<?= urlencode($nis) ?>&foto=<?= urlencode($foto) ?>" 
                                           class="btn btn-sm btn-danger" 
                                           title="Hapus Siswa" 
                                           onclick="return confirm('Anda yakin menghapus data ini?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                                <?php } ?>
                                <?php if (mysqli_num_rows($querySiswa) === 0): ?>
                                <tr>
                                    <td colspan="<?= $isAdmin ? '7' : '6' ?>" class="text-center">Data siswa belum tersedia.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once '../template/footer.php'; ?>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#tabelSiswa').DataTable({
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ditemukan data yang cocok",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(disaring dari _MAX_ total data)"
            }
        });
    });
</script>

<style>
    #tabelSiswa th,
    #tabelSiswa td {
        vertical-align: middle;
        font-size: 14px;
        white-space: normal;
        word-wrap: break-word;
    }

    #tabelSiswa th:nth-child(2),
    #tabelSiswa td:nth-child(2) {
        width: 60px;
    }

    #tabelSiswa th:last-child,
    #tabelSiswa td:last-child {
        width: 110px;
    }
</style>
