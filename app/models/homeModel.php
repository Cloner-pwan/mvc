<?php
class homeModel
{
    public function get()
    {
        $dsn = DataBase::connect();
        return $dsn;
    }
}