<?php

require_once 'database.php';

class Account{
    public $id = '';
    public $email = '';
    public $password = '';
    public $role = '';


    protected $db;

    function __construct(){
        $this->db = new Database();
    }

    function add(){
        $sql = "INSERT INTO users (email, password, role) VALUES (:email, :password, :role);";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':email', $this->email);
        $hashpassword = password_hash($this->password, PASSWORD_DEFAULT);
        $query->bindParam(':password', $hashpassword);
        $query->bindParam(':role', $this->role);
        return $query->execute();
    }

    function showAll() {
        $sql = "SELECT * FROM users";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    function emailExist($email, $excludeID){
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        if ($excludeID){
            $sql .= " and id != :excludeID";
        }

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':email', $email);

        if ($excludeID){
            $query->bindParam(':excludeID', $excludeID);
        }

        $count = $query->execute() ? $query->fetchColumn() : 0;

        return $count > 0;
    }

    function login($email, $password){
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam('email', $email);

        if($query->execute()){
            $data = $query->fetch();
            if($data && password_verify($password, $data['password'])){
                return true;
            }
        }

        return false;
    }

    function fetch($email){
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam('email', $email);
        $data = null;
        if($query->execute()){
            $data = $query->fetch();
        }

        return $data;
    }
}

// $obj = new Account();

// $obj->add();