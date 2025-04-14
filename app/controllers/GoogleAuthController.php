<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/AuthController.php';

class GoogleAuthController {
    private $client;
    private $authController;

    public function __construct() {
        $this->authController = new AuthController();

        $this->client = new Google_Client();
        $this->client->setClientId('96427974634-nbndslbchun8d9s2mvc94mjo3sb21tku.apps.googleusercontent.com');
        $this->client->setClientSecret('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');
        $this->client->setRedirectUri('http://localhost/mini-project/public/index.php');
        $this->client->addScope('email');
        $this->client->addScope('profile');
    }

    public function getAuthUrl() {
        return $this->client->createAuthUrl();
    }

    public function handleCallback() {
        if (isset($_GET['code'])) {
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            if (!isset($token["error"])) {
                $this->client->setAccessToken($token['access_token']);
                $oauth2 = new Google_Service_Outh2($this->client);
                $google_user = $oauth2->userinfo->get();
                $email = $google_user->email;
                $first_name = $google_user->givenName;
                $last_name = $google_user->familyName;

                $user = $this->authController->getUserDetails($email, "");

                if (!$user) {
                    // Auto-register with random secure password (won't be used)
                    $this->authController->signUp($first_name, $last_name, $email, bin2hex(random_bytes(10)));
                    $user = $this->authController->getUserDetails($email, "");
                }

                if ($user) {
                    session_start();
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['email'] = $user['email'];
                    header("Location: index.php");
                    exit();
                }
            }
        }
    }
}
?>
