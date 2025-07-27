<?php
session_start();

if (!isset($_SESSION["ssLogin"])) {
    header("location:../auth/login.php");
    exit;
}


require_once '../config.php';
$title = "Tambah Guru - SMP PGRI 363";
require_once '../template/header.php';
require_once '../template/navbar.php';
require_once '../template/sidebar.php';

$msg = $_GET['msg'] ?? '';
$alert = '';

switch ($msg) {
    case 'cancel':
        $alert = '<div class="alert alert-warning">Tambah Guru gagal, NIP sudah ada...</div>';
        break;
    case 'notimage':
        $alert = '<div class="alert alert-warning">Tambah guru gagal! File bukan gambar yang valid.</div>';
        break;
    case 'oversize':
        $alert = '<div class="alert alert-warning">Ukuran gambar maksimal 1MB!</div>';
        break;
    case 'added':
        $alert = '<div class="alert alert-success">Guru berhasil ditambahkan!</div>';
        break;
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Guru</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="guru.php">Guru</a></li>
                <li class="breadcrumb-item active">Tambah Guru</li>
            </ol>

            <?php if ($msg !== ''): ?>
                <?= $alert ?>
            <?php endif; ?>

            <form action="proses-tambah-guru.php" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="h5"><i class="fa-solid fa-square-plus"></i> Tambah Guru</span>
                        <div>
                            <button type="reset" class="btn btn-danger me-1"><i class="fa-solid fa-xmark"></i> Reset</button>
                            <button type="submit" name="simpan" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                        </div>
                    </div>

                    <div class="card-body row">
                        <div class="col-md-8">
                            <div class="mb-3 row">
                                <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                                <div class="col-sm-10">
                                    <input type="text" id="nip" name="nip" pattern="[0-9]{18,}" title="Minimal 18 angka" class="form-control border-0 border-bottom" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" id="nama" name="nama" class="form-control border-0 border-bottom" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="telpon" class="col-sm-2 col-form-label">Telpon</label>
                                <div class="col-sm-10">
                                    <input type="tel" id="telpon" name="telpon" pattern="[0-9]{5,}" title="Minimal 5 angka" class="form-control border-0 border-bottom" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="agama" class="col-sm-2 col-form-label">Agama</label>
                                <div class="col-sm-10">
                                    <select name="agama" id="agama" class="form-select border-0 border-bottom" required>
                                        <option value="">--- Pilih Agama ---</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katholik">Katholik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea name="alamat" id="alamat" rows="3" class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 text-center">
                            <img src="../asset/image/default.png" class="mb-3" width="80%" alt="Foto Default">
                            <input type="file" name="image" class="form-control form-control-sm mb-2" accept=".jpg,.jpeg,.png">
                            <small class="text-secondary d-block">Pilih foto PNG, JPG, atau JPEG maksimal 1MB</small>
                            <small class="text-secondary d-block">Rasio gambar sebaiknya 1:1</small>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<?php require_once '../template/footer.php'; ?>
