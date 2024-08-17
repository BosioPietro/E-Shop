<?php
	require("MySQLi.php");

	$connection = openConnection("ernico");
	http_response_code(200);
	//Parametri
	$mod = "Email";
	if(isset($_REQUEST["username"]))
	{
		$utente = $connection->real_escape_string($_REQUEST["username"]);
		$mod = "Username";
	}
	else
	{
		if(isset($_REQUEST["mail"]))
		{
			$utente = $connection->real_escape_string($_REQUEST["mail"]);
		}
		else
		{
			http_response_code(200);
			$connection->close();
			die(json_encode(["errore interno" => "parametri mail e user non trovati"]));
		}	
	}
	if(isset($_REQUEST["pwd"]))
	{
		$pwd = $connection->real_escape_string($_REQUEST["pwd"]);
	}
	else
	{
		http_response_code(200);
		$connection->close();
		die(json_encode(["errore interno" => "parametro password non trovato"]));
	}

	$sql = "SELECT username FROM utenti WHERE $mod = '$utente'";

	$data = eseguiQuery($connection, $sql);

	if(count($data) == 0)
	{
		http_response_code(200);
		$connection->close();
		die(json_encode((["errore utente" => "$mod non esistente"])));
	}
	http_response_code(200);
	$sql = "SELECT username, id FROM utenti WHERE $mod = '$utente' AND password = '$pwd'";
	$data = eseguiQuery($connection, $sql);
	if(count($data) == 0)
	{
		http_response_code(200);
		$connection->close();
		die(json_encode((["errore utente" => "Password errata"])));
	}
	$data = $data[0];
	echo json_encode(["status" => "ok"]);
	session_start();
	$_SESSION["username"] = $data["username"];
	$_SESSION["user_id"] = $data["id"];
	$_SESSION["scadenza"] = time() + TIME_OUT;
	setcookie(session_name(), session_id(), $_SESSION["scadenza"], "/");

	$connection->close();
?>