<?php
    session_start();
    http_response_code(200);
    if(isset($_SESSION["user_id"]))
    {
        echo json_encode(["user" => $_SESSION["user_id"]]);
    }
    else echo json_encode(["user" => ""]);
?>