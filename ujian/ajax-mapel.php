<?php
require_once '../config.php';

if (isset($_GET['kelas'])) {
    $kelas = mysqli_real_escape_string($koneksi, $_GET['kelas']);
    $no = 1;

    // Ambil semua pelajaran yang sesuai kelas
    $queryPelajaran = mysqli_query($koneksi, "SELECT * FROM tbl_pelajaran WHERE kelas = '$kelas' ORDER BY pelajaran ASC");

    if (mysqli_num_rows($queryPelajaran) > 0) {
        while ($data = mysqli_fetch_array($queryPelajaran)) {
            echo "<tr>
                    <td align='center'>{$no}</td>
                    <td>
                        <input type='text' name='mapel[]' value='{$data['pelajaran']}' class='form-control-plaintext' readonly>
                    </td>
                    <td>
                        <input type='text' name='kelas_mapel[]' value='{$data['kelas']}' class='form-control-plaintext' readonly>
                    </td>
                    <td>
                        <input type='number' name='nilai[]' value='0' min='0' max='100' step='5' 
                               class='form-control nilai text-center'>
                    </td>
                </tr>";
            $no++;
        }
    } else {
        echo "<tr><td colspan='4' class='text-center text-danger'>Tidak ada mata pelajaran untuk kelas {$kelas}!</td></tr>";
    }
} else {
    echo "<tr><td colspan='4' class='text-center text-danger'>Kelas belum dipilih!</td></tr>";
}
