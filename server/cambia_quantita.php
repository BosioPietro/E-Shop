<?php
	require("MySQLi.php");

	$connection = openConnection("ernico");
	http_response_code(200);
	if(!isset($_POST["user"]) || !isset($_POST["prodotto"]) || !isset($_POST["quantita"])){
        die(json_encode(["errore interno" => "parametri non trovati"]));
    }
    $user = $connection->real_escape_string($_POST["user"]);
    $prodotto = $connection->real_escape_string($_POST["prodotto"]);
    $quantita = $connection->real_escape_string($_POST["quantita"]);

    if($quantita < 0){
        die(json_encode(["errore" => "quantità non valida"]));
    }

    $query = "SELECT quantita FROM prodotti WHERE id = '$prodotto'";
    $data = eseguiQuery($connection, $query);
    $masssima = $data[0]["quantita"];


    if($quantita > $masssima){
        die(json_encode(["errore" => "quantità massima raggiunta"]));
    }

    $query = "UPDATE carrello SET quantita = '$quantita' WHERE user = '$user' AND prodotto = '$prodotto'";
    eseguiQuery($connection, $query);
    echo json_encode(["ok" => $masssima]);

	$connection->close();
?>