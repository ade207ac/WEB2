<?php
require_once 'dbkoneksi.php';

// Start session for flash messages
session_start();

// Function to redirect with flash message
function redirectWithMessage($location, $type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
    header('Location: ' . $location);
    exit;
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithMessage('list_prodi.php', 'error', 'Invalid request method');
}

try {
    // Validate required fields
    if (!isset($_POST['proses'])) {
        throw new Exception('No action specified');
    }

    $action = $_POST['proses'];
    $data = [];
    $sql = '';

    // Handle different actions
    switch ($action) {
        case 'Simpan':
            // Validate input
            $required = ['kode', 'nama', 'kaprodi'];
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    throw new Exception("Field $field is required");
                }
            }

            // Sanitize input
            $kode = htmlspecialchars(trim($_POST['kode']));
            $nama = htmlspecialchars(trim($_POST['nama']));
            $kaprodi = htmlspecialchars(trim($_POST['kaprodi']));

            // Check if program code already exists
            $check = $dbh->prepare("SELECT id FROM prodi WHERE kode = ?");
            $check->execute([$kode]);
            if ($check->fetch()) {
                throw new Exception('Program code already exists');
            }

            $sql = "INSERT INTO prodi (kode, nama, kaprodi) VALUES (?, ?, ?)";
            $data = [$kode, $nama, $kaprodi];
            $successMsg = 'Program added successfully';
            break;

        case 'Update':
            // Validate input
            $required = ['id_edit', 'kode', 'nama', 'kaprodi'];
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    throw new Exception("Field $field is required");
                }
            }

            $id = (int)$_POST['id_edit'];
            $kode = htmlspecialchars(trim($_POST['kode']));
            $nama = htmlspecialchars(trim($_POST['nama']));
            $kaprodi = htmlspecialchars(trim($_POST['kaprodi']));

            // Check if program exists
            $check = $dbh->prepare("SELECT id FROM prodi WHERE id = ?");
            $check->execute([$id]);
            if (!$check->fetch()) {
                throw new Exception('Program not found');
            }

            // Check if new code conflicts with others
            $check = $dbh->prepare("SELECT id FROM prodi WHERE kode = ? AND id != ?");
            $check->execute([$kode, $id]);
            if ($check->fetch()) {
                throw new Exception('Program code already used by another program');
            }

            $sql = "UPDATE prodi SET kode = ?, nama = ?, kaprodi = ? WHERE id = ?";
            $data = [$kode, $nama, $kaprodi, $id];
            $successMsg = 'Program updated successfully';
            break;

        case 'Hapus':
            // Validate input
            if (empty($_POST['id_hapus'])) {
                throw new Exception('No program ID specified');
            }

            $id = (int)$_POST['id_hapus'];

            // Check if program exists
            $check = $dbh->prepare("SELECT id FROM prodi WHERE id = ?");
            $check->execute([$id]);
            if (!$check->fetch()) {
                throw new Exception('Program not found');
            }

            // Check if program has students
            $check = $dbh->prepare("SELECT COUNT(*) FROM mahasiswa WHERE prodi_id = ?");
            $check->execute([$id]);
            if ($check->fetchColumn() > 0) {
                $_SESSION['delete_confirmation'] = [
                    'program_id' => $id,
                    'program_name' => $dbh->query("SELECT nama FROM prodi WHERE id = $id")->fetchColumn()
                ];
                redirectWithMessage('confirm_delete.php', 'warning', 
                    'This program has students. Confirm deletion?');
            }

            $sql = "DELETE FROM prodi WHERE id = ?";
            $data = [$id];
            $successMsg = 'Program deleted successfully';
            break;

        default:
            throw new Exception('Invalid action');
    }

    // Execute the query
    $stmt = $dbh->prepare($sql);
    if (!$stmt->execute($data)) {
        throw new Exception('Database operation failed');
    }

    // Update related data if needed
    if ($action === 'Hapus') {
        // Optionally handle student reassignment here
        // $dbh->exec("UPDATE mahasiswa SET prodi_id = NULL WHERE prodi_id = $id");
    }

    redirectWithMessage('list_prodi.php', 'success', $successMsg);

} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    redirectWithMessage('list_prodi.php', 'error', 'Database error occurred');
} catch (Exception $e) {
    redirectWithMessage('list_prodi.php', 'error', $e->getMessage());
}