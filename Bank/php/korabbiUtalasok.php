<?php
session_start();
require "../class/database.php";

$db = new Database();
$db->connect();

$sql = "SELECT * FROM `utalas` INNER JOIN `partner` ON `utalas`.`partner_szamlaszam` = `partner`.`partner_szamlaszam` WHERE `folyoszamla` = " . $_SESSION["id"] . " AND `jovairas` = 1 ORDER BY `datum` DESC LIMIT 8";
$result = $db->getData($sql);

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
    <title>Korábbi utalások</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navigacio mx-auto col-8">
        <a class="navbar-brand text-white ml-auto" href="fooldal.php" style="padding:0 0 0 16px;">Vissza</a>
    </nav>
    <div class="container form-bg shadow rounded mt-5 col-8 mb-5">
        <h5 class="pt-3 pb-3">Korábbi utalások</h5>
        <div class="row" id="sikeresutalas">
            <table class="table table-striped">
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
                            <td style="font-weight:bold;"><?= number_format($utalas["osszeg"], 0, ".", " ") ?> Ft</td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>