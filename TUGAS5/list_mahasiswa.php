<?php
require_once 'dbkoneksi.php';

//definisi query
$sql = "SELECT m.*, p.nama as nama_prodi 
        FROM mahasiswa m 
        LEFT JOIN prodi p ON m.prodi_id = p.id 
        ORDER BY m.thn_masuk DESC";

//jalankan query
$rs = $dbh->query($sql);

//tampilkan hasil query
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
</head>
<body>
    <h1>Daftar Mahasiswa</h1>
    <table border="1">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th>Tahun Masuk</th>
        </tr>
        <?php foreach($rs as $row): ?>
        <tr>
            <td><?= $row->nim ?></td>
            <td><?= $row->nama ?></td>
            <td><?= $row->nama_prodi ?></td>
            <td><?= $row->thn_masuk ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>