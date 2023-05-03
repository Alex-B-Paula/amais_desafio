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
    <link href='custom.css' rel='stylesheet' type='text/css'>
</head>

<body>


<div class="container bg-light h-100 d-flex align-items-center justify-content-center flex-column">


    <h3>Aplicação de cadastro de Currículos</h3>


    <div class="container w-25 h-25 bg-secondary-subtle d-flex flex-column mt-5 justify-content-center align-items-center border border-light rounded-1">


        <form id="contact-form" method="post" action="usuario.php" role="form">


            <div class="form-group d-flex flex-column">

                <label for="form_email" class="mt-2">Email</label>
                <input id="form_email" type="email" name="email" class="form-control"
                       placeholder="Usuario" required="required"
                       data-error="Email invalido">
                <div class="help-block with-errors"></div>


                <label for="form_email" class="mt-2">Senha</label>
                <input id="form_email" type="password" name="senha" class="form-control"
                       placeholder="Senha" required="required"
                       data-error="Senha invalida">
                <div class="help-block with-errors"></div>

                <button type="submit" class="btn btn-primary ms-auto mt-3">Submit</button>
            </div>


        </form>
    </div>
</div>




</body>

</html>