<?php

class HomeController extends Controller
{
    public function index()
    {
        echo "hi ! this is index";
    }

    public function data()
    {
        $this->render("home", "data");
    }
}