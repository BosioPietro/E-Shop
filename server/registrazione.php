<?php
	require("MySQLi.php");
	$connection = openConnection("ernico");
	http_response_code(200);
	//Parametri
	if(isset($_POST["username"]))
	{
		$username = $connection->real_escape_string($_POST["username"]);
	}
	else
	{
		http_response_code(200);
		$connection->close();
		die(json_encode(["errore interno" => "parametro username non trovato"]));
	}
	if(isset($_POST["mail"]))
	{
		$mail = $connection->real_escape_string($_POST["mail"]);
	}
	else
	{
		http_response_code(200);
		$connection->close();
		die(json_encode(["errore interno" => "parametro mail non trovato"]));
	}
	if(isset($_POST["pwd"]))
	{
		$pwd = $connection->real_escape_string($_POST["pwd"]);
	}
	else
	{
		http_response_code(200);
		$connection->close();
		die(json_encode(["errore interno" => "parametro password non trovato"]));
	}

	$sql = "SELECT * FROM utenti WHERE username = '$username' OR email = '$mail'";

	$data = eseguiQuery($connection, $sql);

	if(count($data) > 0)
	{
		http_response_code(200);
		$connection->close();
		die(json_encode((["errore utente" => "E-Mail o username già utilizzati"])));
	}
	else
	{
		http_response_code(200);
		$sql = "INSERT INTO utenti (username, email, password) VALUES ('$username', '$mail', '$pwd')";
		eseguiQuery($connection, $sql);
		echo json_encode(["status" => "ok"]);
		session_start();
		$_SESSION["username"] = $username;
		$_SESSION["user_id"] = $data["id"];
		$_SESSION["scadenza"] = time() + TIME_OUT;
		setcookie(session_name(), session_id(), $_SESSION["scadenza"], "/");
	}

	$connection->close();
?>