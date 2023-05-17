<?php

class Database {
    protected $host = 'localhost';
    protected $user = 'root';
    protected $pwd = '';
    protected $dbName = 'bank';

    function connect(){
        $this->pdo = new PDO("mysql:dbname=$this->dbName;charset=utf8;host=$this->host",$this->user, $this->pwd);
        return $this->pdo;
    }

    function getData($sql){
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function setData($sql){
        $query = $this->pdo->prepare($sql);
        $query->execute();
    }
}
?>