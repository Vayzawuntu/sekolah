<?php
session_start();

if (!isset($_SESSION["ssLogin"])) {
    header("location:../auth/login.php");
    exit;
}

require_once "../config.php";

$title = "Tambah User - SMP PGRI 363 Pondok Petir";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

// Alert message
$msg = $_GET['msg'] ?? '';
$alert = match($msg) {
    'cancel'    => '<div class="alert alert-warning">Username sudah ada!</div>',
    'notimage'  => '<div class="alert alert-warning">File yang diupload bukan gambar!</div>',
    'oversize'  => '<div class="alert alert-warning">Ukuran gambar maksimal 1MB!</div>',
    'added'     => '<div class="alert alert-success">User berhasil ditambahkan!</div>',
    default     => '',
};
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah User</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Tambah User</li>
            </ol>

            <?= $alert ?>

            <form action="proses-user.php" method="POST" enctype="multipart/form-data">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user-plus me-1"></i> Form Tambah User
                        <button type="submit" name="simpan" class="btn btn-primary float-end ms-2">Simpan</button>
                        <button type="reset" class="btn btn-secondary float-end">Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Form input (kiri) -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" maxlength="20" required>
                                </div>
                                <div class="mb-3">
                                    <label>Nama</label>
                                    <input type="text" name="nama" class="form-control" maxlength="50" required>
                                </div>
                                <div class="mb-3">
                                    <label>Jabatan</label>
                                    <select name="jabatan" class="form-select" required>
                                        <option value="">-- Pilih Jabatan --</option>
                                        <option value="Admin">Admin</option>
                                        <option value="OrangTua">Orang Tua </option>
                                        <option value="Guru">Guru</option>
                                        <option value="Siswa">Siswa</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Foto (opsional)</label>
                                    <input type="file" name="image" class="form-control" onchange="previewImg(event)">
                                    <small class="text-muted">Format: JPG, JPEG, PNG. Max 1MB.</small>
                                </div>
                            </div>

                            <!-- Preview gambar (kanan) -->
                            <div class="col-md-4 text-center">
                                <label class="form-label">Preview Foto</label>
                                <div class="border rounded p-2">
                                    <img id="imgPreview" src="../asset/image/user.png" class="img-fluid rounded" alt="Preview" style="max-height: 250px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    // Preview gambar langsung
    function previewImg(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('imgPreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?php require_once "../template/footer.php"; ?>
