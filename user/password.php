<?php 
session_start();

// Debugging: tampilkan semua error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek apakah user sudah login
if (!isset($_SESSION["ssLogin"])) {
    header("location: ../auth/login.php");
    exit;
}

require_once "../config.php";

$title = "Ganti Password - SMP PGRI 363";
require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$alert = "";

if ($msg == 'updated') {
    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check"></i> Ganti Password berhasil..
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
} elseif ($msg == 'err1') {
    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-xmark"></i> Ganti Password gagal, konfirmasi password tidak sama.. 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
} elseif ($msg == 'err2') {
    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-xmark"></i> Ganti Password gagal, password lama tidak cocok..
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Password</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item active">Ganti Password</li>
            </ol>

            <!-- Tampilkan alert jika ada -->
            <?php if ($msg !== '') echo $alert; ?>

            <form action="proses-password.php" method="POST">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-pen-to-square"></i> Ganti Password</span>
                        <button type="submit" name="simpan" class="btn btn-primary float-end">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan
                        </button>
                        <button type="reset" name="reset" class="btn btn-danger float-end me-1">
                            <i class="fa-solid fa-xmark"></i> Reset
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-7">
                                <label for="curPass" class="form-label">Password Lama</label>
                                <input type="password" class="form-control" id="curPass"
                                    name="curPass" placeholder="Masukkan password anda saat ini" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-7">
                                <label for="newPass" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="newPass"
                                    name="newPass" minlength="4" maxlength="20"
                                    placeholder="Masukkan password baru anda" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-7">
                                <label for="confPass" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="confPass"
                                    name="confPass" placeholder="Ulangi password baru anda" required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </main>
</div>

<?php require_once "../template/footer.php"; ?>
