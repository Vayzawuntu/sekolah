<?php
session_start();

// Cek login & role admin
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION['ssJabatan'] !== 'admin') {
    die("Akses ditolak. Hanya admin yang bisa menambahkan data.");
}

require_once '../config.php';

$title = "Tambah Siswa - SMP PGRI 363";
require_once '../template/header.php';
require_once '../template/navbar.php';
require_once '../template/sidebar.php';

// Auto-generate NIS
$queryNis = mysqli_query($koneksi, "SELECT MAX(nis) AS maxnis FROM tbl_siswa");
$data = mysqli_fetch_array($queryNis);
$maxnis = $data["maxnis"];

$noUrut = (int) substr($maxnis, 3, 3);
$noUrut++;
$maxnis = "NIS" . sprintf("%03s", $noUrut);
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Siswa</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="siswa.php">Siswa</a></li>
                <li class="breadcrumb-item active">Tambah Siswa</li>
            </ol>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-warning">
                    <?php
                    switch ($_GET['msg']) {
                        case 'notimage': echo "File harus berupa gambar JPG, JPEG, atau PNG."; break;
                        case 'oversize': echo "Ukuran file terlalu besar. Maksimal 1 MB."; break;
                        case 'uploaderror': echo "Gagal upload gambar."; break;
                        case 'movefailed': echo "Gagal menyimpan gambar ke server."; break;
                        default: echo "Terjadi kesalahan tidak dikenal."; break;
                    }
                    ?>
                </div>
            <?php endif; ?>

            <form action="proses-siswa.php" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-square-plus"></i> Tambah Siswa</span>
                        <button type="submit" name="simpan" class="btn btn-primary float-end">Simpan</button>
                        <button type="reset" class="btn btn-danger float-end me-1">
                            <i class="fa-solid fa-xmark"></i> Reset
                        </button>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-8">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">NIS</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nis" readonly class="form-control-plaintext border-bottom ps-2" value="<?= $maxnis ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nama" class="form-control border-0 border-bottom ps-2" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Kelas</label>
                                <div class="col-sm-10">
                                    <select name="kelas" class="form-select border-0 border-bottom" required>
                                        <option selected disabled>---Pilih Kelas---</option>
                                        <option value="VII">VII</option>
                                        <option value="VIII">VIII</option>
                                        <option value="IX">IX</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea name="alamat" rows="3" class="form-control" required placeholder="Alamat siswa"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <img src="../asset/image/default.png" alt="Preview" class="mb-3" width="40%">
                            <input type="file" name="image" class="form-control form-control-sm">
                            <small class="text-secondary">JPG, JPEG, PNG. Maks 1 MB.</small><br>
                            <small class="text-secondary">Ukuran disarankan persegi.</small>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<?php require_once "../template/footer.php"; ?>
