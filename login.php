<?php
include "database.php";
include "curriculo.php";
session_start();


$config = parse_ini_file('config.ini');
$errorMessage = "Erro algo logar o usuário";

try {
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

                $_SESSION["curriculo"] = serialize($logged);
                
                header("Location: /usuario.php",TRUE,301);

            } else {
                
                header("Location: /index.php?erro=login",TRUE,301);
                
                die();
            }

        }
    } elseif ($result->num_rows > 1) {
        header("Location: /?erro=servidor",TRUE,302);
        
        die();
    } else {
        print("erro");
        header("Location: /?erro=login",TRUE,302);
        
        die();
    }
    

} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}
