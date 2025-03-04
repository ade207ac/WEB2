<?php
$nama = isset($_POST['nama']) ? $_POST['nama'] : "Tidak Diketahui";
$matkul = isset($_POST['matkul']) ? $_POST['matkul'] : "Tidak Diketahui";
$uts = isset($_POST['uts']) ? $_POST['uts'] : 0;
$uas = isset($_POST['uas']) ? $_POST['uas'] : 0;
$tugas = isset($_POST['tugas']) ? $_POST['tugas'] : 0;

$nilai_total = (0.3 * $uts) + (0.35 * $uas) + (0.35 * $tugas);

$status = ($nilai_total > 60) ? "Lulus" : "Tidak Lulus";

if ($nilai_total >= 0 && $nilai_total <= 40) {
    $grade = "E";
} elseif ($nilai_total >= 45 && $nilai_total <= 60) {
    $grade = "D";
} elseif ($nilai_total >= 59 && $nilai_total <= 69) {
    $grade = "C";
} elseif ($nilai_total >= 75 && $nilai_total <= 85) {
    $grade = "B";
} elseif ($nilai_total >= 85 && $nilai_total <= 100) {
    $grade = "A";
} else {
    $grade = "I"; 
}

switch ($grade) {
    case "E":
        $predikat = "Kurang banget";
        break;
    case "D":
        $predikat = "Kurang";
        break;
    case "C":
        $predikat = "Cukup";
        break;
    case "B":
        $predikat = "bagus";
        break;
    case "A":
        $predikat = "Sangat bagus";
        break;
    default:
        $predikat = "Tidak Ada";
        break;
}

echo "<h2>Hasil Perhitungan Nilai</h2>";
echo "Nama Mahasiswa: $nama <br>";
echo "Mata Kuliah: $matkul <br>";
echo "Nilai Total: $nilai_total <br>";
echo "Status: $status <br>";
echo "Grade: $grade <br>";
echo "Predikat: $predikat <br>";
?>
