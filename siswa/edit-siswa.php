<?php 
session_start();

// Hanya admin yang boleh mengakses
if (!isset($_SESSION['ssLogin']) || $_SESSION['ssJabatan'] !== 'admin') {
    die("Akses ditolak.");
}

require_once '../config.php';
$title = 'Update Siswa - SMP PGRI 363';
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

// Validasi NIS dari URL
if (!isset($_GET['nis'])) {
    header("Location: siswa.php?msg=notfound");
    exit();
}

$nis = htmlspecialchars($_GET['nis']);
$query = mysqli_query($koneksi, "SELECT * FROM tbl_siswa WHERE nis = '$nis'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: siswa.php?msg=notfound");
    exit();
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Update Siswa</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="siswa.php">Siswa</a></li>
                <li class="breadcrumb-item active">Update Siswa</li>
            </ol>

            <form action="proses-siswa.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="nis_lama" value="<?= htmlspecialchars($data['nis']) ?>">
                <input type="hidden" name="fotolama" value="<?= htmlspecialchars($data['foto']) ?>">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-pen-to-square"></i> Update Siswa</span>
                        <button type="submit" name="update" class="btn btn-primary float-end">
                            <i class="fa-solid fa-floppy-disk"></i> Update
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- FORM KIRI -->
                            <div class="col-8">
                                <!-- NIS -->
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">NIS</label>
                                    <label class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px;">
                                        <input type="text" name="nis" class="form-control border-bottom ps-2" required value="<?= htmlspecialchars($data['nis']) ?>">
                                    </div>
                                </div>

                                <!-- NAMA -->
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Nama</label>
                                    <label class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px;">
                                        <input type="text" name="nama" required class="form-control border-bottom ps-2" value="<?= htmlspecialchars($data['nama']) ?>">
                                    </div>
                                </div>

                                <!-- KELAS -->
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Kelas</label>
                                    <label class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px;">
                                        <select name="kelas" class="form-select border-0 border-bottom" required>
                                            <?php
                                            $kelasList = ["VII", "VIII", "IX"];
                                            foreach ($kelasList as $kls) {
                                                $selected = ($data['kelas'] == $kls) ? 'selected' : '';
                                                echo "<option value='$kls' $selected>$kls</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- ALAMAT -->
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Alamat</label>
                                    <label class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left: -50px;">
                                        <textarea name="alamat" cols="30" rows="3" class="form-control" required><?= htmlspecialchars($data['alamat']) ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- FORM KANAN -->
                            <div class="col-4 text-center px-5">
                                <?php
                                $fotoPath = (!empty($data['foto']) && file_exists("../asset/image/{$data['foto']}")) 
                                    ? "../asset/image/{$data['foto']}" 
                                    : "../asset/image/default.png";
                                ?>
                                <img src="<?= htmlspecialchars($fotoPath) ?>" alt="Foto Siswa" class="mb-3 rounded-circle" width="48%">
                                <input type="file" name="image" class="form-control form-control-sm mt-2">
                                <small class="text-secondary d-block mt-1">JPG, JPEG, PNG. Maks 1 MB</small>
                                <div class="small text-secondary">Ukuran disarankan persegi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<?php require_once "../template/footer.php"; ?>
