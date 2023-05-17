<?php
require "../class/user.php";
session_start();
$user = new User($_SESSION["aktiv"]);
$user->setActiveFolyoszamla($_SESSION["id"]);
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
    <title>Főoldal</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navigacio mx-auto col-10">
        <span class="mx-auto">Kiválasztott számla: <?php echo $user->getActiveFolyoszamla()->getSzamlaszam(); ?></span>
        <span><a class="navbar-brand text-white" href="folyoszamlalista.php">Számla váltás</a></span>
    </nav>
    <div class="container-fluid col-8 mt-10 pt-5">
        <div class="row card-group">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 dropdown" style="min-height:400px;">
                <div class="card dropbtn">
                    <img class="card-img-top" src="../img/utalas.png" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-white">Utalások</h4>
                    </div>
                    <ul class="list-group list-group-flush dropdown">
                        <div class="dropdown-content dc">
                            <li class="list-group-item"><a href="utalasPage.php">Utalás</a></li>
                            <li class="list-group-item"><a href="korabbiutalasok.php">Korábbi utalások</a></li>
                            <li class="list-group-item"><a href="szamlatortenet.php">Számlatörténet lekérése</a></li>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 dropdown" style="min-height:400px">
                <div class="card dropbtn">
                    <img class="card-img-top" src="../img/idopont.png" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-white">Időpontok</h4>
                    </div>
                    <ul class="list-group list-group-flush dropdown-content dc">
                        <li class="list-group-item"><a href="idopontfoglalas.php">Időpont foglalás</a></li>
                        <li class="list-group-item"><a href="foglaltIdopontok.php">Lefoglalt időpontjaim</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 dropdown" style="min-height:400px">
                <div class="card dropbtn">
                    <img class="card-img-top" src="../img/kolcson.png" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-white">Kölcsönök</h4>
                    </div>
                    <ul class="list-group list-group-flush dropdown-content dc">
                        <li class="list-group-item"><a href="kolcsoneim.php">Kölcsöneim</a></li>
                        <li class="list-group-item"><a href="ujkolcson.php">Új kölcsön igénylése</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 dropdown" style="min-height:400px">
                <div class="card dropbtn">
                    <img class="card-img-top" src="../img/beallitasok.png" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-white">Beállítások</h4>
                    </div>
                    <ul class="list-group list-group-flush dropdown-content dc">
                        <li class="list-group-item"><a href="profilepage.php">Saját adatok módosítása</a></li>
                        <li class="list-group-item"><a href="husegpontjaim.php">Hűségpontjaim</a></li>
                        <li class="list-group-item"><a href="partnerek.php">Partner lista</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>