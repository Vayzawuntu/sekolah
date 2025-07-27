<?php
session_start();

if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../config.php';

// Cek role
$isAdmin = ($_SESSION['ssJabatan'] == 'admin');

// Proses Simpan (hanya untuk admin)
if ($isAdmin && isset($_POST['simpan'])) {
    $pelajaran = htmlspecialchars($_POST['pelajaran']);
    $kelas     = htmlspecialchars($_POST['kelas']);
    $id_guru   = htmlspecialchars($_POST['guru']);

    if ($pelajaran && $kelas && $id_guru) {
        $insert = mysqli_query($koneksi, "INSERT INTO tbl_pelajaran (pelajaran, kelas, id_guru) VALUES ('$pelajaran', '$kelas', '$id_guru')");
        header("Location: pelajaran.php?msg=" . ($insert ? 'added' : 'error'));
        exit();
    }
}

$title = "Mata Pelajaran - SMP PGRI 363";
require_once '../template/header.php';
require_once '../template/navbar.php';
require_once '../template/sidebar.php';

// Pagination dan Search
$limit = 5;
$hal = isset($_GET['hal']) ? (int)$_GET['hal'] : 1;
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$start = ($hal - 1) * $limit;

$where = "WHERE p.pelajaran LIKE '%$cari%' OR p.kelas LIKE '%$cari%'";
$query = "SELECT p.*, g.nama as nama_guru FROM tbl_pelajaran p LEFT JOIN tbl_guru g ON p.id_guru = g.id $where ORDER BY p.id DESC LIMIT $start, $limit";
$q = mysqli_query($koneksi, $query);

$total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tbl_pelajaran p $where"));
$pages = ceil($total / $limit);
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Mata Pelajaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Mata Pelajaran</li>
            </ol>

            <?php if (isset($_GET['msg'])):
                $msg = $_GET['msg'];
                $alertClass = 'success';
                $text = '';
                switch ($msg) {
                    case 'deleted': $text = 'Pelajaran berhasil dihapus.'; break;
                    case 'updated': $text = 'Pelajaran berhasil diubah.'; break;
                    case 'added':   $text = 'Pelajaran berhasil ditambahkan.'; break;
                    case 'error':   $alertClass = 'danger'; $text = 'Terjadi kesalahan.'; break;
                    case 'notfound':$alertClass = 'warning'; $text = 'Pelajaran tidak ditemukan.'; break;
                }
            ?>
                <div class="alert alert-<?= $alertClass ?> alert-dismissible fade show" role="alert">
                    <?= $text ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- Form Tambah Pelajaran (hanya admin) -->
                <?php if ($isAdmin): ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-plus"></i> Tambah Pelajaran
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label for="pelajaran" class="form-label">Nama Pelajaran</label>
                                    <input type="text" class="form-control" id="pelajaran" name="pelajaran" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <select name="kelas" id="kelas" class="form-select" required>
                                        <option value="" selected disabled>-- Pilih Kelas --</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="guru" class="form-label">Guru Pengampu</label>
                                    <select name="guru" id="guru" class="form-select" required>
                                        <option value="" selected disabled>-- Pilih Guru --</option>
                                        <?php
                                        $qGuru = mysqli_query($koneksi, "SELECT * FROM tbl_guru ORDER BY nama ASC");
                                        while ($g = mysqli_fetch_assoc($qGuru)) {
                                            echo "<option value='{$g['id']}'>{$g['nama']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Tabel Pelajaran -->
                <div class="<?= $isAdmin ? 'col-md-8' : 'col-md-12' ?>">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-list"></i> Data Pelajaran
                        </div>
                        <div class="card-body">
                            <form method="get" class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="cari" class="form-control" placeholder="keyword" value="<?= htmlspecialchars($cari) ?>">
                                    <button class="btn btn-secondary" type="submit">🔍</button>
                                </div>
                            </form>

                            <table class="table table-bordered table-hover text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Pelajaran</th>
                                        <th>Kelas</th>
                                        <th>Guru</th>
                                        <?php if ($isAdmin): ?>
                                        <th>Operasi</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = $start + 1; while ($row = mysqli_fetch_assoc($q)): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($row['pelajaran']) ?></td>
                                            <td><?= htmlspecialchars($row['kelas']) ?></td>
                                            <td><?= htmlspecialchars($row['nama_guru']) ?></td>
                                            <?php if ($isAdmin): ?>
                                            <td>
                                                <a href="edit-pelajaran.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️</a>
                                                <a href="hapus-pelajaran.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">🗑️</a>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endwhile; ?>
                                    <?php if (mysqli_num_rows($q) === 0): ?>
                                        <tr>
                                            <td colspan="<?= $isAdmin ? '5' : '4' ?>">Belum ada data.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <?php if ($pages > 1): ?>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?= $hal == 1 ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?hal=<?= $hal - 1 ?>&cari=<?= $cari ?>">«</a>
                                        </li>
                                        <?php for ($i = 1; $i <= $pages; $i++): ?>
                                            <li class="page-item <?= $hal == $i ? 'active' : '' ?>">
                                                <a class="page-link" href="?hal=<?= $i ?>&cari=<?= $cari ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?= $hal == $pages ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?hal=<?= $hal + 1 ?>&cari=<?= $cari ?>">»</a>
                                        </li>
                                    </ul>
                                </nav>
                                <div class="text-end small">Jumlah Data: <?= $total ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once '../template/footer.php'; ?>
