<?php
// Memulai session agar bisa mengakses session yang sedang aktif
session_start();

// Menghapus semua variabel session
$_SESSION = array();

// Jika ingin benar-benar menghapus session cookie (opsional tapi disarankan)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Menghancurkan session
session_destroy();

// Mengarahkan kembali ke halaman login atau index
header("Location: index.php");
exit();
?>