<?php
session_start();
require_once "../config.php";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

// Cek koneksi dan eksekusi query
$mapel = mysqli_query($koneksi, "SELECT * FROM tbl_mapel ORDER BY nama_mapel ASC");
if (!$mapel) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Mata Pelajaran</h1>
            <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Mapel</a>

            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-table me-1"></i>Daftar Mata Pelajaran</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Mapel</th>
                                <th>Nama Mapel</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($mapel)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['kode_mapel']) ?></td>
                                    <td><?= htmlspecialchars($row['nama_mapel']) ?></td>
                                    <td>
                                        <a href="edit.php?id=<?= $row['id_mapel'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="hapus.php?id=<?= $row['id_mapel'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once "../template/footer.php"; ?>
