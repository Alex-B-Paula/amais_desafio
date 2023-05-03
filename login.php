<?php

include "database.php";
include "curriculo.php";

$errorMessage = "Erro algo logar o usuário";

try {

    $conn = database();

    if (count($_POST) == 0) throw new \Exception('Form is empty');

    $usuario = $_POST["usuario"];
    $pass = $_POST["senha"];
    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM desafio.curriculo WHERE Usuario = '{$usuario}'";
    $result = $conn->query($sql);

    if ($result) throw new \Exception('Erro no banco de dados');

    if ($result->num_rows == 1) {
        while ($row = $result->fetch_assoc()) {


            if (password_verify($pass, $row["Senha"])) {
                session_start();
                $logged = new curriculo();
                $logged->login = $row["Usuario"];
                $logged->email = $row["Email"];
                $logged->cpf = $row["CPF"];
                $logged->data_nascimento = $row[""];
                $logged->sexo = $row["Sexo"];
                $logged->estado_civil = $row["EstadoCivil"];
                $logged->escolaridade = $row["Escolaridade"];
                $logged->especializacao = $row["Especializações"];
                $logged->experiencia = $row["experiencia"];
                $logged->pretensao = $row["Pretensao"];
                $logged->data_envio = $row["DataEnvio"];

                $_SESSION["usuario"] = $logged;

                header("Location: /usuario",TRUE,301);

            } else {
                header("Location: /index.php?erro=login",TRUE,301);
                $conn->close();
                die();
            }

            echo "id: " . $row["id"] . " - Name: " . $row["firstname"] . " " . $row["lastname"] . "<br>";
        }
    } elseif ($result->num_rows > 1) {
        header("Location: /?erro=servidor",TRUE,302);
        $conn->close();
        die();
    } else {
        print("erro");
        header("Location: /?erro=login",TRUE,302);
        $conn->close();
        die();
    }
    $conn->close();

} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}
