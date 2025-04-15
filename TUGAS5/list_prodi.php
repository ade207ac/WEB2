<?php
require_once 'dbkoneksi.php';

//definisikan query
$sql = "SELECT * FROM prodi ORDER BY id DESC";

//jalankan query
$rs = $dbh->query($sql);

//tampilkan hasil query
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Program Studi</title>
</head>
<body>
    <h1>Daftar Program Studi</h1>
    <a href="form_prodi.php">Tambah Prodi</a>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Prodi</th>
            <th>Kaprodi</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; foreach($rs as $row): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row->kode ?></td>
            <td><?= $row->nama ?></td>
            <td><?= $row->kaprodi ?></td>
            <td>
                <a href="form_prodi.php?id=<?= $row->id ?>">Edit</a>
                <form action="proses_prodi.php" method="POST" style="display:inline">
                    <input type="hidden" name="id_hapus" value="<?= $row->id ?>">
                    <button type="submit" name="proses" value="Hapus">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
