<?php
require_once 'nilai_mahasiswa.php';

session_start();

if (!isset($_SESSION['data_mhs'])) {
    $_SESSION['data_mhs'] = [];
}

$data_mhs = &$_SESSION['data_mhs'];

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $matakuliah = $_POST['matakuliah'];
    $nilai_uts = (int)$_POST['nilai_uts'];
    $nilai_uas = (int)$_POST['nilai_uas'];
    $nilai_tugas = (int)$_POST['nilai_tugas'];

    $data_mhs[] = new NilaiMahasiswa($nama, $matakuliah, $nilai_uts, $nilai_uas, $nilai_tugas);
}
?>

<h3>Input Data Mahasiswa</h3>

<form action="" method="post">
    <label for="nama">Nama</label>
    <input type="text" name="nama" id="nama" required><br><br>
    <label for="matakuliah">Mata Kuliah</label>
    <input type="text" name="matakuliah" id="matakuliah" required><br><br>
    <label for="nilai_uts">UTS</label>
    <input type="number" name="nilai_uts" id="nilai_uts" required><br><br>
    <label for="nilai_uas">UAS</label>
    <input type="number" name="nilai_uas" id="nilai_uas" required><br><br>
    <label for="nilai_tugas">Tugas</label>
    <input type="number" name="nilai_tugas" id="nilai_tugas" required><br><br>
    <input type="submit" value="Simpan">
</form>

<h3>Daftar Nilai Mahasiswa</h3>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>no</th>
            <th>Nama</th>
            <th>Mata Kuliah</th>
            <th>Nilai UTS</th>
            <th>Nilai UAS</th>
            <th>Nilai Tugas</th>
            <th>Nilai Akhir</th>
            <th>Kelulusan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1;
        foreach ($data_mhs as $mhs) {
            echo "<tr>";
            echo "<td>" . $nomor . "</td>";
            echo "<td>" . $mhs->nama . "</td>";
            echo "<td>" . $mhs->matakuliah . "</td>";
            echo "<td>" . $mhs->nilai_uts . "</td>";
            echo "<td>" . $mhs->nilai_uas . "</td>";
            echo "<td>" . $mhs->nilai_tugas . "</td>";
            echo "<td>" . number_format($mhs->GetNA(), 2) . "</td>";
            echo "<td>" . $mhs->kelulusan() . "</td></tr>";
            $nomor++;
        }
        ?>
    </tbody>
</table>