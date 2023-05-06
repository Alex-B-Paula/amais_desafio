<?php
include "database.php";
include "curriculo.php";
include "confirmacao.php";
session_start();

$config = parse_ini_file('config.ini');

date_default_timezone_set("America/Sao_Paulo");
$errorMessage = "Erro no editar o curriculo";

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


    $curriculo = unserialize($_SESSION["curriculo"]);

    if($usuario != $curriculo->usuario){
        $sql = "SELECT * FROM {$config["db_schema"]}.curriculo WHERE Usuario = '{$usuario}'";
        $result = $conn->query($sql);

        if (($result->num_rows >= 1) || ($usuario == $config["admin_user"])) {
            $conn->close();
            salvar_progresso();
            header("Location: /usuario.php?erro=usuario", TRUE, 301);
            die();
        }
    }

    if($email != $curriculo->email) {
        $sql = "SELECT * FROM {$config["db_schema"]}.curriculo WHERE Email = '{$email}'";
        $result = $conn->query($sql);

        if (!$result) throw new \Exception('Erro no banco de dados');

        if ($result->num_rows >= 1) {
            $conn->close();
            salvar_progresso();
            header("Location: /usuario.php?erro=email", TRUE, 301);
            die();
        }
    }

    if($pass === null || trim($pass) === ''){

        $sql = "
    UPDATE {$config["db_schema"]}.curriculo
    SET Usuario = '{$usuario}', Email = '{$email}', Nome = '{$nome}', CPF = '{$cpf}', DataNascimento = '{$nascimento}',
        Sexo = '{$sexo}', EstadoCivil = '{$civil}', Escolaridade = '{$escolaridade}', Formacao = '{$formacao}',
        Experiencia = '{$experiencia}', Pretensao = {$pretensao}
    WHERE Usuario = '{$curriculo->usuario}'
    ";

    }
    else {
        $sql = "
    UPDATE {$config["db_schema"]}.curriculo
    SET Usuario = '{$usuario}', Email = '{$email}',Senha = '{$hash_pass}', Nome = '{$nome}', CPF = '{$cpf}', DataNascimento = '{$nascimento}',
        Sexo = '{$sexo}', EstadoCivil = '{$civil}', Escolaridade = '{$escolaridade}', Formacao = '{$formacao}',
        Experiencia = '{$experiencia}', Pretensao = {$pretensao}
    WHERE Usuario = '{$curriculo->usuario}'
    ";
    }

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

                confirmacao("Edição bem sucedida", "Seu currículo foi editado.", "/usuario.php");

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
