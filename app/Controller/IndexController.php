<?php

namespace Sole\LiteWeb\Controller;

class IndexController
{
    public function index()
    {

        return view('index', ['name' => 'Alice']);
    }
}