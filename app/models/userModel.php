<?php
include_once __DIR__ . '/../config/database.php';


class UserModel {
    private $db;
    
    public function __construct() {
        $this->db = (new Database())->connect();
    }
    
    // Sign up new user
    public function createUser($first_name, $last_name, $email, $password) {
        $stmt = $this->db->prepare("INSERT INTO user (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first_name, $last_name, $email, password_hash($password, PASSWORD_DEFAULT));
        return $stmt->execute();
    }
    
    // Check if email exists
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT user_id FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Authenticate user login
    public function authenticateUser($email, $password) {
        $stmt = $this->db->prepare("SELECT user_id, password FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user['user_id']; // Authentication successful
            }
        }
        return false;
    }
    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT user_id, first_name, email, password FROM user WHERE email = ?");
        if (!$stmt) {
            die("Prepare failed: " . $this->db->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc(); // Returns user details or null if not found
    }
}
?>
