<?php
session_start();
require "../class/database.php";
$msg="";
if(isset($_SESSION["msg"])){
    $msg = $_SESSION["msg"];
    unset($_SESSION["msg"]);
}
$db = new Database();
$db->connect();

$sql = "SELECT * FROM `idopont_foglalas` INNER JOIN `ugytipus` ON `idopont_foglalas`.`ugytipus` = `ugytipus`.`id` WHERE `felhasznalo` = '" . $_SESSION["aktiv"] . "'";
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
    <title>Foglalt időpontjaim</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navigacio mx-auto col-8">
        <a class="navbar-brand text-white ml-auto" href="fooldal.php" style="padding:0 0 0 16px;">Vissza</a>
    </nav>
    <div class="container form-bg shadow rounded mt-5 col-8 mb-5">
        <?=$msg?>
        <h5 class="pt-3 pb-3">Foglalt időpontjaim</h5>
        <div class="row" id="sikeresutalas">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Dátum</th>
                        <th scope="col">Időpont</th>
                        <th scope="col">Ügytípus</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $utalas) : ?>
                        <tr>
                            <td><?= $utalas["datum"] ?></td>
                            <td><?= $utalas["idopont"] ?></td>
                            <td><?= $utalas["ugytipus_megnevezes"] ?></td>
                            <td><button type="submit" class="kivalaszt" style="vertical-align:middle" name="kivalaszt" id="<?= $utalas["datum"] . "#" . $utalas["idopont"] ?>" value="<?= $utalas["datum"] . "#" . $utalas["idopont"] ?>" onclick="torol('<?= $utalas["datum"] . "#" . $utalas["idopont"] ?>')"><span>Töröl</span></button></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function torol(e) {
            if (confirm("Biztosan törölni szeretné?") == true) {
                var torolni = document.getElementById(e).value;
                const myArray = torolni.split("#");
                console.log(myArray[0]);
                var url = "idoponttorles.php"
                $.ajax({
                        method: "POST",
                        url: url,
                        data: {
                            datum: myArray[0],
                            idopont: myArray[1]
                        }
                    })
                    .done(function(msg) {
                        location.reload();
                    });
            }
        }
    </script>


</body>

</html>