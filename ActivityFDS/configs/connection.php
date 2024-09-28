<?php

define("SERVER", "localhost");
define("DBASE", "fdsactivity");
define("USER", "root");
define("PASSWORD", "");

class connection
{
    protected $con_string = "mysql:host=" . SERVER . ";dbname=" . DBASE . "; charset=utf8mb4";
    protected $options = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false
    ];

    public function connect()
    {
        try {
            return new \PDO($this->con_string, USER, PASSWORD, $this->options);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
