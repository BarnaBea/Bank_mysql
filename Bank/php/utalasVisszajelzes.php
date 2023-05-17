<?php

require "../class/database.php";

$db = new Database();
$db->connect();

$sql = "SELECT * FROM `utalas` INNER JOIN `partner` ON `utalas`.`partner_szamlaszam` = `partner`.`partner_szamlaszam` ORDER BY `id` DESC LIMIT 1";
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
    <title>Sikeres utalás</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navigacio mx-auto col-8">
        <a class="navbar-brand text-white" href="utalasPage.php" style="padding:0 0 0 16px;">Vissza</a>
    </nav>
    <div class="container form-bg shadow rounded mt-5 col-8 mb-5">
        <div class="alert alert-green" role="alert">
            Sikeres utalás!
            <p>Részletek:</p>
        </div>
        <div class="row" id="sikeresutalas">
            <table class="table">
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
                    <tr>
                        <td><?= $result[0]["datum"] ?></td>
                        <td><?= $result[0]["partner_neve"] ?></td>
                        <td><?= $result[0]["partner_szamlaszam"] ?></td>
                        <td><?= $result[0]["kozlemeny"] ?></td>
                        <td><?= number_format($result[0]["osszeg"],0,","," ")?> Ft</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>