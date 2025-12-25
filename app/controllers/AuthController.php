<?php
class AuthController
{
    public function login()
    {
        if (Auth::check()) {
            header("Location: /ticketflow/public/dashboard");
            exit;
        }

        require_once "../app/views/auth/login.php";
    }

    public function authenticate()
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $error = "Invalid email or password";
            require_once "../app/views/auth/login.php";
            return;
        }

        Auth::login($user);
        header("Location: /ticketflow/public/dashboard");
        exit;
    }

    public function logout()
    {
        Auth::logout();
    }
}
