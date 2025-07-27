<?php
session_start();

if (!isset($_SESSION["ssLogin"])) {
    header("location:../auth/login.php");
    exit;
}

require_once "../config.php";

$title = "Profil Sekolah - SMP PGRI 363 Pondok Petir";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

// Ambil pesan jika ada
$msg = $_GET['msg'] ?? '';
$alert = '';

if ($msg == 'notimage') {
    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert"> 
        <i class="fa-solid fa-triangle-exclamation"></i> Gagal, file bukan gambar yang valid.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
} elseif ($msg == 'oversize') {
    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert"> 
        <i class="fa-solid fa-triangle-exclamation"></i> Gagal, ukuran gambar maksimal 1 MB.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
} elseif ($msg == 'updated') {
    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
        <i class="fa-solid fa-circle-check"></i> Data berhasil diperbarui.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

$sekolah = mysqli_query($koneksi, "SELECT * FROM tbl_sekolah WHERE id = 1");
$data = mysqli_fetch_assoc($sekolah);
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Profil Sekolah</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Profil Sekolah</li>
            </ol>

            <?= $alert ?>

            <form action="proses-sekolah.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <div class="card">
                    <div class="card-header">
                        <span class="h5"><i class="fa-regular fa-pen-to-square"></i> Data Sekolah</span>
                        <button type="submit" name="simpan" class="btn btn-primary float-end">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 text-center px-5">
                                <input type="hidden" name="gbrLama" value="<?= $data['gambar'] ?>">
                                <img src="../asset/image/<?= $data['gambar'] ?>" alt="gambar sekolah" class="mb-3" width="100%">
                                <input type="file" name="image" class="form-control form-control-sm">
                                <small class="text-secondary">PNG, JPG, JPEG | Max 1 MB</small>
                            </div>
                            <div class="col-8">
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama" value="<?= $data['nama'] ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" value="<?= $data['email'] ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <select name="status" class="form-select" required>
                                            <?php
                                            $status = ['Negeri', 'Swasta'];
                                            foreach ($status as $stt) {
                                                $sel = $data['status'] == $stt ? 'selected' : '';
                                                echo "<option value=\"$stt\" $sel>$stt</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Akreditasi</label>
                                    <div class="col-sm-10">
                                        <select name="akreditasi" class="form-select" required>
                                            <?php
                                            $akreditasi = ['A', 'B', 'C', 'D'];
                                            foreach ($akreditasi as $akre) {
                                                $sel = $data['akreditasi'] == $akre ? 'selected' : '';
                                                echo "<option value=\"$akre\" $sel>$akre</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea name="alamat" rows="3" class="form-control" required><?= $data['alamat'] ?></textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Visi dan Misi</label>
                                    <div class="col-sm-10">
                                        <textarea name="visimisi" rows="3" class="form-control" required><?= $data['visimisi'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
<?php require_once "../template/footer.php"; ?>
