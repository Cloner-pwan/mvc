<?php

class HomeController extends Controller
{
    public function index()
    {
        echo "hi ! this is index"; 
        $model = new homeModel();
        $test = $model->get();
          
    }
}