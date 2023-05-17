<?php
include("../class/user.php");
include("../class/utalas.php");

session_start();
$user = new User($_SESSION["aktiv"]);
$user->setActiveFolyoszamla($_SESSION["id"]);

if (isset($_POST["utalas"])) {
    $utalas = new Utalas($_POST["szamlaszam"], $_POST["kozlemeny"], $_POST["osszeg"], $_POST["partner"], $user->getActiveFolyoszamla());
    $utalas->utalasUpload();
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
    <title>Utalás</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navigacio mx-auto col-8">
        <span><a class="navbar-brand text-white float-end" href="fooldal.php" style="padding:0 0 0 16px;">Vissza</a></span>
    </nav>
    <div class="container form-bg shadow rounded mt-5 col-8 mb-5">
        <h4 class="pt-4">Utalás</h4>
        <div class="row" id="sikeresutalas">
            <form action="" method="post">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6 pt-3">
                            <label class="control-label" for="exampleInputFirstName2">Számlaszám</label>
                            <input type="text" placeholder="00000000-00000000-00000000" class="form-control mx-auto" name="szamlaszam" value="" required>
                        </div>
                        <div class="col-5 pt-3 mx-auto">
                            <label for="exampleFormControlSelect1">Partner</label>
                            <input type="text" class="form-control mx-auto" name="partner" value="" required>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-5 pt-3 mx-auto">
                            <label class="control-label" for="osszeg">Összeg</label>
                            <input type="text" class="form-control mx-auto" name="osszeg" value="" required>
                        </div>
                    </div>
                    <hr class="bg-success mt-5">
                    <h5 class="text-center pt-3 pb-3">Közlemény</h5>
                    <div class="row mx-auto">
                        <div class="col-10 pt-6 mx-auto">
                            <input type="text" class="form-control rounded  mx-auto" name="kozlemeny" required>
                        </div>
                        <hr class="bg-success mt-5">
                        <div class="col-6 pt-3 mx-auto">
                            <h5 class="text-center pt-3 pb-3">Saját számla</h5>
                        </div>
                        <div class="row mx-auto w-100">
                            <?php if ($user->getActiveFolyoszamla()->getHitelszamla() == 0) : ?>
                                <div class="col-12 mt-5">Számlaszám: <?= $user->getActiveFolyoszamla()->getSzamlaszam(); ?></div>
                                <div class="col-3 mx-auto mt-3">Hitelkeret: <?= number_format($user->getActiveFolyoszamla()->getHitelkeret(), 0, ".", " ") . " Ft"; ?></div>
                            <?php else : ?>
                                <div class="col-12 mt-5">Számlaszám: <?= $user->getActiveFolyoszamla()->getSzamlaszam(); ?></div>
                                <div class="col-3 mx-auto mt-3">Egyenleg: <?= number_format($user->getActiveFolyoszamla()->getEgyenleg(), 0, ".", " ") . " Ft"; ?></div>
                            <?php endif ?>
                        </div>
                        <div class="col-5 pt-5 text-center mx-auto pb-5">
                            <button onclick="confirm('Biztosan elutalja?')" class="btn btn-success tovabbbtn mt-4 mx-auto" name="utalas" id="utal">Utalás indítása</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>