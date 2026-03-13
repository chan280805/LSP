<?php
session_start();
require '../config/database.php';
require '../models/Contact.php';

use Models\Contact;

$db = new Database();
$conn = $db->connect();

$contact = new Contact();
// Ambil 'id' dari URL dan kirim ke method approve
if(isset($_GET['id'])) {
    $contact->approve($conn, $_GET['id']);
}

header("Location: dashboard_admin.php"); // Sesuaikan nama file dashboard admin kamu
exit();