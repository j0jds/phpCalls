<?php
    include('../config/database.php');
    include('../server/protection.php');
    include('../includes/bootstrap.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = $mysqli -> real_escape_string($_POST['titulo']);
        $descricao = $mysqli -> real_escape_string($_POST['descricao']);
        $tipo = $mysqli -> real_escape_string($_POST['tipo']);
        $usuario_id = $_SESSION['id'];

        if (empty($titulo) || empty($descricao) || empty($tipo)) {
            $alert_message = "Todos os campos são obrigatórios!";
            $alert_type = "danger";
        } else {
            $sql = "INSERT INTO chamados (titulo, descricao, tipo, usuario_id) VALUES ('$titulo', '$descricao', '$tipo', '$usuario_id')";
            
            if ($mysqli -> query($sql)) {
                $alert_message = "Chamado aberto com sucesso!";
                $alert_type = "success";
            } else {
                $alert_message = "Erro ao abrir chamado: " . $mysqli->error;
                $alert_type = "danger";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abrir Chamado</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <script src="../js/index.js"></script>
</head>
<body class="bodyOC">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h1 class="page-title">Abrir Chamado</h1>
                    
                    <?php if (!empty($alert_message)): ?>
                        <div class="alert alert-<?php echo $alert_type; ?> alert-dismissible fade show" role="alert">
                            <?php echo $alert_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input type="text" name="titulo" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" class="form-control textareaOC" required></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Tipo</label>
                            <select name="tipo" class="form-select" required>
                                <option value="tecnico">Técnico</option>
                                <option value="administrativo">Administrativo</option>
                                <option value="financeiro">Financeiro</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg">Abrir Chamado</button>
                            <a href="main.php" class="btn btn-secondary btn-lg">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>