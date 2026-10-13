<?php
class Controller
{
    public function render($directoryName, $view, $data = [])
    {
        extract($data);

        $path = __DIR__ . "/../app/views/$directoryName/$view.php";
        
        require_once $path;
    }
}