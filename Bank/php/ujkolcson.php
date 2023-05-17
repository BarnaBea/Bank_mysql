<?php

session_start();

require "../class/kolcson.php";
require "../class/user.php";
$user = new User($_SESSION["aktiv"]);

if (isset($_POST["submit"])) {
    $kolcson = new Kolcson($_POST["igenyeltosszeg"], $_POST["futamido"], $_POST["jovedelem"], $_POST["telefonszam"], $_POST["email"], $_SESSION["aktiv"], $user->getDB());
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
    <title>Új kölcsön</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navigacio mx-auto col-8">
        <a class="navbar-brand text-white ml-auto" href="fooldal.php" style="padding:0 0 0 16px;">Vissza</a>
    </nav>
    <div class="container shadow mt-5 col-8 mb-5">
        <h4 class="pt-4 pb-3">Kölcsön igénylés</h4>
        <?php if (isset($kolcson)) : ?>
            <?php if ($kolcson->getSikeres()) : ?>
                <div class="alert alert-success"><?php echo $kolcson->getElfogadva(); ?></div>
            <?php else : ?>
                <div class="alert alert-danger"><?php echo $kolcson->getElutasitva(); ?></div>
            <?php endif ?>
        <?php endif ?>
        <form action="" class="mx-auto" method="post">
            <div class="form-row">
                <div class="input-group pt-5">
                    <label for="customRange3" class="form-label">Felvenni kívánt összeg</label>
                    <input type="range" class="form-range" value="50000" min="50000" max="1500000" step="50000" oninput="this.nextElementSibling.value = this.value" id="customRange3" name="igenyeltosszeg" required>
                    <output>50000</output>
                </div>
            </div>
            <div class="form-row mx-auto">
                <div class="input-group mb-3 pt-5 mx-auto">
                    <select class="custom-select col-10 rounded pt-2 pb-2 mx-auto" id="inputGroupSelect01" name="futamido">
                        <option value="12" selected>12 hónap</option>
                        <option value="24">24 hónap</option>
                        <option value="36">36 hónap</option>
                        <option value="48">48 hónap</option>
                        <option value="72">72 hónap</option>
                    </select>
                    <select class="custom-select col-10 mt-5 pt-2 pb-2 rounded mx-auto" id="inputGroupSelect02">
                        <option value="szemelyikolcson" selected>Szabadon felhasználható személyi kölcsön</option>
                        <option value="lakashitel">Lakás hitel</option>
                        <option value="aruhitel">Áru vásárlási hitel</option>
                    </select>
                </div>
                <div class="input-group pt-5">
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="jovedelem" required>
                    <div class="input-group-append">
                        <span class="input-group-text mt-3 rounded">havi nettó jövedelem</span>
                    </div>
                </div>
                <div class="input-group pt-5">
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="telefonszam" value="<?= $user->getTelefon() ?>" required readonly>
                    <div class="input-group-append">
                        <span class="input-group-text mt-3">telefonszám</span>
                    </div>
                </div>
                <div class="input-group pt-5">
                    <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="email" value="<?= $user->getEmail() ?>" required readonly>
                    <div class="input-group-append">
                        <span class="input-group-text mt-3">e-mail</span>
                    </div>
                </div>
            </div>
            <button class="btn btn-success mb-5 mt-5" type="submit" name="submit">Igénylés</button>

        </form>
    </div>

</body>

</html>