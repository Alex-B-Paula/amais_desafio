<?php

# Função de criação de conexões com banco de dados
function database()
{
    $config = parse_ini_file('config.ini');

    $sql_server = $config["db_server"];
    $sql_user = $config["db_user"];
    $sql_pass = $config["db_password"];

    $conn = new mysqli($sql_server, $sql_user, $sql_pass);

    if ($conn->connect_error) {
        print("Erro de acesso ao banco de dados");
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}