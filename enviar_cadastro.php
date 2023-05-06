<?php
include "database.php";
include "curriculo.php";
include "confirmacao.php";
session_start();

$config = parse_ini_file('config.ini');

date_default_timezone_set("America/Sao_Paulo");
$errorMessage = "Erro no envio do Currículo";

function salvar_progresso()
{
    $_SESSION["usuario"] = $_POST["usuario"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["nome"] = $_POST["nome"];
    $_SESSION["cpf"] = $_POST["cpf"];
    $_SESSION["nascimento"] = $_POST["nascimento"];
    $_SESSION["sexo"] = $_POST["sexo"];
    $_SESSION["estado_civil"] = $_POST["estado_civil"];
    $_SESSION["escolaridade"] = $_POST["escolaridade"];
    $_SESSION["formacao"] = $_POST["formacao"];
    $_SESSION["experiencia"] = $_POST["experiencia"];
    $_SESSION["pretensao"] = $_POST["pretensao"];
}

try {

    $conn = database();

    if (count($_POST) == 0) throw new \Exception('Form is empty');

    $usuario = $_POST["usuario"];
    $pass = $_POST["senha"];
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
    $data_envio = date("Y-m-d H-i-s");


    $sql = "SELECT * FROM {$config["db_schema"]}.curriculo WHERE Usuario = '{$usuario}'";
    $result = $conn->query($sql);

    if (($result->num_rows >= 1) || ($usuario == $config["admin_user"])) {
        $conn->close();
        salvar_progresso();
        header("Location: /cadastro.php?erro=usuario", TRUE, 301);
        die();
    }

    $sql = "SELECT * FROM {$config["db_schema"]}.curriculo WHERE Email = '{$email}'";
    $result = $conn->query($sql);

    if (!$result) throw new \Exception('Erro no banco de dados');

    if ($result->num_rows >= 1) {
        $conn->close();
        salvar_progresso();
        header("Location: /cadastro.php?erro=email", TRUE, 301);
        die();
    }

    $sql = "INSERT INTO {$config["db_schema"]}.curriculo (Usuario, Email, Senha, Nome, CPF, DataNascimento, Sexo, 
                               EstadoCivil, Escolaridade, 
                               Formacao, Experiencia, Pretensao, DataEnvio) VALUES ('{$usuario}', '{$email}', 
                                                                                    '{$hash_pass}', '{$nome}', '{$cpf}', 
                                                                                    '{$nascimento}', '{$sexo}', 
                                                                                    '{$civil}', '{$escolaridade}', 
                                                                                    '{$formacao}', '{$experiencia}', 
                                                                                    '{$pretensao}', '{$data_envio}')";

    $result = $conn->query($sql);

    if (!$result) throw new \Exception('Erro no banco de dados');

    $sql = "SELECT * FROM {$config["db_schema"]}.curriculo WHERE Usuario = '{$usuario}'";
    $result = $conn->query($sql);
    $conn->close();

    if (!$result) throw new \Exception('Erro no banco de dados');

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {


            if (password_verify($pass, $row["Senha"])) {
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
                $logged->experiencia = $row["Experiencia"];
                $logged->pretensao = $row["Pretensao"];
                $logged->data_envio = $row["DataEnvio"];

                $_SESSION = array();
                $_SESSION["curriculo"] = serialize($logged);

                confirmacao("Cadastro bem sucedido", "Seu currículo foi enviado! Boa sorte!", "/usuario.php");

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
