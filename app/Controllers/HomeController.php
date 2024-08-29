<?php

namespace App\Controllers;

class HomeController
{
    public function index(){
        view('Home',[
            'page_title' => 'BanguBank'
        ]);
    }
}