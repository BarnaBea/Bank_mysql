<?php

session_start();

require "../class/user.php";

$user = new User($_SESSION["aktiv"]);

$msg = "";

if (isset($_POST["submit"])) {
    $user->updateUser($_POST["telefonszam"], $_POST["email"], $_FILES["profilkep"]);
    $msg = "<div class='alert alert-success'>Sikeres adatmódosítás!</div>";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Domine&family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Profilom</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navigacio mx-auto col-10">
        <a class="navbar-brand text-white" href="fooldal.php" style="padding:0 0 0 16px;">Vissza</a>
    </nav>
    <div class="container rounded mt-5 mb-5 col-9" style="max-width:700px;">
        <form action="" method="post" enctype="multipart/form-data">
            <h4 class="pt-3">Adataim</h4>
            <?= $msg ?>
            <table class="mx-auto">
                <tr>
                    <td>
                        <img class="rounded-circle" width="150px" src=<?=$user->getProfilkep(); ?>>
                    </td>
                    <td>
                        <label class="labels text-center pt-5">Személyi igazolvány szám</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="font-weight-bold"></span>
                        <span class="text-black-50"></span>
                        <span>
                            <input type="file" name="profilkep">
                        </span>
                    </td>
                    <td>
                        <input class="col-5 pt-5" type="text" class="form-control mx-auto" placeholder="experience" value="<?= $user->getSzigSzam() ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="pt-5 mx-auto">Vezetéknév</label>
                        <input type="text" class="form-control col-7 mx-auto pt-3" placeholder="first name" value="<?= $user->getVezeteknev() ?>" readonly>
                    </td>
                    <td>
                        <label class="pt-5 mx-auto">Keresztnév</label>
                        <input type="text" class="form-control col-7 mx-auto pt-3" value="<?= $user->getKeresztnev() ?>" placeholder="surname" readonly>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="labels mx-auto pt-5">Város</label>
                        <input type="text" class="form-control mx-auto" placeholder="enter address line 2" value="<?= $user->getVaros() ?>" readonly>
                    </td>
                    <td>
                        <label class="labels pt-5">Irányítószám</label>
                        <input type="text" class="form-control mx-auto" placeholder="enter address line 1" value="<?= $user->getIranyitoszam() ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label class="labels mx-auto pt-5">utca/házszám</label>
                        <input type="text" class="form-control mx-auto" placeholder="enter address line 2" value="<?= $user->getUtcaHazszam() ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="labels mx-auto pt-5">E-mail cím*</label>
                        <input type="text" class="form-control mx-auto" placeholder="enter address line 2" name="email" value="<?= $user->getEmail() ?>">
                    </td>
                    <td>
                        <label class="labels mx-auto pt-5">Telefonszám*</label>
                        <input type="text" class="form-control mx-auto" placeholder="enter phone number" name="telefonszam" value="<?= $user->getTelefon() ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button class="btn btn-success mt-5" type="submit" name="submit">Módosítás</button>
                    </td>
                </tr>
            </table>
            <br>
        </form>
        <footer>
            <p class="black" style="font-size:13px;">A csillaggal jelölt adatok módosíthatok, amennyiben szeretné adatait teljesmértékűen módosítani, kérjük látogasson el legközelebbi bankfiókunkba.</p>
        </footer>
    </div>
</body>

</html>