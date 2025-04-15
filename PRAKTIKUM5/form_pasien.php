<?php
require_once 'dbkoneksi.php';

// Ambil data kelurahan untuk dropdown
$sqlKelurahan = "SELECT * FROM kelurahan ORDER BY nama";
$stmtKelurahan = $dbh->prepare($sqlKelurahan);
$stmtKelurahan->execute();
$kelurahan = $stmtKelurahan->fetchAll();

// Cek apakah edit data
$_id = isset($_GET['id']) ? $_GET['id'] : null;
$row = [
    'kode' => '',
    'nama' => '',
    'tmp_lahir' => '',
    'tgl_lahir' => '',
    'gender' => '',
    'email' => '',
    'alamat' => '',
    'kelurahan_id' => ''
];
$title = "Tambah Pasien";
$tombol = "Simpan";

if ($_id) {
    $sql = "SELECT * FROM pasien WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$_id]);
    $row = $stmt->fetch();
    $title = "Edit Pasien";
    $tombol = "Update";
}

// Get today's date for max date in birthdate
$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="card-title mb-0"><?= $title ?></h2>
            </div>
            <div class="card-body">
                <form method="POST" action="proses_pasien.php" id="pasienForm">
                    <?php if ($_id): ?>
                        <input type="hidden" name="id" value="<?= $_id ?>">
                    <?php endif; ?>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="kode" class="form-label">Kode Pasien</label>
                            <input type="text" class="form-control" id="kode" name="kode" 
                                   value="<?= htmlspecialchars($row['kode']) ?>" required
                                   pattern="[A-Za-z0-9]{6,10}" title="6-10 karakter alfanumerik">
                            <div class="form-text">Kode unik pasien (6-10 karakter)</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" 
                                   value="<?= htmlspecialchars($row['nama']) ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="tmp_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir" 
                                   value="<?= htmlspecialchars($row['tmp_lahir']) ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" 
                                   value="<?= htmlspecialchars($row['tgl_lahir']) ?>" required
                                   max="<?= $today ?>">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="genderL" 
                                           value="L" <?= ($row['gender'] == 'L') ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="genderL">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="genderP" 
                                           value="P" <?= ($row['gender'] == 'P') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="genderP">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($row['email']) ?>">
                        </div>
                        
                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"><?= htmlspecialchars($row['alamat']) ?></textarea>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="kelurahan_id" class="form-label">Kelurahan</label>
                            <select class="form-select" id="kelurahan_id" name="kelurahan_id" required>
                                <option value="">Pilih Kelurahan</option>
                                <?php foreach($kelurahan as $k): ?>
                                    <option value="<?= $k['id'] ?>" 
                                        <?= ($row['kelurahan_id'] == $k['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($k['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4 d-flex justify-content-between">
                        <button type="submit" name="proses" value="<?= $tombol ?>" class="btn btn-primary">
                            <i class="bi bi-save"></i> <?= $tombol ?>
                        </button>
                        <a href="data_pasien.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Client-side validation
        document.getElementById('pasienForm').addEventListener('submit', function(e) {
            const tglLahir = new Date(document.getElementById('tgl_lahir').value);
            const today = new Date();
            
            if (tglLahir > today) {
                alert('Tanggal lahir tidak boleh lebih dari hari ini');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>