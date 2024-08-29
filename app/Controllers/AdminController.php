<?php

namespace App\Controllers;

use App\Models\Transaction;
use App\Models\User;

class AdminController
{

    public function index()
    {
        $this->getCustomers();
    }

    public function getCustomers(): void
    {
        $filters = [
            'operator' => 'AND',
            'conditions' => [
                [
                    'key' => 'role',
                    'value' => 2,
                ]
            ],
        ];

        $customers = (new User())->findAll($filters);

        view('admin/customers', ['customers' => $customers, 'page_title' => 'Customers']);
    }

    public function addCustomer()
    {
        view('admin/add_customer', ['page_title' => 'Add Customer']);
    }

    public function getTransactions()
    {
        $transactions = (new Transaction())->findAll();

        $modifiedTransactions = [];
        foreach ($transactions as $transaction) {
            if ($transaction['from_user_id'] == 0) {
                $userId = $transaction['to_user_id'];
            } else {
                $userId = $transaction['from_user_id'];
            }

            $user = (new User())->findOne('id', $userId);
            $transaction['user_email'] = $user['email'] ?? "";
            $transaction['user_name'] = $user['name'] ?? "";

            $modifiedTransactions[] = $transaction;

            if ($transaction['from_user_id'] != 0 && $transaction['to_user_id'] != 0) {
                $userIdTo = $transaction['to_user_id'];
                $userTo = (new User())->findOne('id', $userIdTo);

                $transactionTo = $transaction;
                $transactionTo['user_email'] = $userTo['email'] ?? "";
                $transactionTo['user_name'] = $userTo['name'] ?? "";

                $modifiedTransactions[] = $transactionTo;
            }
        }

        view('admin/transactions', ['transactions' => $modifiedTransactions, 'page_title' => 'Transactions']);
    }

    public function getCustomerTransactions(int $customerId) {

        $user = (new User())->findOne('id',$customerId);

        $filters = [
            'operator' => 'OR',
            'conditions' => [
                [
                    'key' => 'from_user_id',
                    'value' => $customerId,
                ],
                [
                    'key' => 'to_user_id',
                    'value' => $customerId,
                ],
            ],
        ];

        $transactions = (new Transaction())->findAll($filters);


        $modifiedTransactions = array_map(function($transaction) use ($customerId) {
            $userId = $transaction['from_user_id'] == $customerId ? $transaction['to_user_id'] : $transaction['from_user_id'];

            $user = (new User())->findOne('id',$userId);

            $transaction['user_email'] = $user['email'] ?? "";
            $transaction['user_name'] = $user['name'] ?? "";

            return $transaction;
        }, $transactions);

        view('admin/customer_transactions', ['page_title' => 'Transactions', 'transactions' => $modifiedTransactions, 'customer' => $user]);
    }

    public function postAddCustomer(): void
    {
        $data = [
            'name' => $_REQUEST['first-name'] . ' ' .$_REQUEST['last-name'] ?? null,
            'email' => $_REQUEST['email'] ?? null,
            'password' => $_REQUEST['password'] ?? null,
            'role' => 2
        ];

        if ((new User())->findOne('email', $data['email'])) {
            echo "Email already registered.";
            header('Location: /customers');
            exit();
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        (new User())->create($data);

        header('Location: /customers');
    }
}