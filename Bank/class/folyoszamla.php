<?php

class Folyoszamla {
    private $id;
    private $szamlaszam;
    private $egyenleg;
    private $aktiv = false;
    private $felhasznalo_id;
    private $hitelszamla;
    private $hitelkeret;
    private $dbcon;

    function __construct($id, $szamlaszam, $egyenleg, $felhasznalo_id,$hitelszamla, $hitelkeret, $dbcon){
        $this->id = $id;
        $this->szamlaszam = $szamlaszam;
        $this->egyenleg = $egyenleg;
        $this->felhasznalo_id = $felhasznalo_id;
        $this->hitelszamla = $hitelszamla;
        $this->hitelkeret = $hitelkeret;
        $this->dbcon = $dbcon;
    }

    function getSzamlaszam(){
        return $this->szamlaszam;
    }

    function getEgyenleg(){
        return $this->egyenleg;
    }

    function setEgyenleg($egyenleg){
        $this->egyenleg = $egyenleg;
        $this->dbcon->connect();
        $sql = "UPDATE `folyoszamla` SET `egyenleg`= '".$this->egyenleg."' WHERE `id`= '".$this->id."'";
        $this->dbcon->setData($sql);
    }

    function getId(){
        return $this->id;
    }

    function getFelhasznaloId(){
        return $this->felhasznalo_id;
    }
    function getDbCon(){
        return $this->dbcon;
    }

    function getAktiv(){
        return $this->aktiv;
    }
    function getHitelszamla(){
        return $this->hitelszamla;
    }

    function setAktiv(){
        $this->aktiv = true;
    }

    function getHitelkeret(){
        return $this->hitelkeret;
    }

    function setHitelkeret($osszeg){
        $this->hitelkeret = $this->hitelkeret-$osszeg;
        $this->dbcon->connect();
        $sql = "UPDATE `folyoszamla` SET `hitelkeret`= '".$this->hitelkeret."' WHERE `id`= '".$this->id."'";
        $this->dbcon->setData($sql);
    }

    function hitelkeretFelhasznalas($osszeg){
        if($this->getHitelkeret() - $osszeg > 0){
            $this->setHitelkeret($osszeg);
            return true;
        }else{
            return false;
        }
    }

    function hitelszamlaE(){
        $sql = 'SELECT `hitelszamla` FROM `folyoszamla` WHERE `szamlaszam` = "' . $this->szamlaszam . '"';
        $result = $this->dbcon->getData($sql);
        return $result[0]["hitelszamla"];
    }


}

?>