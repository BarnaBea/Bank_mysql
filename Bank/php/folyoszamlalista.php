<?php
require "../class/user.php";
session_start();
$user = new User($_SESSION["aktiv"]);
if (isset($_POST['kivalaszt'])) {


    $_SESSION['id'] = $_POST['kivalaszt'];

    header('Location: fooldal.php');
}
?>


<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Domine&family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Folyószámláim</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navigacio col-8 mx-auto mb-4">
        <p class="mx-auto mt-2">Folyószámláim</p>
        <a class="navbar-brand text-white" href="kijelentkezes.php" style="padding:0 0 0 16px;">Kijelentkezés</a>
    </nav>
    <div class="container col-8">
        <div class="row">
            <div class="col-12">
                <form action="" method="post">
                    <div id="fszamlak"><?php $user->showFolyoszamlak(); ?></div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>