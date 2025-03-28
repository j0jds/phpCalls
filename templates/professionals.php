<?php
include('../config/database.php');
include('../server/protection.php');

if (!isset($_SESSION['tipo'])) {
    die("Erro! Apenas profissionais podem acessar esta página.");
}

$tipo_profissional = $_SESSION['tipo'];

$sql = "SELECT * FROM chamados WHERE tipo = '$tipo_profissional'";
$result = $mysqli -> query( $sql) or die("Erro ao buscar chamados: " . $mysqli->error);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resposta'])) {
    $chamado_id = $_POST['id_chamado'];
    $id_profissional = $_SESSION['id'];
    $resposta = $mysqli -> real_escape_string(string: $_POST['resposta']);
    $status = $mysqli -> real_escape_string(string: $_POST['status']);

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
</head>
<body>
    <h2>Chamados para Atendimento</h2>
    
    <?php while ($chamado = $result->fetch_assoc()): ?>
        <div>
            <h5><?php echo $chamado['titulo']; ?></h5>
            <p><?php echo $chamado['descricao']; ?></p>
            <p><strong>Status:</strong> <?php echo $chamado['status']; ?></p>

            <h6>Mensagens:</h6>
            <?php
                $chamado_id = $chamado['id'];
                $msg_query = "SELECT COALESCE(profissionais.nome, usuarios.nome) AS remetente, respostas.mensagem, respostas.data_envio
              FROM respostas
              LEFT JOIN profissionais ON respostas.remetente_id = profissionais.id
              LEFT JOIN usuarios ON respostas.remetente_id = usuarios.id
              WHERE respostas.chamado_id = '$chamado_id'
              ORDER BY respostas.data_envio ASC";

                $msg_result = $mysqli->query($msg_query);
                if ($msg_result->num_rows > 0):
                    while ($msg = $msg_result->fetch_assoc()):
            ?>
                        <div>
                            <p><strong><?php echo $msg['remetente']; ?>:</strong> <?php echo $msg['mensagem']; ?></p>
                            <p><small><?php echo $msg['data_envio']; ?></small></p>
                        </div>
            <?php 
                    endwhile;
                else:
                    echo "<p>Nenhuma resposta ainda.</p>";
                endif;
            ?>

            <?php if ($chamado['status'] !== 'solucionado'): ?>
                <form action="" method="POST">
                    <input type="hidden" name="id_chamado" value="<?php echo $chamado['id']; ?>">
                    <textarea name="resposta" placeholder="Responder chamado..." required></textarea>
                    <select name="status">
                        <option value="aberto" <?php if ($chamado['status'] == 'aberto') echo 'selected'; ?>>Em Aberto</option>
                        <option value="solucionado" <?php if ($chamado['status'] == 'solucionado') echo 'selected'; ?>>Solucionado</option>
                        <option value="rejeitado" <?php if ($chamado['status'] == 'rejeitado') echo 'selected'; ?>>Rejeitado</option>
                    </select>
                    <button type="submit">Enviar Resposta</button>
                </form>
            <?php else: ?>
                <p>✅ Este chamado foi solucionado.</p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>

    <p>
        <a href="./main.php">Voltar</a>
    </p>
</body>
</html>
