<?php
    include('../server/protection.php');
    include('../includes/bootstrap.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../js/index.js"></script>
</head>
<body>
</nav>
 <!-- HEADER -->
 <header class="navbar d-flex justify-content-between align-items-center p-3 bg-primary text-white">
        <a href="https://www.php.net/" target="_blank"><img class="logo" src="../images/logo.png"></a>
        <h2 class="mb-0">Boas-vindas, <?php echo $_SESSION['nome']; ?>.</h2>
        <ul class="nav-links">
            <li><a href="https://www.github.com/j0jds" target="_blank">Github</a></li>
            <li><a href="https://www.linkedin.com/in/j0jds/" target="_blank">Linkedin</a></li>
            <li><a href="https://github.com/j0jds/phpCalls" target="_blank">Saiba Mais</a></li>
        </ul>
        <a href="../server/logout.php" class="btn btn-danger">Encerrar sessão</a>
    </header>
   <!-- DASHBOARD CENTRAL -->
   <div class="container d-flex flex-column align-items-center justify-content-center" style="height: 70vh;">
        <?php if ($_SESSION['tipo'] == 'usuario'): ?>
            <div class="row w-100 justify-content-center">
                <div class="col-md-4">
                    <div class="card text-center p-4 shadow">
                        <h3 class="card-title">Abrir Chamado</h3>
                        <a href="openCalls.php" class="btn btn-primary btn-lg mt-3">Abrir</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-4 shadow">
                        <h3 class="card-title">Meus Chamados</h3>
                        <a href="userCalls.php" class="btn btn-secondary btn-lg mt-3">Visualizar</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row w-100 justify-content-center">
                <div class="col-md-4">
                    <div class="card text-center p-4 shadow">
                        <h3 class="card-title">Chamados Disponíveis</h3>
                        <a href="professionals.php" class="btn btn-primary btn-lg mt-3">Ver Chamados</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>