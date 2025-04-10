<?php
include('../config/database.php');
include('../server/protection.php');
include('../includes/bootstrap.php');

if (!isset($_SESSION['tipo'])) {
    die("Erro! Apenas profissionais podem acessar esta página.");
}

$tipo_profissional = $_SESSION['tipo'];

$sql = "SELECT * FROM chamados WHERE tipo = '$tipo_profissional'";
$result = $mysqli -> query($sql) or die("Erro ao buscar chamados: " . $mysqli -> error);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resposta'])) {
    $chamado_id = $_POST['id_chamado'];
    $id_profissional = $_SESSION['id'];
    $resposta = $mysqli -> real_escape_string($_POST['resposta']);
    $status = $mysqli -> real_escape_string($_POST['status']);

    $sql_resposta = "INSERT INTO respostas (chamado_id, remetente_id, mensagem) VALUES ('$chamado_id', '$id_profissional', '$resposta')";
    if (!$mysqli -> query($sql_resposta)) {
        die("Erro ao registrar resposta: " . $mysqli -> error);
    }

    $sql_update = "UPDATE chamados SET status = '$status' WHERE id = '$chamado_id'";
    if (!$mysqli -> query($sql_update)) {
        die("Erro ao atualizar status do chamado: " . $mysqli -> error);
    }

    header("Location: professionals.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Profissional</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div class="container ticket-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Chamados para Atendimento</h3>
            <a href="main.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>

        <?php if ($result->num_rows === 0): ?>
            <div class="alert alert-info text-center">
                Não há chamados disponíveis no momento.
            </div>
        <?php else: ?>
            <?php while ($chamado = $result->fetch_assoc()): ?>
                <div class="ticket-card">
                    <div class="ticket-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <h4><?php echo htmlspecialchars($chamado['titulo']); ?></h4>
                            <span class="badge bg-<?php 
                                echo $chamado['status'] === 'solucionado' ? 'success' : 
                                     ($chamado['status'] === 'rejeitado' ? 'danger' : 'warning'); 
                            ?> status-badge">
                                <?php echo ucfirst($chamado['status']); ?>
                            </span>
                        </div>
                    </div>

                    <div class="ticket-body">
                        <p><?php echo nl2br(htmlspecialchars($chamado['descricao'])); ?></p>
                        
                        <h5 class="mt-4 mb-3">Mensagens:</h5>
                        <?php
                            $chamado_id = $chamado['id'];
                            $msg_query = "SELECT COALESCE(profissionais.nome, usuarios.nome) AS remetente, respostas.mensagem, respostas.data_envio
                              FROM respostas
                              LEFT JOIN profissionais ON respostas.remetente_id = profissionais.id
                              LEFT JOIN usuarios ON respostas.remetente_id = usuarios.id
                              WHERE respostas.chamado_id = '$chamado_id'
                              ORDER BY respostas.data_envio ASC";

                            $msg_result = $mysqli -> query($msg_query);
                            if ($msg_result -> num_rows > 0):
                                while ($msg = $msg_result->fetch_assoc()):
                        ?>
                                    <div class="message-box mb-3">
                                        <div class="d-flex justify-content-between">
                                            <strong><?php echo htmlspecialchars($msg['remetente']); ?></strong>
                                            <small class="message-meta"><?php echo date('d/m/Y H:i', strtotime($msg['data_envio'])); ?></small>
                                        </div>
                                        <p class="mb-0"><?php echo nl2br(htmlspecialchars($msg['mensagem'])); ?></p>
                                    </div>
                        <?php 
                                endwhile;
                            else:
                        ?>
                                <div class="alert alert-secondary">
                                    Nenhuma mensagem ainda.
                                </div>
                        <?php endif; ?>

                        <?php if ($chamado['status'] !== 'solucionado'): ?>
                            <div class="response-form">
                                <form action="" method="POST">
                                    <input type="hidden" name="id_chamado" value="<?php echo $chamado['id']; ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Responder:</label>
                                        <textarea name="resposta" class="form-control" rows="3" required placeholder="Digite sua resposta..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Atualizar Status:</label>
                                        <select name="status" class="form-select status-select">
                                            <option value="aberto" <?php if ($chamado['status'] == 'aberto') echo 'selected'; ?>>Em Aberto</option>
                                            <option value="solucionado" <?php if ($chamado['status'] == 'solucionado') echo 'selected'; ?>>Solucionado</option>
                                            <option value="rejeitado" <?php if ($chamado['status'] == 'rejeitado') echo 'selected'; ?>>Rejeitado</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Enviar Resposta</button>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-success mt-3">
                                ✅ Este chamado foi marcado como solucionado.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</body>
</html>