<?php
	require("MySQLi.php");

	$connection = openConnection("ernico");
	http_response_code(200);
	if(!isset($_POST["user"]) || !isset($_POST["prodotto"])){
        die(json_encode(["errore interno" => "parametri non trovati"]));
    }
    $user = $connection->real_escape_string($_POST["user"]);
    $prodotto = $connection->real_escape_string($_POST["prodotto"]);
   
    $query = "DELETE FROM carrello WHERE user = '$user' AND prodotto = '$prodotto'";
    $result = eseguiQuery($connection, $query);
    if(!$result){
        die(json_encode(["errore interno" => "query non eseguita"]));
    }
    echo json_encode(["ok" => "Prodotto rimosso"]);
	$connection->close();
?>