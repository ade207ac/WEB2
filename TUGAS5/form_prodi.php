<?php
require_once 'dbkoneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;
$prodi = null;

if ($id) {
    // Mode edit - ambil data prodi
    $sql = "SELECT * FROM prodi WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);
    $prodi = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Program Studi</title>
</head>
<body>
    <h1><?= $id ? 'Edit' : 'Tambah' ?> Program Studi</h1>
    <form action="proses_prodi.php" method="POST">
        <?php if ($id): ?>
            <input type="hidden" name="id_edit" value="<?= $id ?>">
        <?php endif; ?>
        
        <div>
            <label>Kode Prodi:</label>
            <input type="text" name="kode" value="<?= $prodi ? $prodi->kode : '' ?>" required>
        </div>
        
        <div>
            <label>Nama Prodi:</label>
            <input type="text" name="nama" value="<?= $prodi ? $prodi->nama : '' ?>" required>
        </div>
        
        <div>
            <label>Kaprodi:</label>
            <input type="text" name="kaprodi" value="<?= $prodi ? $prodi->kaprodi : '' ?>" required>
        </div>
        
        <button type="submit" name="proses" value="<?= $id ? 'Update' : 'Simpan' ?>">
            <?= $id ? 'Update' : 'Simpan' ?>
        </button>
        <a href="list_prodi.php">Kembali</a>
    </form>
</body>
</html>