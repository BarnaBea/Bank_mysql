<?php
session_start();

include_once ("../class/user.php");

if(isset($_POST["szigszam"])){
    if(isset($_POST["jelszo"])){
        $szigszam = $_POST["szigszam"];
        $jelszo = $_POST["jelszo"];
        $user = new User($szigszam);
        if($user->felhasznaloCheck($szigszam,$jelszo)){
            $_SESSION["aktiv"] = $szigszam;
            unset($user);
            header('Location: folyoszamlalista.php');
        }else{
            echo "Nem létezik ilyen felhasználó";
        }
        
    }else{
        echo "jelszo";
    }

}else{
    echo "szigszam";
}

?>