<?php

namespace App\Controllers;
use App\Models\User;

class AuthController
{
    private User $model;
    public function __construct()
    {
        $this->model = new User();
    }
    public function index(): void
    {
        view('login',[
            'page_title' => 'Login'
        ]);
    }

    public function login(): void
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit();
        }
        view('login',[
            'page_title' => 'Login'
        ]);
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: /');
    }

    public function register(): void
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit();
        }
        view('register',[
            'page_title' => 'Register'
        ]);
    }

    public function postRegister(): void
    {
        $data = [
            'name' => $_REQUEST['name'] ?? null,
            'email' => $_REQUEST['email'] ?? null,
            'password' => $_REQUEST['password'] ?? null,
            'role' => 2
        ];

        if ($this->model->findOne('email', $data['email'])) {
            echo "Email already registered.";
            return;
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $user = $this->model->create($data);

        header('Location: /dashboard');
    }

    public function postLogin(): void
    {
        $email = $_REQUEST['email'] ?? null;
        $password = $_REQUEST['password'] ?? null;

        if (!$email || !$password) {
            echo "Email and password are required.";
            return;
        }

        $user = $this->model->findOne('email', $email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: /dashboard');
        } else {
            echo "Invalid email or password.";
        }
    }
}