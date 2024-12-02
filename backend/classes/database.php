<?php

class Database{
    private $host = 'localhost';     
    private $username = 'root';       
    private $password = '';          
    private $dbname = 'lmar_hardware';

    protected $connection; 
    function connect(){
        if($this->connection === null){
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
        }

        return $this->connection;
    }
}
?>

