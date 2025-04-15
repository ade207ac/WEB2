<?php
require_once 'dbkoneksi.php';

// Set header for JSON response (we'll use this for AJAX later if needed)
header('Content-Type: application/json');

try {
    // Tangkap data dari form
    $_kode = $_POST['kode'] ?? '';
    $_nama = $_POST['nama'] ?? '';
    $_tmp_lahir = $_POST['tmp_lahir'] ?? '';
    $_tgl_lahir = $_POST['tgl_lahir'] ?? '';
    $_gender = $_POST['gender'] ?? '';
    $_email = $_POST['email'] ?? '';
    $_alamat = $_POST['alamat'] ?? '';
    $_kelurahan_id = $_POST['kelurahan_id'] ?? '';
    
    $_proses = $_POST['proses'] ?? '';

    // Basic validation
    if (empty($_kode) || empty($_nama) || empty($_tmp_lahir) || empty($_tgl_lahir) || empty($_gender) || empty($_kelurahan_id)) {
        throw new Exception("Semua field wajib diisi!");
    }

    if ($_proses == "Simpan") {
        // Check if kode already exists
        $checkSql = "SELECT COUNT(*) FROM pasien WHERE kode = ?";
        $checkStmt = $dbh->prepare($checkSql);
        $checkStmt->execute([$_kode]);
        if ($checkStmt->fetchColumn() > 0) {
            throw new Exception("Kode pasien sudah digunakan!");
        }

        // Data untuk insert
        $data = [$_kode, $_nama, $_tmp_lahir, $_tgl_lahir, $_gender, $_email, $_alamat, $_kelurahan_id];
        
        $sql = "INSERT INTO pasien (kode, nama, tmp_lahir, tgl_lahir, gender, email, alamat, kelurahan_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        
        $message = "Data pasien berhasil ditambahkan!";
    } elseif ($_proses == "Update") {
        // Data untuk update
        $_id = $_POST['id'];
        
        // Check if kode already exists (excluding current record)
        $checkSql = "SELECT COUNT(*) FROM pasien WHERE kode = ? AND id != ?";
        $checkStmt = $dbh->prepare($checkSql);
        $checkStmt->execute([$_kode, $_id]);
        if ($checkStmt->fetchColumn() > 0) {
            throw new Exception("Kode pasien sudah digunakan!");
        }

        $data = [$_kode, $_nama, $_tmp_lahir, $_tgl_lahir, $_gender, $_email, $_alamat, $_kelurahan_id, $_id];
        
        $sql = "UPDATE pasien SET kode=?, nama=?, tmp_lahir=?, tgl_lahir=?, gender=?, 
                email=?, alamat=?, kelurahan_id=? WHERE id=?";
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        
        $message = "Data pasien berhasil diperbarui!";
    } elseif (isset($_GET['proses']) && $_GET['proses'] == 'Hapus') {
        // Proses hapus
        $_id = $_GET['id'];
        
        // Check if pasien has related records in periksa table
        $checkSql = "SELECT COUNT(*) FROM periksa WHERE pasien_id = ?";
        $checkStmt = $dbh->prepare($checkSql);
        $checkStmt->execute([$_id]);
        if ($checkStmt->fetchColumn() > 0) {
            throw new Exception("Pasien tidak dapat dihapus karena memiliki data pemeriksaan terkait!");
        }

        $sql = "DELETE FROM pasien WHERE id=?";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$_id]);
        
        $message = "Data pasien berhasil dihapus!";
    } else {
        throw new Exception("Aksi tidak valid!");
    }

    // Set session flash message
    session_start();
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = 'success';
    
    // Redirect ke halaman data pasien
    header('Location: data_pasien.php');
    exit();

} catch (PDOException $e) {
    // Database error
    session_start();
    $_SESSION['flash_message'] = "Terjadi kesalahan database: " . $e->getMessage();
    $_SESSION['flash_type'] = 'danger';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'data_pasien.php'));
    exit();
} catch (Exception $e) {
    // Other errors
    session_start();
    $_SESSION['flash_message'] = $e->getMessage();
    $_SESSION['flash_type'] = 'danger';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'data_pasien.php'));
    exit();
}
?>