<?php

include "database.php";
include "curriculo.php";
$config = parse_ini_file('config.ini');

date_default_timezone_set("America/Sao_Paulo");
$errorMessage = "Erro no envio do Currículo";

try {

    $conn = database();

    if (count($_POST) == 0) throw new \Exception('Form is empty');

    $usuario = $_POST["usuario"];
    $pass = $_POST["senha"];

    if ($usuario == $config["admin_user"]){
        if ($pass == $config["admin_password"]){

            header("Location: /admin.php",TRUE,301);
        }
        else{

            header("Location: /index.php?erro=login",TRUE,301);
            die();
        }
    }

    $conn = database();
    $sql = "SELECT * FROM desafio.curriculo WHERE Usuario = '{$usuario}'";
    $result = $conn->query($sql);

    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $nascimento = $_POST["nascimento"];
    $sexo = $_POST["sexo"];
    $civil = $_POST["estado_civil"];
    $escolaridade = $_POST["escolaridade"];
    $formacao = $_POST["formacao"];
    $experiencia = $_POST["experiencia"];
    $pretensao = $_POST["pretensao"];
    $data = date("Y-m-d H-i-s");

    $sql = "INSERT INTO desafio.curriculo (Usuario, Email, Senha, Nome, CPF, DataNascimento, Sexo, 
                               EstadoCivil, Escolaridade, 
                               Formacao, Experiencia, Pretensao, DataEnvio) VALUES ('{$usuario}', '{$email}', 
                                                                                    '{$hash_pass}', '{$nome}', '{$cpf}', 
                                                                                    '{$nascimento}', '{$sexo}', 
                                                                                    '{$civil}', '{$escolaridade}', 
                                                                                    '{$formacao}', '{$experiencia}', 
                                                                                    '{$pretensao}', '{$data}')";


    $result = $conn->query($sql);

    if (!$result) throw new \Exception('Erro no banco de dados');

    $sql = "SELECT * FROM desafio.curriculo WHERE Usuario = '{$usuario}'";
    $result = $conn->query($sql);
    $conn->close();

    if (!$result) throw new \Exception('Erro no banco de dados');

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {


            if (password_verify($pass, $row["Senha"])) {
                session_start();
                $logged = new curriculo();
                $logged->usuario = $row["Usuario"];
                $logged->email = $row["Email"];
                $logged->nome = $row["Nome"];
                $logged->cpf = $row["CPF"];
                $logged->data_nascimento = $row["DataNascimento"];
                $logged->sexo = $row["Sexo"];
                $logged->estado_civil = $row["EstadoCivil"];
                $logged->escolaridade = $row["Escolaridade"];
                $logged->formacao = $row["Formacao"];
                $logged->experiencia = $row["experiencia"];
                $logged->pretensao = $row["Pretensao"];
                $logged->data_envio = $row["DataEnvio"];

                $_SESSION["curriculo"] = $logged;

                header("Location: /usuario", TRUE, 301);

            } else {
                header("Location: /index.php?erro=login", TRUE, 301);

                die();
            }

        }
    } elseif ($result->num_rows > 1) {
        header("Location: /?erro=servidor", TRUE, 302);

        die();
    } else {
        print("erro");
        header("Location: /?erro=login", TRUE, 302);

        die();
    }


} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}
