<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\TransactionController;

function authMiddleware(): void
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
}

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/':
        $controller = new HomeController();
        $controller->index();
        break;

    case '/login':
        $controller = new AuthController();
        $controller->index();
        break;

    case '/logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case '/register':
        $controller = new AuthController();
        $controller->register();
        break;

    case '/post-register':
        $controller = new AuthController();
        $controller->postRegister();
        break;

    case '/post-login':
        $controller = new AuthController();
        $controller->postLogin();
        break;

    case '/dashboard':
        authMiddleware();
        $controller = new DashboardController();
        $controller->index();
        break;

    case '/deposit':
        authMiddleware();
        $controller = new DashboardController();
        $controller->getDeposit();
        break;


    case '/withdraw':
        authMiddleware();
        $controller = new DashboardController();
        $controller->getWithdraw();
        break;


    case '/transfer':
        authMiddleware();
        $controller = new DashboardController();
        $controller->getTransfer();
        break;


    case '/post-deposit':
        authMiddleware();
        $controller = new TransactionController();
        $controller->deposit();
        break;

    case '/post-withdraw':
        authMiddleware();
        $controller = new TransactionController();
        $controller->withdraw();
        break;


    case '/post-transfer':
        authMiddleware();
        $controller = new TransactionController();
        $controller->transfer();
        break;


    case '/admin':
        authMiddleware();
        $controller = new \App\Controllers\AdminController();
        $controller->index();
        break;

    default:
        http_response_code(404);
        break;
}