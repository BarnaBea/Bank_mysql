<?php
session_start();
require "../class/database.php";

$db = new Database();
$db->connect();
$reszletes = 1;
$dataPoints = array();
$zarasegyenleg[0]["egyenleg"]= 0;
if (isset($_POST["reszletesszures"])) {
    
    $kezdet = $_POST["kezdet"];
    $veg = $_POST["veg"];
    $sql = "SELECT * FROM `utalas` INNER JOIN `partner` ON `utalas`.`partner_szamlaszam` = `partner`.`partner_szamlaszam` WHERE `folyoszamla` = " . $_SESSION["id"] . " AND `datum` BETWEEN '" . $kezdet . "' AND '" . $veg . "' ORDER BY `datum` ASC";
    $result = $db->getData($sql);

    if($veg > date("Y-m-d")){
        $veg= date("Y-m-d");
    }
    $sql = "SELECT (`egyenleg`-IFNULL((SELECT SUM(`osszeg`) FROM `utalas` WHERE `folyoszamla` = " . $_SESSION["id"] . " AND `jovairas` = 0 AND `datum` BETWEEN '" . $veg . "' AND '".date("Y-m-d")."'),0) + IFNULL((SELECT SUM(`osszeg`) FROM `utalas` WHERE `folyoszamla` = " . $_SESSION["id"] . " AND `jovairas` = 1 AND `datum` BETWEEN '" . $veg . "' AND '".date("Y-m-d")."'),0)) as egyenleg FROM `folyoszamla` INNER JOIN `utalas` ON `folyoszamla`.`id` = `utalas`.`folyoszamla` WHERE `folyoszamla` = " . $_SESSION["id"] . " AND `datum` BETWEEN '" . $veg . "' AND '".date("Y-m-d")."' GROUP BY `egyenleg`";
    $zarasegyenleg = $db->getData($sql);
    if(!isset($zarasegyenleg[0])){
        $sql = "SELECT `egyenleg` FROM `folyoszamla` WHERE `id` = " . $_SESSION["id"];
        $zarasegyenleg = $db->getData($sql);
    }
}
if (isset($_POST["osszesitettszures"])) {
    $i = 0;
    $kezdet = $_POST["kezdet"];
    $veg = $_POST["veg"];
    $sql = "SELECT `partner`.`partner_neve` ,`utalas`.`partner_szamlaszam`, SUM(`osszeg`) AS `osszeg` FROM `utalas` INNER JOIN `partner` ON `utalas`.`partner_szamlaszam` = `partner`.`partner_szamlaszam` WHERE `folyoszamla` = " . $_SESSION["id"] . " AND `datum` BETWEEN '" . $kezdet . "' AND '" . $veg . "' GROUP BY `partner`.`partner_szamlaszam`";
    $osszesitett_result = $db->getData($sql);
    
    $reszletes = 2;
}
if (isset($_POST["diagram"])) {
    $_SESSION["start"] = $_POST["kezdet"];
    $_SESSION["end"] = $_POST["veg"];
    header("location:diagram.php");

    $reszletes = 3;
}


?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Domine&family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Számlatörténet</title>

    <style media="print">
        table,
        th,
        tr,
        td {
            color: black !important;
            font-size: 10px;
        }

        p {
            color: #000000;
        }

        body {
            background-color: #FFFFFF;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navigacio mx-auto col-8 d-print-none">
        <a class="navbar-brand text-white ml-auto" href="fooldal.php" style="padding:0 0 0 16px;">Vissza</a>
    </nav>
    <div class="container form-bg shadow mt-5 col-8 mb-5">
        <h5 class="pt-3 d-print-none">Számlatörténet</h5>
        <div class="row " id="sikeresutalas">
            <form action="" class="mx-auto shadow d-print-none" style="border-radius:20px; background-color: rgba(45, 155, 54, 0.8);" method="post">
                <div class="p-5">
                    <input class="rounded" type="date" name="kezdet" id="start">
                    <input class="rounded" type="date" name="veg" id="end">
                </div>
                <div class="pb-3">
                    <button type="submit" class="btn btn-success mx-auto" name="reszletesszures">Részletes</button>
                    <button type="submit" class="btn btn-success mx-auto" name="osszesitettszures">Összesített</button>
                    <button type="submit" class="btn btn-success mx-auto" name="diagram" id="dia">Diagram</button>

                </div>
            </form>
            <table class="table table-striped">

                <?php if ($reszletes == 1) : ?>
                    <?php if (!empty($result)) : ?>
                        <thead>
                            <tr>
                                <th scope="col">Dátum</th>
                                <th scope="col">Partner neve</th>
                                <th scope="col">Számlaszám</th>
                                <th scope="col">Közlemeny</th>
                                <th scope="col">Összeg</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $utalas) : ?>
                                <tr>
                                    <td><?= $utalas["datum"] ?></td>
                                    <td><?= $utalas["partner_neve"] ?></td>
                                    <td><?= $utalas["partner_szamlaszam"] ?></td>
                                    <td><?= $utalas["kozlemeny"] ?></td>
                                    <?php if($utalas["jovairas"]==1):?>
                                        <td style="font-weight:bold;"><?= number_format((-1*$utalas["osszeg"]), 0, ".", " ") ?> Ft</td>
                                    <?php else : ?>
                                        <td style="font-weight:bold;"><?= number_format($utalas["osszeg"], 0, ".", " ") ?> Ft</td>
                                    <?php endif?>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    <?php elseif ($reszletes == 2) : ?>
                        <thead>
                            <tr>
                                <th scope="col">Partner neve</th>
                                <th scope="col">Számlaszám</th>
                                <th scope="col">Összeg</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($osszesitett_result)) : ?>
                                <?php foreach ($osszesitett_result as $utalas) : ?>
                                    <tr>
                                        <td><?= $utalas["partner_neve"] ?></td>
                                        <td><?= $utalas["partner_szamlaszam"] ?></td>
                                        <td style="font-weight:bold;"><?= number_format($utalas["osszeg"], 0, ".", " ") ?> Ft</td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                            <?php endif ?>
                        <?php endif ?>
                        </tbody>
            </table>
            <div>
                <p>Záró egyenleg: <?=number_format($zarasegyenleg[0]["egyenleg"], 0, ".", " ")?> Ft</p>
            </div>
        </div>
        <button onClick="window.print()" class="btn btn-success mx-auto mt-5 mb-5 d-print-none">Nyomtatás</button>
    </div>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>

</html>