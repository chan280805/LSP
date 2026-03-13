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
$contact = new Contact();

if(isset($_POST['simpan'])){
    $result = $contact->addContact(
        $conn,
        $_POST['name'],
        $_POST['phone'],
        $_POST['email'],
        $_SESSION['user']['username']
    );
    
    if($result) {
        header("Location: dashboard_user.php?msg=success");
        exit();
    } else {
        $error = "Gagal menambahkan kontak.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kontak Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f2f5; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <a href="dashboard_user.php" class="btn btn-link text-decoration-none text-secondary mb-3 p-0">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>

            <div class="card p-4">
                <div class="card-body">
                    <h3 class="card-title mb-4 fw-bold">Kontak Baru</h3>
                    
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-secondary fw-semibold">Alamat Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" required>
                        </div>
                        <div class="d-grid">
                            <button name="simpan" type="submit" class="btn btn-primary btn-lg shadow">
                                <i class="bi bi-check-lg me-2"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>