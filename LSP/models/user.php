<?php
namespace Models;

class User {
    public function login($conn, $username, $password) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            // Jika di DB masih plain text (admin123), gunakan ini:
            if ($password === $data['password']) { 
                return $data;
            }
            // Jika sudah di-hash (rekomendasi), gunakan: password_verify($password, $data['password'])
        }
        return false;
    }
}