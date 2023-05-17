<?php
session_start();
require "../class/database.php";

$db = new Database();
$db->connect();

$sql = 'SELECT * FROM `kolcson` WHERE `felhasznalo` = "' . $_SESSION["aktiv"] . '" ORDER BY `datum` DESC';
$result = $db->getData($sql);

$sql = 'SELECT SUM(`visszafizetendo`/`futamido`) as `osszeg`,(SELECT `szamlaszam` FROM `folyoszamla` WHERE `felhasznalo` = "' . $_SESSION["aktiv"] . '" AND `egyenleg` > 0) as `szamla` FROM `kolcson` WHERE `felhasznalo` = "' . $_SESSION["aktiv"] . '" group BY `szamla`';
$havi = $db->getData($sql);
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
    <title>Kölcsönök</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navigacio mx-auto col-8">
        <a class="navbar-brand text-white ml-auto" href="fooldal.php" style="padding:0 0 0 16px;">Vissza</a>
    </nav>
    <div class="container form-bg shadow rounded mt-5 col-8 mb-5">
        <div class="row" id="sikeresutalas">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Dátum</th>
                        <th scope="col">thm</th>
                        <th scope="col">Futamidő</th>
                        <th scope="col">Felvett összeg</th>
                        <th scope="col">Visszafizetendő üsszeg</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $kolcson) : ?>
                        <tr>
                            <td><?= $kolcson["datum"] ?></td>
                            <td><?= $kolcson["thm"] ?></td>
                            <td><?= $kolcson["futamido"] ?></td>
                            <td><?= number_format($kolcson["felvett_osszeg"], 0, ".", " ") ?> Ft</td>
                            <td><?= number_format($kolcson["visszafizetendo"], 0, ".", " ") ?> Ft</td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container form-bg shadow rounded mt-5 col-8 mb-5">
        <div class="row" id="sikeresutalas">
            <table class=" ">
                <tr>
                    <td>Összesített törlesztőrészletek: <?= number_format($havi[0]["osszeg"], 0, ".", " ") ?> Ft/hó</td>
                </tr>
                <tr>
                    <td>
                        A havi törlesztőket az alábbi számlaszámról vonjuk le: <?= $havi[0]["szamla"]; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>