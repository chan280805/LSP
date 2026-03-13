<?php
session_start();
require '../config/database.php';
require '../models/Contact.php';

use Models\Contact;

if(!isset($_SESSION['user'])) { 
    header("Location: ../index.php"); 
    exit(); 
}

$db = new Database();
$conn = $db->connect();

// Query untuk mengambil list kontak milik user yang sedang login
$username_login = $_SESSION['user']['username'];
$query = "SELECT * FROM contacts WHERE created_by = '$username_login' ORDER BY id_user DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Contact App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; }
        .navbar { background-color: #007bff; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<nav class="navbar navbar-dark mb-4 shadow-sm">
    <div class="container">
        <span class="navbar-brand mb-0 h1"><i class="bi bi-person-lines-fill"></i> My Contacts</span>
        <div class="d-flex align-items-center">
            <span class="text-light me-3 small">Halo, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong></span>
            <a href="../logout.php" class="btn btn-light btn-sm text-primary fw-bold">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Kontak berhasil dihapus.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Daftar Kontak</h2>
        <a href="tambah_kontak.php" class="btn btn-primary px-4 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Tambah Kontak
        </a>
    </div>

    <div class="card p-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="fw-semibold"><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td class="text-center">
                                    <?php if($row['status'] == 'pending'): ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-clock-history"></i> Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Approved</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="hapus_kontak.php?id=<?= $row['id_user'] ?>" 
                                       class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus kontak <?= htmlspecialchars($row['name']) ?>?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <p>Belum ada kontak. Klik tombol di atas untuk menambah.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>