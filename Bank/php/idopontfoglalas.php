<?php
session_start();
require "../class/database.php";

$db = new Database();
$db->connect();
$msg = "";
if (isset($_POST["idopontfoglalas"])) {
    $datum = $_POST["datum"];
    if ($datum < date("Y-m-d")) {
        $msg = "<div class='alert alert-danger'>Visszamenőleg nem tud időpontot foglalni!</div>";
    } else if ($datum == date("Y-m-d")) {
        $msg = "<div class='alert alert-danger'>Időpontot nem lehetséges az aktuális napra foglalni, csak azt megelőzően, legalább 24 órával!</div>";
    } else {
        $idopont = $_POST["idopont"];
        $ugytipus = $_POST["ugytipus"];
        $sql = "SELECT `felhasznalo` FROM `idopont_foglalas` WHERE `datum` = '" . $datum . "' AND `idopont` = '" . $idopont . "'";
        $result = $db->getData($sql);
        if (empty($result)) {
            $sql = "INSERT INTO `idopont_foglalas`(`idopont`, `datum`, `ugytipus`, `felhasznalo`) VALUES ('" . $idopont . "','" . $datum . "','" . $ugytipus . "','" . $_SESSION["aktiv"] . "')";
            $db->setData($sql);
            $msg = "<div class='alert alert-success'>Sikeres időpont foglalás!</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Ez az időpont már foglalt, kérem válasszon másikat!</div>";
        }
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
    <link rel="stylesheet" href="../css/style.css">
    <title>Időpont foglalás</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg mx-auto col-8">
        <a class="navbar-brand text-white" href="fooldal.php" style="padding:0 0 0 16px;">Vissza</a>
    </nav>
    <div class="container shadow rounded mt-5 col-5 mb-5" style="min-width: 500px;">
        <div class="row" id="sikeresutalas">
            <?= $msg ?>
            <form action="" class="mx-auto shadow" method="post">
                <h5 class="text-center mt-3">Időpontfoglalás</h5>
                <div class="row">
                    <div class="form-group pt-5 col-10 mx-auto">
                        <label for="">Dátum</label>
                        <input class="form-control rounded" type="date" name="datum">
                    </div>
                    <div class="form-group col-10 mx-auto">
                        <label class="mt-5 mb-2">Időpont</label>
                        <select class="form-control" name="idopont">
                            <option value="8-10">08:00 - 10:00</option>
                            <option value="10-12">10:00 - 12:00</option>
                            <option value="12-14">12:00 - 14:00</option>
                            <option value="14-16">14:00 - 16:00</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-5 mb-5 col-10 mx-auto">
                    <label class="mb-2">Ügytípus</label>
                    <select class="form-control" name="ugytipus" id="exampleFormControlSelect1">
                        <option value="1">Folyószámlával kapcsolatos ügyek</option>
                        <option value="2">Adat módosítás</option>
                        <option value="3">Kölcsönnel kapcsolatos ügyintézés</option>
                        <option value="4">Hűségpontokkal kapcsolatos ügyintézés</option>
                        <option value="5">Egyéb</option>
                    </select>
                </div>
                <div class="pb-3 mt-2">
                    <button type="submit" class="btn btn-success float-left" name="idopontfoglalas">Időpontfoglalás</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>