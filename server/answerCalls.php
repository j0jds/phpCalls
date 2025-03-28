<?php
include('../config/database.php');
include('../server/protection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_chamado = $_POST['id_chamado'];
    $id_profissional = $_SESSION['id']; 
    $resposta = $mysqli -> real_escape_string($_POST['resposta']);
    $status = $mysqli -> real_escape_string($_POST['status']);

    $sql_resposta = "INSERT INTO respostas (id_chamado, id_profissional, mensagem) VALUES ('$id_chamado', '$id_profissional', '$resposta')";
    if (!$mysqli -> query($sql_resposta)) {
        die("Erro ao registrar resposta: " . $mysqli->error);
    }

    $sql_update = "UPDATE chamados SET status = '$status' WHERE id = '$id_chamado'";
    if (!$mysqli -> query($sql_update)) {
        die("Erro ao atualizar status do chamado: " . $mysqli->error);
    }

    header("Location: ./professionals.php");
    exit();
}
?>
