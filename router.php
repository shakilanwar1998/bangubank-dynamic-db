<?php

use App\Controllers\AdminController;
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

    $user = (new \App\Models\User())->findOne('id',$_SESSION['user_id']);
    if($user['role'] != 2) {
        header('Location: /admin');
        exit();
    }
}

function adminMiddleware(): void
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
    $user = (new \App\Models\User())->findOne('id',$_SESSION['user_id']);
    if($user['role'] != 1) {
        header('Location: /dashboard');
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
        adminMiddleware();
        $controller = new AdminController();
        $controller->index();
        break;

    case '/customers':
        adminMiddleware();
        $controller = new AdminController();
        $controller->getCustomers();
        break;

    case '/transactions':
        adminMiddleware();
        $controller = new AdminController();
        $controller->getTransactions();
        break;


    case '/add_customer':
        adminMiddleware();
        $controller = new AdminController();
        $controller->addCustomer();
        break;

    case '/post_add_customer':
        adminMiddleware();
        $controller = new AdminController();
        $controller->postAddCustomer();
        break;


    case (bool)preg_match('#^/customer_transactions(?:/([^/]+))?$#', $request, $matches):
        adminMiddleware();
        $controller = new AdminController();
        $param = $matches[1] ?? null;
        $controller->getCustomerTransactions($param);
        break;

    default:
        http_response_code(404);
        break;
}