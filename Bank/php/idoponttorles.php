<?php
session_start();
require "../class/database.php";

if(isset($_POST["datum"]) && isset($_POST["idopont"])){
    $db = new Database();
    $db->connect();
    if($_POST["datum"] < date("Y-m-d")){
        $_SESSION["msg"] = "<div class='alert alert-danger'>Visszamenőleg időpont nem törölhető!</div>";
    }else{
        $sql = 'DELETE FROM `idopont_foglalas` WHERE `idopont`="'.$_POST["idopont"].'" AND `datum`="'.$_POST["datum"].'" AND `felhasznalo`="'.$_SESSION["aktiv"].'"';
        $db->setData($sql);
        $_SESSION["msg"] = "<div class='alert alert-success'>Sikeres időpont törlés!</div>";
    }
    
    
}
