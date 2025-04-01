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
    <div class="dashboard-container">
        <div class="container">
            <div class="card welcome-card mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Boas-vindas, <?php echo $_SESSION['nome'];?></h2>
                    <a href="../server/logout.php" class="btn btn-danger">Encerrar sessão</a>
                </div>
            </div>

            <?php if ($_SESSION['tipo'] == 'usuario'): ?>
                <!-- Cards para Usuários -->
                <div class="card action-card">
                    <div class="card-body">
                        <h3 class="card-title">Precisa de ajuda? Abra um chamado:</h3>
                        <a href="openCalls.php" class="btn btn-primary btn-lg">Abrir Chamado</a>
                    </div>
                </div>

                <div class="card action-card">
                    <div class="card-body">
                        <h3 class="card-title">Meus chamados:</h3>
                        <a href="./userCalls.php" class="btn btn-outline-primary btn-lg">Visualizar meus chamados</a>
                    </div>
                </div>

                <div class="card action-card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Suporte</h5>
                        <p class="card-text">Em caso de dúvidas, entre em contato com nossa equipe:</p>
                        <ul class="list-unstyled">
                            <li><b>Email:</b> suporte@sistema.com</li>
                            <li><b>Telefone:</b> (81) 9999-9999</li>
                        </ul>
                    </div>
                </div>

            <?php else: ?>
                <!-- Card para Profissionais -->
                <div class="card action-card">
                    <div class="card-body">
                        <h3 class="card-title">Chamados disponíveis:</h3>
                        <a href="./professionals.php" class="btn btn-primary btn-lg">Ver Chamados</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>