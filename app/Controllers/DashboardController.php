<?php

namespace App\Controllers;

use App\Models\Transaction;
use App\Models\User;

class DashboardController
{
    public function index(): void
    {
        $currentUserId = $_SESSION['user_id'];

        $user = (new User())->findOne('id',$_SESSION['user_id']);

        $filters = [
            'operator' => 'OR',
            'conditions' => [
                [
                    'key' => 'from_user_id',
                    'value' => $_SESSION['user_id'],
                ],
                [
                    'key' => 'to_user_id',
                    'value' => $_SESSION['user_id'],
                ],
            ],
        ];

        $transactions = (new Transaction())->findAll($filters);

        $modifiedTransactions = array_map(function($transaction) use ($currentUserId) {
            $userId = $transaction['from_user_id'] == $currentUserId ? $transaction['to_user_id'] : $transaction['from_user_id'];
            
            $user = (new User())->findOne('id',$userId);

            $transaction['user_email'] = $user['email'] ?? "";
            $transaction['user_name'] = $user['name'] ?? "";

            return $transaction;
        }, $transactions);

        view('customer/dashboard',[
            'transactions' => $modifiedTransactions,
            'user' => $user,
            'page_title' => 'Dashboard',
        ]);
    }

    public function getDeposit(): void
    {
        $user = (new User())->findOne('id',$_SESSION['user_id']);

        view('customer/deposit',[
            'user' => $user,
            'page_title' => 'Dashboard',
        ]);
    }

    public function getWithdraw()
    {
        $user = (new User())->findOne('id',$_SESSION['user_id']);

        view('customer/withdraw',[
            'user' => $user,
            'page_title' => 'Dashboard',
        ]);
    }

    public function getTransfer()
    {
        $user = (new User())->findOne('id',$_SESSION['user_id']);
        view('customer/transfer',[
            'user' => $user,
            'page_title' => 'Dashboard',
        ]);
    }
}