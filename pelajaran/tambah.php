<?php
require_once "../config.php";

if (isset($_POST['simpan'])) {
    $kode = htmlspecialchars($_POST['kode']);
    $nama = htmlspecialchars($_POST['nama']);

    $query = mysqli_query($koneksi, "INSERT INTO tbl_mapel (kode_mapel, nama_mapel) VALUES ('$kode', '$nama')");

    if ($query) {
        header("Location: index.php?msg=sukses");
    } else {
        echo "<div class='alert alert-danger'>Gagal menyimpan data!</div>";
    }
    exit;
}

require_once "../template/header.php";
require_once "../template/navbar.php";
require_once "../template/sidebar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Mata Pelajaran</h1>
            <form method="post">
                <div class="mb-3">
                    <label>Kode Mapel</label>
                    <input type="text" name="kode" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Nama Mapel</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </main>
</div>

<?php require_once "../template/footer.php"; ?>
