<?php
	require("MySQLi.php");

	$connection = openConnection("ernico");
	http_response_code(200);
	if(!isset($_POST["user"]) || !isset($_POST["prodotto"]) || !isset($_POST["testo"]) || !isset($_POST["rating"])){
        die(json_encode(["errore interno" => "parametri non trovati"]));
    }
    $user = $connection->real_escape_string($_POST["user"]);
    $prodotto = $connection->real_escape_string($_POST["prodotto"]);
    $testo = $connection->real_escape_string($_POST["testo"]);
    $rating = $connection->real_escape_string($_POST["rating"]);
    $query = "SELECT * FROM recensioni WHERE user = '$user' AND prodotto = '$prodotto'";
    $data = eseguiQuery($connection, $query);
    if(count($data) > 0){
        $query = "UPDATE recensioni SET testo = '$testo', rating = '$rating' WHERE user = '$user' AND prodotto = '$prodotto'";
        eseguiQuery($connection, $query);
        echo json_encode(["status" => "ok"]);
    }else{
        $query = "INSERT INTO recensioni (user, prodotto, testo, rating) VALUES ('$user', '$prodotto', '$testo', '$rating')";
        eseguiQuery($connection, $query);
        echo json_encode(["status" => "ok"]);
    }
	$connection->close();
?>