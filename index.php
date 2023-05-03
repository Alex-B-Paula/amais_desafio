<html lang="pt">

<head>
    <title>Login para</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>

<body>


<div class="container bg-light h-100 d-flex align-items-center justify-content-center flex-column">


    <h3>Aplicação de cadastro de Currículos</h3>


    <div
        class="container w-25 bg-secondary-subtle d-flex flex-column mt-5 justify-content-center align-items-center border border-light rounded-1">


        <form id="contact-form" method="post" action="login.php" role="form">


            <div class="form-group d-flex flex-column">


                <label for="form_user" class="mt-2">Usuário</label>
                <input id="form_user" type="text" name="usuario" class="form-control" placeholder="Usuário"
                       required="required" data-error="Usuario invalido">
                <div class="help-block with-errors"></div>


                <label for="form_pass" class="mt-2">Senha</label>
                <input id="form_pass" type="password" name="senha" class="form-control" placeholder="Senha"
                       required="required" data-error="Senha invalida">
                <div class="help-block with-errors"></div>

                <p id="aviso_login" class="text-danger my-1">Usuário ou Senha incorretos.</p>
                <p id="aviso_erro" class="text-danger my-1">Erro no acesso ao servidor.</p>

                <button type="submit" class="btn btn-primary ms-auto my-3">Submit</button>
            </div>


        </form>
    </div>
</div>

<script type='text/javascript'>

    function GetURLParameter(sParam)
    {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++)
        {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam)
            {
                return sParameterName[1];
            }
        }
    }

    let erro = GetURLParameter('erro');

    if (erro == "login"){
        $(document).ready(function(){
            $('#aviso_erro').hide();
        });
    } else if(erro == "servidor") {
        $(document).ready(function () {
            $('#aviso_login').hide();
        });
    } else {
        $(document).ready(function(){
            $('#aviso_login').hide();
            $('#aviso_erro').hide();
        });
    }

</script>


</body>

</html>