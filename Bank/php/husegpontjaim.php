<?php
session_start();
require "../class/database.php";

$db = new Database();
$db->connect();
$msg = "";
$sql = 'SELECT * FROM `husegprogram` WHERE `folyoszamla_id` = "' . $_SESSION["id"] . '"';
$result = $db->getData($sql);

$sql = 'SELECT SUM(`bevalthato_pontok`)+SUM(`felhasznalt_pontok`) as egyenleg FROM `husegprogram` WHERE `folyoszamla_id` = "' . $_SESSION["id"] . '"';
$egyenleg = $db->getData($sql);

if (isset($_POST["kivalaszt"])) {
    $sql = 'SELECT SUM(`bevalthato_pontok`)+SUM(`felhasznalt_pontok`) as egyenleg FROM `husegprogram` WHERE `folyoszamla_id` = "' . $_SESSION["id"] . '"';
    $egyenleg = $db->getData($sql);
    if ($egyenleg[0]["egyenleg"] >= $_POST["kivalaszt"]) {
        $sql = "INSERT INTO `husegprogram`(`bevalthato_pontok`, `felhasznalt_pontok`, `folyoszamla_id`) VALUES ('0','" . ($_POST["kivalaszt"] * -1) . "','" . $_SESSION["id"] . "')";
        $db->setData($sql);
        header('location:husegpontjaim.php');
    } else {
        $msg = "<div class='alert alert-danger'>Nincs elég beváltható pont!</div>";
    }
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
    <script src="https://kit.fontawesome.com/ef4c73c0c7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Hűségpontjaim</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navigacio mx-auto col-8">
        <a class="navbar-brand text-white ml-auto" href="fooldal.php" style="padding:0 0 0 16px;">Vissza</a>
    </nav>
    <div class="container form-bg shadow rounded mt-5 col-8 mb-5">
        <h4 class="pt-3 pb-3">Beváltható pontjaim</h4>
        <?= $msg ?>
        <div class="row" id="sikeresutalas">
            <form action="" method="POST">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td colspan="4">összes pontjaim: <?= $egyenleg[0]["egyenleg"] ?></td>
                        </tr>
                        <tr>
                            <td>Termék</td>
                            <td>Termék neve</td>
                            <td>Szükséges pontok</td>
                            <td>Bevált</td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-laptop" style="font-size:25px;"></i></td>
                            <td>Asus X513EA-1177W laptop</td>
                            <td>100 000</td>
                            <td><button type="submit" class="kivalaszt" style="vertical-align:middle" name="kivalaszt" value="100000" onclick="confirm('Biztosan beszeretné váltani pontjait?')"><span>Bevált</span></button></td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-bicycle" style="font-size:25px;"></i></td>
                            <td>Carpat Sport CSC26/99A Montana kerékpár</td>
                            <td>80 000</td>
                            <td><button type="submit" class="kivalaszt" style="vertical-align:middle" name="kivalaszt" value="80000" onclick="confirm('Biztosan beszeretné váltani pontjait?')"><span>Bevált</span></button></td>
                        </tr>
                        <tr>
                            <td><i class="fa-solid fa-mobile-screen-button" style="font-size:25px;"></i></td>
                            <td>Samsung Galaxy A03 Core</td>
                            <td>49 000</td>
                            <td><button type="submit" class="kivalaszt" style="vertical-align:middle" name="kivalaszt" value="49000" onclick="confirm('Biztosan beszeretné váltani pontjait?')"><span>Bevált</span></button></td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa-solid fa-plane" style="font-size:25px;"></i>
                            </td>
                            <td>Párizsi utazás 3 nap</td>
                            <td>150 000</td>
                            <td><button type="submit" class="kivalaszt" style="vertical-align:middle" name="kivalaszt" value="150000" onclick="confirm('Biztosan beszeretné váltani pontjait?')"><span>Bevált</span></button></td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa-solid fa-hippo" style="font-size:25px;"></i>
                            </td>
                            <td>Fővárosi állat- és növénykert belépő 2 fő részére</td>
                            <td>10 000</td>
                            <td><button type="submit" class="kivalaszt" style="vertical-align:middle" name="kivalaszt" value="10000" onclick="confirm('Biztosan beszeretné váltani pontjait?')"><span>Bevált</span></button></td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa-solid fa-book" style="font-size:25px;"></i>
                            </td>
                            <td>Libri könyvutalvány</td>
                            <td>15 000</td>
                            <td><button type="submit" class="kivalaszt" style="vertical-align:middle" name="kivalaszt" value="15000" onclick="confirm('Biztosan beszeretné váltani pontjait?')"><span>Bevált</span></button></td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa-solid fa-gamepad" style="font-size:25px;"></i>
                            </td>
                            <td>Nintendo Switch Light játékkonzol</td>
                            <td>89 000</td>
                            <td><button type="submit" class="kivalaszt" style="vertical-align:middle" name="kivalaszt" value="89000" onclick="confirm('Biztosan beszeretné váltani pontjait?')"><span>Bevált</span></button></td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa-solid fa-vr-cardboard" style="font-size:25px;"></i>
                            </td>
                            <td>Virtuális valóság élményajándék (1 óra)</td>
                            <td>5 000</td>
                            <td><button type="submit" class="kivalaszt" style="vertical-align:middle" name="kivalaszt" value="5000" onclick="confirm('Biztosan beszeretné váltani pontjait?')"><span>Bevált</span></button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

</body>

</html>