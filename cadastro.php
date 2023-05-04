<?php
session_start();

?>
<html lang="pt">

<head>
    <title>Cadastro Currículo</title>
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


    <div class="container bg-secondary-subtle justify-content-center align-items-center border border-light rounded-1">

        <form id="contact-form" method="post" action="enviar_cadastro.php" role="form">


            <div class="form-group mt-4 mb-2  d-flex flex-column mx-2">

                <div class="flex-row d-flex">
                    <h3>Cadastro de Currículos</h3>

                    <a href="index.php" class="text-decoration-none h1 ms-auto"><i class="bi bi-arrow-return-left"></i></a>

                </div>

                <div class="row d-flex">

                    <div class="col">
                        <label for="form_usuario" class="mt-2">Usuário</label>
                        <input id="form_usuario" type="text" name="usuario" class="form-control"
                               placeholder="Usuario" required="required"
                               data-error="Usuario invalido" maxlength="10"
                               value="<?= $_SESSION['usuario'] ?? ""; ?>">
                        <div class="help-block with-errors"></div>
                        <p id="aviso_usuario" class="text-danger my-1">Usuário já existe</p>
                    </div>

                    <div class="col">
                        <label for="form_email" class="mt-2">Senha</label>
                        <input id="form_email" type="password" name="senha" class="form-control"
                               placeholder="Senha" required="required"
                               data-error="Senha invalida" minlength="8">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <label for="form_nome" class="mt-2">Nome</label>
                <input id="form_nome" type="text" name="nome" class="form-control"
                       placeholder="Nome" required="required"
                       data-error="Nome invalido" value="<?= $_SESSION['nome'] ?? ""; ?>">
                <div class="help-block with-errors"></div>

                <div class="row d-flex">
                    <div class="col">
                        <label for="form_email" class="mt-2">Email</label>
                        <input id="form_email" type="email" name="email" class="form-control"
                               placeholder="Usuario" required="required"
                               data-error="Email invalido" value="<?= $_SESSION['email'] ?? ""; ?>">
                        <div class="help-block with-errors"></div>
                        <p id="aviso_email" class="text-danger my-1">Email já existe</p>
                    </div>
                    <div class="col">
                        <label for="form_cpf" class="mt-2">CPF</label>
                        <input id="form_cpf" type="number" name="cpf" class="form-control"
                               placeholder="CPF" required="required"
                               data-error="CPF invalido" maxlength="11" value="<?= $_SESSION['cpf'] ?? ""; ?>">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="row d-flex">
                    <div class="col">
                        <label for="form_nascimento" class="mt-2">Data de Nascimento</label>
                        <input id="form_nascimento" type="date" name="nascimento" class="form-control"
                               placeholder="dd/mm/aaaa" required="required"
                               data-error="Data invalida" value="<?= $_SESSION['nascimento'] ?? ""; ?>">
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="col">
                        <label for="form_sexo" class="mt-2">Sexo</label>
                        <Select id="form_sexo" name="sexo" class="form-control"
                                required="required"
                                data-error="Escolha invalida">
                            <option selected>Selecione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                            <option value="Não informado">Prefiro Não Informar</option>
                        </Select>
                        <div class="help-block with-errors"></div>
                    </div>

                </div>

                <div class="row d-flex">
                    <div class="col">
                        <div class="col">
                            <label for="form_civil" class="mt-2">Estado Civil</label>
                            <Select id="form_civil" name="estado_civil" class="form-control"
                                    required="required"
                                    data-error="Escolha invalida">
                                <option selected>Selecione</option>
                                <option value="Solteiro">Solteiro</option>
                                <option value="Casado">Casado</option>
                                <option value="Separado">Separado</option>
                                <option value="Divorciado">Divorciado</option>
                                <option value="Viúvo">Viúvo</option>
                            </Select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col">
                        <label for="form_escolaridade" class="mt-2">Escolaridade</label>
                        <Select id="form_escolaridade" name="escolaridade" class="form-control"
                                required="required"
                                data-error="Escolha invalida">
                            <option selected>Selecione</option>
                            <option value="Ensino Fundamental">Ensino Fundamental</option>
                            <option value="Ensino Médio">Ensino Médio</option>
                            <option value="Ensino Superior">Ensino Superior</option>
                            <option value="Pós-graduação">Pós-graduação</option>
                            <option value="Mestrado">Mestrado</option>
                            <option value="Doutorado">Doutorado</option>
                        </Select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <label for="form_formacao" class="mt-2">Formação - Especializações</label>
                <textarea id="form_formacao" rows="10" name="formacao" class="form-control"
                          required="required" data-error="Texto invalido"></textarea>
                <div class="help-block with-errors">value="<?= $_SESSION['formacao'] ?? ""; ?>"</div>

                <label for="form_experiencia" class="mt-2">Experiência Profissional</label>
                <textarea id="form_experiencia" rows="10" name="experiencia" class="form-control"
                          required="required" data-error="Texto invalido"></textarea>
                <div class="help-block with-errors">value="<?= $_SESSION['experiencia'] ?? ""; ?>"</div>

                <label for="form_pretensao" class="mt-2">Pretensão Salarial</label>
                <input id="form_pretensao" type="number" name="pretensao" class="form-control"
                       placeholder="Pretensão Salarial" required="required"
                       data-error="Valor invalido" step="any" min="1"
                       value="value="<?= $_SESSION['pretensao'] ?? ""; ?>"">
                <div class="help-block with-errors"></div>

                <button type="submit" class="btn btn-primary ms-auto mt-3">Enviar</button>


            </div>

        </form>

    </div>
</div>

<script type='text/javascript'>

    let erro = GetURLParameter('erro');

    if (erro == "usuario") {
        $(document).ready(function () {
            $('#aviso_email').hide();
        });
    } else if (erro == "servidor") {
        $(document).ready(function () {
            $('#aviso_usuario').hide();
        });
    } else {
        $(document).ready(function () {
            $('#aviso_usuario').hide();
            $('#aviso_email').hide();
        });
    }

</script>

</body>

</html>