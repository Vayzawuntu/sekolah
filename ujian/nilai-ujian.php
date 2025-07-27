<?php  
session_start();
if (!isset($_SESSION['ssLogin'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once '../config.php';
$title = "Nilai Ujian - SMP PGRI 363";
require_once '../template/header.php';
require_once '../template/navbar.php';
require_once '../template/sidebar.php';



?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Nilai Ujian</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="ujian.php">Ujian</a></li>
                <li class="breadcrumb-item active">Nilai Ujian</li>
            </ol>

            <!-- Awal Form -->
            <form method="post" id="formNilaiUjian" action="simpan-nilai.php">
                <div class="row">
                    <!-- Form Data Peserta -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa-solid fa-plus"></i> Data Peserta Ujian
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">No. Ujian</label>
                                    <input type="text" name="noUjian" class="form-control bg-light" value="UTS-001" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Ujian</label>
                                    <input type="date" name="tanggal" class="form-control bg-light" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pilih Siswa</label>
                                    <select name="nis" id="nis" class="form-select" required>
                                        <option value="" selected disabled>-- Pilih Siswa --</option>
                                        <?php
                                        $querySiswa = mysqli_query($koneksi, "SELECT * FROM tbl_siswa ORDER BY nama ASC");
                                        while ($data = mysqli_fetch_array($querySiswa)) {
                                            echo "<option value='{$data['nis']}'>{$data['nis']} | {$data['nama']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kelas</label>
                                    <select name="kelas" id="kelas" class="form-select" required>
                                        <option value="" selected disabled>-- Pilih Kelas --</option>
                                        <option value="7">Kelas 7</option>
                                        <option value="8">Kelas 8</option>
                                        <option value="9">Kelas 9</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Syarat Kelulusan -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa-solid fa-circle-info"></i> Syarat Kelulusan
                            </div>
                            <div class="card-body">
                                <ul class="ps-3">
                                    <li><small>Nilai minimal tiap mata pelajaran tidak boleh di bawah <strong>50</strong></small></li>
                                    <li><small>Nilai rata-rata mata pelajaran tidak boleh di bawah <strong>60</strong></small></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="proses-ujian.php" method="POST"

                <!-- Tabel Nilai dan Statistik -->
                <div class="row">
                    <!-- Input Nilai -->
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between">
                                <span><i class="fa-solid fa-list"></i> Input Nilai Ujian</span>
                                <div>
                                    <button type="reset" class="btn btn-sm btn-danger"><i class="fa-solid fa-xmark"></i> Reset</button>
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Kelas</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kejuruan">
                                        <tr>
                                            <td colspan="4">Silakan pilih siswa dan kelas terlebih dahulu.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik -->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa-solid fa-chart-column"></i> Statistik Nilai
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Sum</strong> <input type="text" name="total_nilai" id="total_nilai" class="form-control form-control-sm w-25 text-end" readonly>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Min</strong> <input type="text" name="nilai_terendah" id="nilai_terendah" class="form-control form-control-sm w-25 text-end" readonly>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Max</strong> <input type="text" name="nilai_tertinggi" id="nilai_tertinggi" class="form-control form-control-sm w-25 text-end" readonly>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Avg</strong> <input type="text" name="rata2" id="rata2" class="form-control form-control-sm w-25 text-end" readonly>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </form> <!-- Akhir Form -->
        </div>
    </main>
</div>

<?php require_once '../template/footer.php'; ?>

<!-- SCRIPT -->
<script>
    const kelas = document.getElementById('kelas');
    const mapelKejuruan = document.getElementById('kejuruan');

    kelas.addEventListener('change', function () {
        const selectedKelas = this.value;

        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function () {
            if (ajax.readyState === 4 && ajax.status === 200) {
                mapelKejuruan.innerHTML = ajax.responseText;
                fnHitung(); // Hitung setelah data dimuat
            }
        };

        ajax.open('GET', 'ajax-mapel.php?kelas=' + selectedKelas, true);
        ajax.send();
    });

    // Fungsi menghitung statistik nilai
    function fnHitung() {
        const nilaiUjian = document.getElementsByClassName('nilai');
        let totalNilai = 0;
        let listNilai = [];

        for (let i = 0; i < nilaiUjian.length; i++) {
            const nilai = parseInt(nilaiUjian[i].value) || 0;
            listNilai.push(nilai);
            totalNilai += nilai;
        }

        if (listNilai.length > 0) {
            listNilai.sort((a, b) => a - b);
            document.getElementById('total_nilai').value = totalNilai;
            document.getElementById('nilai_terendah').value = listNilai[0];
            document.getElementById('nilai_tertinggi').value = listNilai[listNilai.length - 1];
            document.getElementById('rata2').value = Math.round(totalNilai / listNilai.length);
        } else {
            document.getElementById('total_nilai').value = 0;
            document.getElementById('nilai_terendah').value = 0;
            document.getElementById('nilai_tertinggi').value = 0;
            document.getElementById('rata2').value = 0;
        }
    }

    // Event input global untuk nilai
    document.addEventListener("input", function (e) {
        if (e.target.classList.contains("nilai")) {
            fnHitung();
        }
    });
</script>
