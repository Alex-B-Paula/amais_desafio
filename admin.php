<?php
include "database.php";

session_start();

$config = parse_ini_file('config.ini');
$errorMessage = "Erro no sistema";

try {
    $conn = database();

    $sql = "SELECT Pretensao FROM {$config["db_schema"]}.curriculo";
    $result = $conn->query($sql);
    $pretensoes = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $pretensao = str_replace(",", ".", $row["Pretensao"]);
            $pretensao = floatval($pretensao);
            $pretensoes[] = $pretensao;
        }
        $pretensoes = array_filter($pretensoes);

        $soma_pretensao = array_sum($pretensoes);
        $soma_pretensao = number_format($soma_pretensao, 2, ',', '');
        $media_pretensao = array_sum($pretensoes) / count($pretensoes);
        $media_pretensao = number_format($media_pretensao, 2, ',', '');
    }

    if (!$result) throw new \Exception('Erro no banco de dados');

    $sql = "SELECT * FROM {$config["db_schema"]}.curriculo ORDER BY DataEnvio";
    $result = $conn->query($sql);


    if (!$result) throw new \Exception('Erro no banco de dados');


    $conn->close();

} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}


?>
<html lang="pt">

<head>
    <title>Cadastro de Curriculo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="js/script.js"></script>
</head>

<body>

<div class="container bg-light h-100">


    <div
        class="container bg-secondary-subtle h-100 justify-content-center align-items-center border border-light rounded-1">

        <div class="flex-row d-flex my-3">
            <h3>Cadastro de Currículos</h3>

            <div class="card ms-auto" style="width: 70%;">
                <div class="card-body text-center">
                    <h6 class="card-subtitle mb-2 text-body-secondary">Soma de Pretensões: R$ <?= $soma_pretensao ?> -- Média de Pretensões: R$ <?= $media_pretensao ?></h6>

                </div>
            </div>

            <a href="index.php" class="text-decoration-none h1 ms-auto"><i class="bi bi-arrow-return-left"></i></a>

        </div>

            <?php
            if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $pretensao = str_replace(",", ".", $row["Pretensao"]);
                $pretensao = floatval($pretensao);
                $pretensao_texto = number_format($pretensao, 2, ',', '');

                if ($pretensao > $media_pretensao){
                    $cor_pretensao = "Blue";
                }
                else {
                    $cor_pretensao = "Green";
                }


                echo
                <<<END
            <div class="card my-1" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">Candidato: {$row["Nome"]}</h5>
                    <h6 class="card-subtitle mb-2 w-25" Style="background: {$cor_pretensao}; color: white;">Pretensão Salarial: R$ {$pretensao_texto}</h6>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Data e hora de envio: {$row["DataEnvio"]}</h6>
                    <a href="#{$row["Usuario"]}"  data-bs-toggle="modal" class="card-link ">Veja Curriculo</a>
                </div>
            </div>

            <div class="modal" id="{$row["Usuario"]}" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{$row["Nome"]}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                  
                        
                <div class="row d-flex">
                    <div class="col">
                        <p>Email: {$row["Email"]}</p>
                    </div>
                    <div class="col">
                        <p>Email: {$row["CPF"]}</p>
                    </div>
                </div>
                
                <div class="row d-flex">
                    <div class="col">
                        <p>Email: {$row["DataNascimento"]}</p>
                    </div>
                    <div class="col">
                        <p>Email: {$row["Sexo"]}</p>
                    </div>
                </div>
                
                <div class="row d-flex">
                    <div class="col">
                        <p>Email: {$row["EstadoCivil"]}</p>
                    </div>
                    <div class="col">
                        <p>Email: {$row["Escolaridade"]}</p>
                    </div>
                </div>
                
                <p>Pretensão Salarial: {$row["Pretensao"]}</p>
                
                
                <p>Formação - Especializações</p>
                <p>{$row["Formacao"]}</p>
                
                <p>Experiência Profissional</p>
                <p>{$row["Experiencia"]}</p>
                
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            END;
            }
            }
            else {
                echo "<h2>Sem Currículos</h2>";
            }

            ?>


    </div>
</div>




<script type='text/javascript'>

    let erro = GetURLParameter('erro');

    if (erro == "login") {
        $(document).ready(function () {
            $('#aviso_erro').hide();
        });
    } else if (erro == "servidor") {
        $(document).ready(function () {
            $('#aviso_login').hide();
        });
    } else {
        $(document).ready(function () {
            $('#aviso_login').hide();
            $('#aviso_erro').hide();
        });
    }

</script>


</body>

</html>