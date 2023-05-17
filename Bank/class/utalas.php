<?php

class Utalas
{
    private $id;
    private $szamlaszam;
    private $datum;
    private $kozlemeny;
    private $osszeg;
    private $partner;
    private $aktivSzamla;
    private $dbcon;

    function __construct($szamlaszam, $kozlemeny, $osszeg, $partner, $aktivSzamla)
    {
        $this->szamlaszam = $szamlaszam;
        $this->datum = date("Y-m-d");
        $this->kozlemeny = $kozlemeny;
        $this->osszeg = $osszeg;
        $this->partner = $partner;
        $this->aktivSzamla = $aktivSzamla;
        $this->dbcon = $aktivSzamla->getDbCon();
        $this->dbcon->connect();
    }

    function utalasUpload()
    {
        $folyoszamla = $this->utalasSzamlaEllenorzes($this->szamlaszam);
        if (is_null($folyoszamla)) { // nem létezik a célszámla
            if ($this->aktivSzamla->hitelszamlaE() == 1) { //nem hitelszámláról utalunk
                if ($this->aktivSzamla->getEgyenleg() > $this->osszeg) { //van elég fedezet
                    $this->aktivSzamla->setEgyenleg($this->aktivSzamla->getEgyenleg() - $this->osszeg);
                    $this->updatePartner($this->szamlaszam, $this->partner);
                    $sql = "INSERT INTO `utalas`(`partner_szamlaszam`, `datum`, `kozlemeny`, `osszeg`, `folyoszamla`, `jovairas`) VALUES ('" . $this->szamlaszam . "','" . $this->datum . "','" . $this->kozlemeny . "','" . $this->osszeg . "','" . $this->aktivSzamla->getId() . "','1')";
                    $this->dbcon->setData($sql);
                    header('Location: utalasVisszajelzes.php');
                } else { //nincs elég fedezet
                    header('Location: utalasHiba.php');
                }
            } else {
                if ($this->aktivSzamla->getHitelkeret() > $this->osszeg) {
                    $this->aktivSzamla->setHitelkeret($this->osszeg);
                    //utalás mentése
                    $this->updatePartner($this->szamlaszam, $this->partner);
                    $sql = "INSERT INTO `utalas`(`partner_szamlaszam`, `datum`, `kozlemeny`, `osszeg`, `folyoszamla`, `jovairas`) VALUES ('" . $this->szamlaszam . "','" . $this->datum . "','" . $this->kozlemeny . "','" . $this->osszeg . "','" . $this->aktivSzamla->getId() . "','1')";
                    //echo $sql;
                    $this->dbcon->setData($sql);

                    //hűségpont jóváírás
                    $sql = 'INSERT INTO `husegprogram`(`bevalthato_pontok`, `folyoszamla_id`) VALUES (' . ($this->getPontEgyenleg() + ($this->osszeg * 0.01)) . ',' . $this->aktivSzamla->getId() . ')';
                    $this->dbcon->setData($sql);
                    header('Location: utalasVisszajelzes.php');
                } else {
                    header('Location: utalasHiba.php'); //nincs keret
                }
            }
        } else {
            if ($this->aktivSzamla->hitelszamlaE() == 0) { //hitelszámla
                if ($this->aktivSzamla->getHitelkeret() > $this->osszeg) { //van fedezet
                    //változtatjuk a hitelkeretet
                    $this->aktivSzamla->setHitelkeret($this->osszeg);
                    //mentjük az utalást
                    $this->updatePartner($this->szamlaszam, $this->partner);
                    $sql = "INSERT INTO `utalas`(`partner_szamlaszam`, `datum`, `kozlemeny`, `osszeg`, `folyoszamla`, `jovairas`) VALUES ('" . $this->szamlaszam . "','" . $this->datum . "','" . $this->kozlemeny . "','" . $this->osszeg . "','" . $this->aktivSzamla->getId() . "','1')";
                    $this->dbcon->setData($sql);
                    //jóváírjuk a célszámlán
                    if ($folyoszamla->hitelszamlaE() == 0) { //hitelszámlára utalunk
                        $sql = "UPDATE `folyoszamla` SET `hitelkeret`='" . $folyoszamla->getHitelkeret() + $this->osszeg . "' WHERE `id` = '" . $folyoszamla->getId() . "'";
                        $this->dbcon->setData($sql);
                    } else { //sima számlára utalunk
                        $sql = "UPDATE `folyoszamla` SET `egyenleg`='" . $folyoszamla->getEgyenleg() + $this->osszeg . "' WHERE `id` = '" . $folyoszamla->getId() . "'";
                        $this->dbcon->setData($sql);
                    }
                    //mentjük a jóváírást
                    $sql = "INSERT INTO `utalas`(`partner_szamlaszam`, `datum`, `kozlemeny`, `osszeg`, `folyoszamla`, `jovairas`) VALUES ('" . $this->aktivSzamla->getSzamlaszam() . "','" . $this->datum . "','" . $this->kozlemeny . "','" . $this->osszeg . "','" . $folyoszamla->getId() . "', 0)";
                    $this->dbcon->setData($sql);
                    //hűségpont jóváírás
                    $sql = 'INSERT INTO `husegprogram`(`bevalthato_pontok`, `folyoszamla_id`) VALUES (' . ($this->getPontEgyenleg() + ($this->osszeg * 0.01)) . ',' . $this->aktivSzamla->getId() . ')';
                    $this->dbcon->setData($sql);
                    header('Location: utalasVisszajelzes.php');
                } else {
                    header('Location: utalasHiba.php'); //nincs egyenleg 
                }
            } else { // folyószámláról utalunk
                if ($this->aktivSzamla->getEgyenleg() > $this->osszeg) { //van keret
                    $this->aktivSzamla->setEgyenleg($this->aktivSzamla->getEgyenleg() - $this->osszeg);
                    //utalás mentése
                    $this->updatePartner($this->szamlaszam, $this->partner);
                    $sql = "INSERT INTO `utalas`(`partner_szamlaszam`, `datum`, `kozlemeny`, `osszeg`, `folyoszamla`, `jovairas`) VALUES ('" . $this->szamlaszam . "','" . $this->datum . "','" . $this->kozlemeny . "','" . $this->osszeg . "','" . $this->aktivSzamla->getId() . "','1')";
                    $this->dbcon->setData($sql);

                    //osszeg jovairasa letezo szamlan
                    if ($folyoszamla->hitelszamlaE() == 0) {
                        $sql = "UPDATE `folyoszamla` SET `hitelkeret`='" . $folyoszamla->getHitelkeret() + $this->osszeg . "' WHERE `id` = '" . $folyoszamla->getId() . "'";
                        $this->dbcon->setData($sql);
                    } else {
                        $sql = "UPDATE `folyoszamla` SET `egyenleg`='" . $folyoszamla->getEgyenleg() + $this->osszeg . "' WHERE `id` = '" . $folyoszamla->getId() . "'";
                        $this->dbcon->setData($sql);
                    }
                    //jovairas mentese
                    $this->updatePartner($this->aktivSzamla->getSzamlaszam(), $this->getSajatNev());
                    $sql = "INSERT INTO `utalas`(`partner_szamlaszam`, `datum`, `kozlemeny`, `osszeg`, `folyoszamla`, `jovairas`) VALUES ('" . $this->aktivSzamla->getSzamlaszam() . "','" . $this->datum . "','" . $this->kozlemeny . "','" . $this->osszeg . "','" . $folyoszamla->getId() . "', 0)";
                    $this->dbcon->setData($sql);
                } else {
                    header('Location: utalasHiba.php'); //nincs keret
                }
            }
        }
    }

    function utalasSzamlaEllenorzes($partnerSzamlaszam)
    {
        $sql = "SELECT * FROM `folyoszamla` WHERE `szamlaszam` = '" . $partnerSzamlaszam . "'";
        $result = $this->dbcon->getData($sql);
        if (!empty($result)) {
            $szamla = new Folyoszamla($result[0]["id"], $result[0]["szamlaszam"], $result[0]["egyenleg"], $result[0]["felhasznalo"], $result[0]['hitelszamla'], $result[0]['hitelkeret'], $this->dbcon);
            return $szamla;
        } else {
            return NULL;
        }
    }

    function getSenderName($szamlaId)
    {
        $sql = "SELECT `vezeteknev`,`keresztnev` FROM `felhasznalo` INNER JOIN `folyoszamla`ON `felhasznalo`.`szig_szam` = `folyoszamla`.`felhasznalo` WHERE `folyoszamla`.`id` = '" . $szamlaId . "'";
        $result = $this->dbcon->getData($sql);
        return $result[0]["vezeteknev"] . " " . $result[0]["keresztnev"];
    }

    function getPontEgyenleg()
    {
        $sql = 'SELECT `bevalthato_pontok` FROM `husegprogram` WHERE `folyoszamla_id` = "' . $this->aktivSzamla->getId() . '"';
        $result = $this->dbcon->getData($sql);
        return $result[0]["bevalthato_pontok"];
    }

    function getSajatNev()
    {
        $sql = 'SELECT `vezeteknev`,`keresztnev` FROM `felhasznalo` INNER JOIN `folyoszamla` ON `felhasznalo`.`szig_szam` = `folyoszamla`.`felhasznalo` WHERE `folyoszamla`.`id` = "' . $this->aktivSzamla->getId() . '"';
        $result = $this->dbcon->getData($sql);
        return $result[0]["vezeteknev"] . " " . $result[0]["keresztnev"];
    }

    function updatePartner($szamlaszam, $partner)
    {
        $sql = 'SELECT `partner_szamlaszam` FROM `partner` WHERE `partner_szamlaszam` = "' . $szamlaszam . '"';
        $result = $this->dbcon->getData($sql);
        if (empty($result)) {
            $sql = "INSERT INTO `partner`(`partner_szamlaszam`, `partner_neve`) VALUES ('" . $szamlaszam . "', '" . $partner . "')";
            $this->dbcon->setData($sql);
        } 
    }
}
