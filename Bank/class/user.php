<?php
require "database.php";
require "folyoszamla.php";


class User
{
    private $szig_szam;
    private $jelszo;
    private $vezeteknev;
    private $keresztnev;
    private $iranyitoszam;
    private $varos;
    private $utca_hazszam;
    private $email;
    private $telefon;
    private $profilkep;
    private $dbcon;

    private $folyoszamlak;

    function __construct($szig_szam)
    {
        $this->dbcon = new Database();
        $this->dbcon->connect();
        $this->szig_szam = $szig_szam;
        $this->getFolyoszamlaList();
        $this->getAllUserData();
    }
    function felhasznaloCheck($szigszam, $psw)
    {
        $this->szig_szam = $szigszam;
        $this->jelszo = $psw;
        $sql = 'SELECT `szig_szam` FROM `felhasznalo` WHERE `szig_szam` ="' . $this->szig_szam . '" AND `jelszo` ="' . $this->jelszo . '";';
        $result = $this->dbcon->getData($sql);
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }
    function getFolyoszamlaList(){
        $result = $this->dbcon->getData("SELECT * FROM folyoszamla WHERE felhasznalo = '" . $this->szig_szam . "'"); // ORDER BY nev
        foreach ($result as $szamla) {
            $this->folyoszamlak[] = new Folyoszamla($szamla["id"], $szamla["szamlaszam"], $szamla["egyenleg"], $szamla["felhasznalo"], $szamla['hitelszamla'], $szamla['hitelkeret'], $this->dbcon);
        }
    }

    function setActiveFolyoszamla($szamlaid){
        foreach ($this->folyoszamlak as $szamla) {
            if ($szamla->getId() == $szamlaid) {
                $szamla->setAktiv();
            }
        }
    }

    function getActiveFolyoszamla(){
        foreach ($this->folyoszamlak as $szamla) {
            if ($szamla->getAktiv()) {
                return $szamla;
            }
        }
    }

    function getDB(){
        return $this->dbcon;
    }

    function getAllUserData(){
        $sql = "SELECT `szig_szam`, `jelszo`, `vezeteknev`, `keresztnev`, `iranyitoszam`, `utca/hazszam`, `email`, `telefonszam`, `profilkep` FROM `felhasznalo` WHERE `szig_szam` = '" . $this->szig_szam . "'";
        $result = $this->dbcon->getData($sql);
        $this->vezeteknev = $result[0]["vezeteknev"];
        $this->keresztnev = $result[0]["keresztnev"];
        $this->iranyitoszam = $result[0]["iranyitoszam"];
        $this->utca_hazszam = $result[0]["utca/hazszam"];
        $this->email = $result[0]["email"];
        $this->telefon = $result[0]["telefonszam"];
        $this->profilkep = $result[0]["profilkep"];
    }

    function getVezeteknev(){
        return $this->vezeteknev;
    }

    function getKeresztnev(){
        return $this->keresztnev;
    }

    function getIranyitoszam(){
        return $this->iranyitoszam;
    }

    function getVaros(){
        $sql = "SELECT `varos` FROM `varos` WHERE `iranyitoszam` = '" . $this->iranyitoszam . "'";
        $result = $this->dbcon->getData($sql);
        return $result[0]["varos"];
    }

    function getUtcaHazszam(){
        return $this->utca_hazszam;
    }

    function getEmail(){
        return $this->email;
    }

    function getTelefon(){
        return $this->telefon;
    }

    function getSzigSzam(){
        return $this->szig_szam;
    }

    function showFolyoszamlak(){
        echo '<table class="table table-striped w-100 mt-3">
        <thead>
            <th>Folyószámla típusa</th>
            <th>Számlaszám</th>
            <th>Egyenleg</th>
            <th>Művelet</th>
        </thead>
        <tbody>';
        foreach ($this->folyoszamlak as $szamla) {
            echo "<tr>";
            if ($szamla->getHitelszamla() == 0) {
                echo '<td>Hitelszámla</td><td>' . $szamla->getSzamlaszam() . '</td><td>' . number_format($szamla->getHitelkeret(), 0, '.', ' ') . ' Ft</td><td><button type="submit" class="kivalaszt" style="vertical-align:middle" name="kivalaszt" value="' . $szamla->getId() . '"><span>Kiválaszt</span></button></td>';
            } else {
                echo '<td>Folyószámla</td><td>' . $szamla->getSzamlaszam() . '</td><td>' . number_format($szamla->getEgyenleg(), 0, '.', ' ') . ' Ft</td><td><button type="submit" class="kivalaszt" style="vertical-align:middle" name="kivalaszt" value="' . $szamla->getId() . '"><span>Kiválaszt</span></button></td>';
            }
            echo '<input type="text" name="szlaszam" value="' . $szamla->getId() . '" hidden>';
            echo "</tr>";
        }
        echo " </tbody>
       </table>";
    }

    function getProfilkep(){
        return $this->profilkep;
    }

    function updateUser($telefon, $email, $profilkep){
        move_uploaded_file($profilkep["tmp_name"], "../profilkep/" . $this->szig_szam . ".jpg");
        $this->profilkep =  "../profilkep/" . $this->szig_szam . ".jpg";
        $this->telefon = $telefon;
        $this->email = $email;
        $sql = 'UPDATE `felhasznalo` SET `email`="' . $this->email . '",`telefonszam`="' . $this->telefon . '",`profilkep`="' . $this->profilkep . '" WHERE `szig_szam` = "' . $this->szig_szam . '"';
        $this->dbcon->setData($sql);
    }
}
