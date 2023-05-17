<?php
session_start();
unset($_SESSION["aktiv"]);
unset($_SESSION["id"]);

header('Location: index.php');

?>