<?php


class Kolcson {

    private $igenyeltOsszeg;
    private $futamido;
    private $jovedelem;
    private $telefonszam;
    private $email;
    private $igenylesDatuma;
    private $thm = 0.08;
    private $felhasznalo;
    private $visszafizetendo;
    private $elutasitva;
    private $elfogadva; 
    private $sikerese = false;
    private $dbcon;
    private $osszes_reszlet=0;
    
    function __construct($igenyeltOsszeg, $futamido, $jovedelem, $telefonszam, $email, $felhasznalo, $dbcon){
        $this->dbcon = $dbcon;
        $this->dbcon->connect();
        $this->igenyeltOsszeg = $igenyeltOsszeg;
        $this->futamido = $futamido;
        $this->jovedelem = $jovedelem;
        $this->telefonszam = $telefonszam;
        $this->email = $email;
        $this->felhasznalo = $felhasznalo;
        $this->visszafizetendo = ($this->igenyeltOsszeg * $this->thm) + $this->igenyeltOsszeg;
        $this->hitelKepes();
        
    }

    function haviTorleszto(){
        return (($this->igenyeltOsszeg * $this->thm) + $this->igenyeltOsszeg)/$this->futamido;
    }

    function hitelKepes(){
        
        if($this->jovedelem < 500000){
            if($this->haviTorleszto()+$this->getAllLiveLoan() < $this->jovedelem * 0.5){
                $this->hitelFolyositas();
                $this->elfogadva = "Sikeres kölcsönigénylés! Kérjük a véglegesítéshez keresse fel bankunkat!"; 
                $this->sikerese = true;
            }else{
                $this->elutasitva = "Hitelkérelme elutasításra került, kérjük vegye fel a kapcsolatott bankunkkal!";
                $this->sikerese = false;
            }
        }else{
            if($this->haviTorleszto()+$this->getAllLiveLoan() < $this->jovedelem * 0.6){
                $this->hitelFolyositas();
                $this->elfogadva = "Sikeres kölcsönigénylés! Kérjük a véglegesítéshez keresse fel bankunkat!"; 
                $this->sikerese = true;
            }else{
                $this->elutasitva = "Hitelkérelme elutasításra került, kérjük vegye fel a kapcsolatott bankunkkal!";
                $this->sikerese = false;
            }
        }  
    }

    function hitelFolyositas(){
        $sql = "INSERT INTO `kolcson`(`datum`, `thm`, `futamido`, `felvett_osszeg`, `felhasznalo`, `visszafizetendo`) VALUES ('".date("Y-m-d")."','".$this->thm."','".$this->futamido."','".$this->igenyeltOsszeg."','".$this->felhasznalo."','".$this->visszafizetendo."')";
        
        
        $this->dbcon->setData($sql);
    }

    function getElutasitva(){
        return $this->elutasitva;
    }
    function getElfogadva(){
        return $this->elfogadva;
    }
    function getSikeres(){
        return $this->sikerese;
    }

    function getAllLiveLoan(){
        $sql = 'SELECT * FROM `kolcson` WHERE `felhasznalo` ="'.$this->felhasznalo.'" ';
        
        $kolcsonok = $this->dbcon->getData($sql);
        if(empty($kolcsonok)){
            $this->osszes_reszlet =0;
        }else{
            foreach ($kolcsonok as $kolcson) {
                $this->osszes_reszlet += $kolcson["visszafizetendo"]/$kolcson["futamido"];
            }
        }
        return $this->osszes_reszlet;
    }



}
