<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <title>Bejelentkezés</title>
</head>

<body>
    <div class="container2">
        <h1>Bejelentkezés</h1>
        <form action="login.php" method="post">
            <div class="felhnev">
                <label for="">Személyi igazolvány szám</label><br>
                <input type="text" name="szigszam" required><br>
            </div>
            <div class="pwd">
                <label for="">Jelszó</label><br>
                <input type="password" name="jelszo" required>
            </div>
            <button type="reset" class="btn btn-success border-white mt-5">Mégse</button>
            <button type="submit" class="btn btn-success border-white mt-5 mx-2" name="login">Bejelentkezés</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>