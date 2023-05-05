<?php
include "confirmacao.php";

echo '
<form method="post" action="teste.php">
<input type="date" name="data">
<button type="submit" class="btn btn-primary ms-auto mt-3">Enviar</button>
</form>
';

print(gettype($_POST["data"]));