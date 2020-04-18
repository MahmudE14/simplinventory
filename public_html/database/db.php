<?php

class Database
{
    private $con;   
    function connect()
    {
        include_once("constants.php");
        $this->con = new MySQLi(HOST, USER, PASS, DB);
        
        if ($this->con) {
            return $this->con;
        }
        return "DATABASE_CONNECTION_FAILED";
    }
}

// $db = new Database();
// $db->connect();
