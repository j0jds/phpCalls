<?php
    include('../server/protection.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
</head>
<body>
    Boas vindas, <?php echo $_SESSION['nome'];?> 

    <h3>Precisa de ajuda? Abra um chamado:</h3>
    <p><a href="openCalls.php">Abrir Chamado</a></p>

    <p>
        <a href="../server/logout.php">Encerrar sessão</a>
    </p>
</body>
</html>