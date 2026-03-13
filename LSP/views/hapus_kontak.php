<?php
session_start();
require '../config/database.php';

// Proteksi halaman
if(!isset($_SESSION['user'])) { 
    header("Location: ../index.php"); 
    exit(); 
}

$db = new Database();
$conn = $db->connect();

if(isset($_GET['id'])) {
    $id_user_kontak = $_GET['id'];
    $username_login = $_SESSION['user']['username'];

    // Query hapus dengan validasi 'created_by' agar user tidak bisa hapus milik orang lain
    $query = "DELETE FROM contacts WHERE id_user = ? AND created_by = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $id_user_kontak, $username_login);

    if($stmt->execute()) {
        header("Location: dashboard_user.php?msg=deleted");
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    header("Location: dashboard_user.php");
}
exit();
?>