<?php
include_once __DIR__ . '/../models/UserModel.php';

class AuthController {

    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }

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

    public function login($email, $password) {
        $user_id = $this->userModel->authenticateUser($email, $password);
        if ($user_id) {
            $_SESSION['user'] = $user_id; 
            return true; 
        } else {
            return false;
        }
    }

    public function getUserDetails($email, $password) {
        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        return true;
    }

}
?>
    