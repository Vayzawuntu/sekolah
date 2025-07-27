<?php
session_start();

if (!isset($_SESSION["ssLogin"])) {
    header("location:../auth/login.php");
    exit;
}


require_once '../config.php';

$id = intval($_GET['id'] ?? 0);

// Ambil data guru
$query = mysqli_query($koneksi, "SELECT * FROM tbl_guru WHERE id = $id");
if (mysqli_num_rows($query) == 0) {
    header("Location: guru.php?msg=notfound");
    exit();
}

$data = mysqli_fetch_assoc($query);

// Proses update jika form disubmit
if (isset($_POST['submit'])) {
    $nip     = htmlspecialchars($_POST['nip']);
    $nama    = htmlspecialchars($_POST['nama']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $agama   = htmlspecialchars($_POST['agama']);
    $alamat  = htmlspecialchars($_POST['alamat']);
    $fotoLama = $data['foto'];

    // Handle upload foto baru jika ada
    if ($_FILES['foto']['name']) {
        $fotoBaru = uniqid() . "_" . $_FILES['foto']['name'];
        $tmp_foto = $_FILES['foto']['tmp_name'];
        $upload = move_uploaded_file($tmp_foto, "../asset/image/$fotoBaru");

        // Hapus foto lama (jika bukan default)
        if ($fotoLama && $fotoLama != 'user.png' && file_exists("../asset/image/$fotoLama")) {
            unlink("../asset/image/$fotoLama");
        }
    } else {
        $fotoBaru = $fotoLama;
    }

    $update = mysqli_query($koneksi, "UPDATE tbl_guru SET
        nip = '$nip',
        nama = '$nama',
        telepon = '$telepon',
        agama = '$agama',
        alamat = '$alamat',
        foto = '$fotoBaru'
        WHERE id = $id
    ");

    if ($update) {
        header("Location: guru.php?msg=updated");
        exit();
    } else {
        echo "<script>alert('Gagal update data');</script>";
    }
}
?>

<?php
$title = "Edit Guru - SMP PGRI 363";
require_once '../template/header.php';
require_once '../template/navbar.php';
require_once '../template/sidebar.php';
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Data Guru</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="guru.php">Guru</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-pen"></i> Form Edit Guru
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>NIP</label>
                            <input type="text" name="nip" class="form-control" value="<?= $data['nip'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="<?= $data['telepon'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Agama</label>
                            <select name="agama" class="form-control" required>
                                <option value="">-- Pilih Agama --</option>
                                <?php
                                $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'];
                                foreach ($agamaList as $agama) {
                                    $selected = ($agama == $data['agama']) ? 'selected' : '';
                                    echo "<option value='$agama' $selected>$agama</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" required><?= $data['alamat'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Foto</label><br>
                            <img src="../asset/image/<?= $data['foto'] ?>" width="80" class="mb-2"><br>
                            <input type="file" name="foto" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="submit" class="btn btn-success">
                                <i class="fa-solid fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="guru.php" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

<?php require_once '../template/footer.php'; ?>
