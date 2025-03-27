<?php
    include('../config/database.php');
    include('../server/protection.php');

    if (!isset($_SESSION['tipo'])) {
        die("Erro! Apenas profissionais podem acessar esta página.");
    }

    $tipo_profissional = $_SESSION['tipo'];
    
    $sql = "SELECT * FROM chamados WHERE tipo = '$tipo_profissional'";
    $result = $mysqli -> query($sql) or die("Erro ao buscar chamados: " . $mysqli->error);
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
            <form action="" method="POST">
                <input type="hidden" name="id_chamado" value="<?php echo $chamado['id']; ?>">
                <textarea name="resposta" placeholder="Responder chamado..." required></textarea>
                <select name="status">
                    <option value="aberto">Em Aberto</option>
                    <option value="solucionado">Solucionado</option>
                    <option value="rejeitado">Rejeitado</option>
                </select>
                <button type="submit">Enviar Resposta</button>
            </form>
        </div>
    <?php endwhile; ?>

    <p>
        <a href="./main.php">Voltar</a>
    </p>
</body>
</html>
