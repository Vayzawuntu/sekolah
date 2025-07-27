<?php
session_start();

if (!isset($_SESSION["ssLogin"])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../config.php';
$title = "Guru - SMP PGRI 363";
require_once '../template/header.php';
require_once '../template/navbar.php';
require_once '../template/sidebar.php';
?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Guru</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Guru</li>
            </ol>

            <!-- ALERT MESSAGE -->
            <?php if (isset($_GET['msg'])): ?>
                <?php
                $msg = $_GET['msg'];
                $alertClass = 'success';
                $text = '';

                switch ($msg) {
                    case 'deleted':
                        $text = '✅ Data guru berhasil dihapus.';
                        break;
                    case 'updated':
                        $text = '✅ Data guru berhasil diubah.';
                        break;
                    case 'added':
                        $text = '✅ Data guru berhasil ditambahkan.';
                        break;
                    case 'error':
                        $alertClass = 'danger';
                        $text = '❌ Terjadi kesalahan.';
                        break;
                    case 'notfound':
                        $alertClass = 'warning';
                        $text = '⚠️ Data guru tidak ditemukan.';
                        break;
                }
                ?>
                <?php if ($text): ?>
                    <div class="alert alert-<?= $alertClass ?> alert-dismissible fade show" role="alert">
                        <?= $text ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-list"></i> Data Guru
                    <?php if (isset($_SESSION['ssJabatan']) && strtolower($_SESSION['ssJabatan']) === 'admin'): ?>
                        <a href="<?= $main_url ?>guru/add-guru.php" class="btn btn-sm btn-primary float-end">
                            <i class="fa-solid fa-plus"></i> Tambah Guru
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabelGuru" class="table table-bordered table-hover">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Telepon</th>
                                    <th>Agama</th>
                                    <th>Alamat</th>
                                    <th>Operasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = mysqli_query($koneksi, "SELECT * FROM tbl_guru ORDER BY id DESC");
                                while ($data = mysqli_fetch_array($query)) {
                                    $foto = (!empty($data['foto']) && file_exists("../asset/image/" . $data['foto']))
                                        ? $data['foto']
                                        : "user.png";
                                ?>
                                    <tr class="text-center align-middle">
                                        <td><?= $no++; ?></td>
                                        <td>
                                            <img src="../asset/image/<?= $foto; ?>" 
                                                alt="foto guru" 
                                                class="rounded-circle" 
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        </td>
                                        <td><?= htmlspecialchars($data['nip']); ?></td>
                                        <td><?= htmlspecialchars($data['nama']); ?></td>
                                        <td><?= htmlspecialchars($data['telepon']); ?></td>
                                        <td><?= htmlspecialchars($data['agama']); ?></td>
                                        <td><?= htmlspecialchars($data['alamat']); ?></td>
                                        <td>
                                            <?php if (isset($_SESSION['ssJabatan']) && strtolower($_SESSION['ssJabatan']) === 'admin'): ?>
                                                <a href="edit-guru.php?id=<?= $data['id']; ?>" class="btn btn-sm btn-warning" title="Edit Guru">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <a href="hapus-guru.php?id=<?= $data['id']; ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   title="Hapus Guru" 
                                                   onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Lihat Saja</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if (mysqli_num_rows($query) === 0): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Data guru belum tersedia.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#tabelGuru').DataTable({
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

<?php require_once '../template/footer.php'; ?>