<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('index', $this->data);
    }

    public function about(): string
    {
        return view('about', $this->data);
    }

    public function contact(): string
    {
        return view('contact', $this->data);
    }
}