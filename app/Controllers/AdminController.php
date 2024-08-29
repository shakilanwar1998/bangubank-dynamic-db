<?php

namespace App\Controllers;

class AdminController
{

    public function index()
    {
        $this->getCustomers();
    }

    public function getCustomers()
    {
        view('admin/customers');
    }

    public function addCustomer()
    {
        view('admin/add_customer');
    }

    public function getTransactions()
    {
        view('admin/transactions');
    }

    public function getCustomerTransactions() {
        view('admin/customer_transactions');
    }
}