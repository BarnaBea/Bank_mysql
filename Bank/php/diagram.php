<?php
require "../class/database.php";

$db = new Database();
$db->connect();
session_start();
$i = 0;
$kezdet = $_SESSION["start"];
$veg = $_SESSION["end"];
$sql = "SELECT `partner`.`partner_neve` ,`utalas`.`partner_szamlaszam`, SUM(`osszeg`) AS `osszeg` FROM `utalas` INNER JOIN `partner` ON `utalas`.`partner_szamlaszam` = `partner`.`partner_szamlaszam` WHERE `folyoszamla` = " . $_SESSION["id"] . " AND `datum` BETWEEN '" . $kezdet . "' AND '" . $veg . "' GROUP BY `partner`.`partner_szamlaszam`";
$osszesitett_result = $db->getData($sql);
foreach ($osszesitett_result as $key) {
	$dataPoints[$i]["y"] = $key["osszeg"];
	$dataPoints[$i]["label"] = $key["partner_neve"];
	$i++;
}
?>
<!DOCTYPE HTML>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Domine&family=Roboto:wght@100&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Muli:wght@500&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../css/style.css">
	<title>Diagram</title>
	<script>
		window.onload = function() {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				theme: "light2",
				title: {
					text: "Utalások"
				},
				axisY: {
					title: "Utalt összeg (Ft)"
				},
				data: [{
					type: "column",
					yValueFormatString: "#,##0.## Ft",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

		}
	</script>
</head>

<body>
	<nav class="navbar navbar-expand-lg navigacio mx-auto col-8">
		<a class="navbar-brand text-white ml-auto" href="szamlatortenet.php" style="padding:0 0 0 16px;">Vissza</a>
	</nav>
	<div class="col-8 mt-5 mx-auto shadow border border-success rounded">
		<div id="chartContainer" class="rounded border" style="height: 370px; width: 100%;"></div>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	</div>
</body>

</html>