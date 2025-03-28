<?php
include('../server/protection.php');
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

    <?php
        if ($_SESSION['tipo'] == 'usuario') {
            echo '<h3>Precisa de ajuda? Abra um chamado:</h3>';
            echo '<p><a href="openCalls.php">Abrir Chamado</a></p>';
            echo '<h3>Meus chamados:</h3>';
            echo '<p><a href="./userCalls.php">Visualizar meus chamados</a></p>';
        }
        if ($_SESSION['tipo'] !== 'usuario') {
            echo '<h3>Chamados disponíveis:</h3>';
            echo '<p><a href="./professionals.php">Ver Chamados</a></p>';
        }
    ?>

    <p>
        <a href="../server/logout.php">Encerrar sessão</a>
    </p>
</body>
</html>