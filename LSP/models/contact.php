<?php
namespace Models;

class Contact {
    public function addContact($conn, $name, $phone, $email, $user_id) {
        // Menggunakan prepared statement untuk keamanan
        $stmt = $conn->prepare("INSERT INTO contacts (name, phone, email, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $phone, $email, $user_id);
        return $stmt->execute();
    }

    public function getPending($conn) {
        // Pastikan kolom 'status' sudah ditambahkan di DB
        return $conn->query("SELECT * FROM contacts WHERE status='pending'");
    }

    public function approve($conn, $id) {
        // Primary key di SQL kamu adalah id_user
        $stmt = $conn->prepare("UPDATE contacts SET status='approved' WHERE id_user = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}