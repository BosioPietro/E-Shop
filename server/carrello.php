<?php
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: *");
	require("MySQLi.php");

	$connection = openConnection("ernico");
	http_response_code(200);
	if(!isset($_GET["user"])){
        die(json_encode(["errore interno" => "parametri non trovati"]));
    }
    $user = $connection->real_escape_string($_GET["user"]);

    $query = "SELECT prodotto, quantita FROM carrello WHERE user = '$user'";
    $data = eseguiQuery($connection, $query);
    echo json_encode(["ok" => $data]);

	$connection->close();
?>