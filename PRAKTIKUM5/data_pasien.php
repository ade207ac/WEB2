<?php
require_once 'dbkoneksi.php';

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$where = '';
if (!empty($search)) {
    $where = " WHERE pasien.nama LIKE :search OR pasien.kode LIKE :search";
}

// Count total records for pagination
$sqlCount = "SELECT COUNT(*) as total FROM pasien $where";
$stmtCount = $dbh->prepare($sqlCount);
if (!empty($search)) {
    $stmtCount->bindValue(':search', "%$search%");
}
$stmtCount->execute();
$totalRecords = $stmtCount->fetch()['total'];
$totalPages = ceil($totalRecords / $limit);

// Get data with pagination and search
$sql = "SELECT pasien.*, kelurahan.nama as nama_kelurahan FROM pasien 
        LEFT JOIN kelurahan ON pasien.kelurahan_id = kelurahan.id
        $where 
        ORDER BY pasien.id DESC 
        LIMIT :limit OFFSET :offset";
$stmt = $dbh->prepare($sql);
if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%");
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$pasien = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">Data Pasien</h2>
        
        <!-- Search Form -->
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari pasien..." 
                       value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i> Cari
                </button>
                <a href="data_pasien.php" class="btn btn-outline-danger">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>
        
        <div class="d-flex justify-content-between mb-3">
            <a href="form_pasien.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pasien
            </a>
            <span class="badge bg-info text-dark">
                Total Data: <?= $totalRecords ?>
            </span>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Tempat/Tgl Lahir</th>
                        <th>Gender</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Kelurahan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pasien)): ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data ditemukan</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($pasien as $key => $row): ?>
                        <tr>
                            <td><?= $key + 1 + $offset ?></td>
                            <td><?= htmlspecialchars($row['kode']) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td>
                                <?= htmlspecialchars($row['tmp_lahir']) ?>, 
                                <?= date('d-m-Y', strtotime($row['tgl_lahir'])) ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= $row['gender'] == 'L' ? 'primary' : 'danger' ?>">
                                    <?= $row['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                </span>
                            </td>
                            <td>
                                <a href="mailto:<?= htmlspecialchars($row['email']) ?>">
                                    <?= htmlspecialchars($row['email']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($row['alamat']) ?></td>
                            <td><?= htmlspecialchars($row['nama_kelurahan']) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="form_pasien.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="proses_pasien.php?id=<?= $row['id'] ?>&proses=Hapus" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('Apakah yakin ingin menghapus pasien <?= htmlspecialchars($row['nama']) ?>?')"
                                       title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">
                        Previous
                    </a>
                </li>
                
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
                
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">
                        Next
                    </a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>