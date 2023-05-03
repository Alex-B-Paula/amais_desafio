<?php

function database()
{
    $sql_server = "localhost";
    $sql_user = "root";
    $sql_pass = "Ay95uhAvlVzKhkTU";

    $conn = new mysqli($sql_server, $sql_user, $sql_pass);

    if ($conn->connect_error) {
        print("Erro de acesso ao banco de dados");
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}