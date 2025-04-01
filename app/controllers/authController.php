<?php
include_once __DIR__ . '/../models/UserModel.php';

class AuthController {

    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Sign Up method
    public function signUp($first_name, $last_name, $email, $password) {
        if ($this->userModel->emailExists($email)) {
            return "Email already registered!";
        } else {
            if ($this->userModel->createUser($first_name, $last_name, $email, $password)) {
                return "User registered successfully!";
            } else {
                return "Error registering user!";
            }
        }
    }

    // Login method
    public function login($email, $password) {
        $user_id = $this->userModel->authenticateUser($email, $password);
        if ($user_id) {
            $_SESSION['user'] = $user_id; // Store session
            return true; // Authentication successful
        } else {
            return false; // Invalid credentials
        }
    }

    public function getUserDetails($email, $password) {
        // Fetch user details from the model
        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Return full user details
        }
        return false; // Authentication failed
    }
    
    // Logout method
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        return true;
    }

}
?>
    