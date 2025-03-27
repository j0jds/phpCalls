<?php
    include('../config/database.php');
    include('../server/protection.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo = $mysqli -> real_escape_string($_POST['titulo']);
        $descricao = $mysqli -> real_escape_string($_POST['descricao']);
        $tipo = $mysqli -> real_escape_string($_POST['tipo']);
        $usuario_id = $_SESSION['id'];

        if (empty($titulo) || empty($descricao) || empty($tipo)) {
            echo "Todos os campos são obrigatórios!";
        } else {
            $sql = "INSERT INTO chamados (titulo, descricao, tipo, usuario_id) VALUES ('$titulo', '$descricao', '$tipo', '$usuario_id')";
            
            if ($mysqli->query($sql)) {
                echo "Chamado aberto com sucesso!";
            } else {
                echo "Erro ao abrir chamado: " . $mysqli->error;
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
</head>
<body>
    <h1>Abrir Chamado</h1>
    <form action="" method="POST">
        <p>
            <label>Título</label>
            <input type="text" name="titulo">
        </p>
        <p>
            <label>Descrição</label>
            <textarea name="descricao"></textarea>
        </p>
        <p>
            <label>Tipo</label>
            <select name="tipo">
                <option value="tecnico">Técnico</option>
                <option value="administrativo">Administrativo</option>
                <option value="financeiro">Financeiro</option>
            </select>
        </p>
        <p>
            <button type="submit">Abrir Chamado</button>
        </p>
    </form>
    <p><a href="main.php">Voltar</a></p>
</body>
</html>
