<?php
    include('../config/database.php');
    include('../server/protection.php');

    if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'usuario') {
        die("Erro! Apenas usuários podem acessar esta página.");
    }

    $usuario_id = $_SESSION['id'];
    
    $sql = "SELECT * FROM chamados WHERE usuario_id = '$usuario_id'";
    $result = $mysqli -> query(query: $sql) or die("Erro ao buscar chamados: " . $mysqli -> error);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resposta'])) {
        $chamado_id = $_POST['id_chamado'];
        $resposta = $mysqli  ->  real_escape_string(string: $_POST['resposta']);

        $insert_sql = "INSERT INTO respostas (chamado_id, remetente_id, mensagem) 
                       VALUES ('$chamado_id', '$usuario_id', '$resposta')";
        $mysqli  -> query(query: $insert_sql) or die("Erro ao salvar resposta: " . $mysqli -> error);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Chamados</title>
</head>
<body>
    <h2>Seus Chamados</h2>
    
    <?php while ($chamado = $result -> fetch_assoc()): ?>
        <div>
            <h5><?php echo $chamado['titulo']; ?></h5>
            <p><?php echo $chamado['descricao']; ?></p>
            <p><strong>Status:</strong> <?php echo $chamado['status']; ?></p>

            <h6>Mensagens:</h6>
            <?php
                $chamado_id = $chamado['id'];
                $msg_query = "SELECT * FROM respostas WHERE chamado_id = '$chamado_id' ORDER BY data_envio ASC";
                $msg_result = $mysqli -> query($msg_query);
                while ($msg = $msg_result -> fetch_assoc()) {
                    echo "<p><strong>{$msg['remetente_id']}:</strong> {$msg['mensagem']} <br><small>{$msg['data_envio']}</small></p>";
                }
            ?>

            <?php if ($chamado['status'] !== 'solucionado'): ?>
                <form action="" method="POST">
                    <input type="hidden" name="id_chamado" value="<?php echo $chamado['id']; ?>">
                    <textarea name="resposta" placeholder="Responder" required></textarea>
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
