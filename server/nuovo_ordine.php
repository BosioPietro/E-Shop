<?php
	require("MySQLi.php");

	$connection = openConnection("ernico");
	http_response_code(200);
	if(!isset($_POST["user"]) || !isset($_POST["prodotti"])){
        die(json_encode(["errore interno" => "parametri non trovati"]));
    }
    $user = $connection->real_escape_string($_POST["user"]);
    $prodotti = $_POST["prodotti"];

    $query = "INSERT INTO ordini (user) VALUES ($user)";
    $data = eseguiQuery($connection, $query);
    $id = mysqli_insert_id($connection);
    foreach($prodotti as $prodotto){
        // $prodotto = json_decode($prodotto[0], true);
        $prodotto = $prodotto[0];
        
        $query = "SELECT quantita FROM prodotti WHERE id = $prodotto[prodotto]";
        $data = eseguiQuery($connection, $query);
        $quantita = $data[0]["quantita"] - $prodotto["quantita"];
        if($quantita < 0){
            die(json_encode(["errore interno" => "errore quantita"]));
        }
        $query = "UPDATE prodotti SET quantita = $quantita WHERE id = $prodotto[prodotto]";
        eseguiQuery($connection, $query);

        $query = "INSERT INTO junction_ordine_prodotti (ordine, prodotto, quantita) VALUES ($id, $prodotto[prodotto], $prodotto[quantita])";
        eseguiQuery($connection, $query);
        $query = "DELETE FROM carrello WHERE user = $user AND prodotto = $prodotto[prodotto]";
        eseguiQuery($connection, $query);

    }
    echo json_encode(["id" => $id]);
	$connection->close();
?>