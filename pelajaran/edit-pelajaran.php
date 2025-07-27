<?php
session_start();
if (!isset($_SESSION['ssLogin']) || $_SESSION['ssJabatan'] !== 'admin') {
    die("Akses ditolak.");
}

require_once '../config.php';

if (!isset($_GET['id'])) {
    header("Location: pelajaran.php?msg=notfound");
    exit();
}

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM tbl_pelajaran WHERE id = $id");
if (mysqli_num_rows($data) == 0) {
    header("Location: pelajaran.php?msg=notfound");
    exit();
}
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $pelajaran = htmlspecialchars($_POST['pelajaran']);
    $kelas = htmlspecialchars($_POST['kelas']);
    $id_guru = htmlspecialchars($_POST['guru']);

    $update = mysqli_query($koneksi, "UPDATE tbl_pelajaran SET pelajaran='$pelajaran', kelas='$kelas', id_guru='$id_guru' WHERE id=$id");
    header("Location: pelajaran.php?msg=" . ($update ? "updated" : "error"));
    exit();
}

$title = "Edit Pelajaran";
require_once '../template/header.php';
require_once '../template/navbar.php';
require_once '../template/sidebar.php';
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container py-4">
            <h2>Edit Data Pelajaran</h2>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Pelajaran</label>
                    <input type="text" class="form-control" name="pelajaran" value="<?= $row['pelajaran'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="kelas" class="form-select" required>
                        <?php
                        foreach ([7, 8, 9] as $k) {
                            echo "<option value='$k' " . ($row['kelas'] == $k ? 'selected' : '') . ">$k</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Guru Pengampu</label>
                    <select name="guru" class="form-select" required>
                        <?php
                        $guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru ORDER BY nama ASC");
                        while ($g = mysqli_fetch_assoc($guru)) {
                            $selected = $g['id'] == $row['id_guru'] ? 'selected' : '';
                            echo "<option value='{$g['id']}' $selected>{$g['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="update" class="btn btn-success"><i class="fa fa-save"></i> Simpan Perubahan</button>
                <a href="pelajaran.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </main>
</div>

<?php require_once '../template/footer.php'; ?>
