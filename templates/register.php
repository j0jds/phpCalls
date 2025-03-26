<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    include('../config/database.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $mysqli -> real_escape_string($_POST['nome']);
        $email = $mysqli -> real_escape_string($_POST['email']);
        $senha = $mysqli -> real_escape_string($_POST['senha']);
        if(strlen($_POST['nome']) == 0) {
            echo "O campo de nome é obrigatório!";
        } else if(strlen($_POST['email']) == 0)  {
            echo "O campo de email é obrigatório!";
        } else if(strlen($_POST['senha']) == 0) {
            echo "O campo de senha é obrigatório!";
        } else {
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
            
            if ($mysqli->query($sql)) {
                session_start();
                $_SESSION['id'] = $mysqli -> insert_id;
                $_SESSION['nome'] = $nome;
                header("Location: ./main.php");
                exit();
            } if (!$mysqli->query($sql)) {
                die("Erro ao cadastrar: " . $mysqli->error);
            } 
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <h1>Cadastro de Usuário</h1>
    <form action="" method="POST">
        <p>
            <label>Nome</label>
            <input type="text" name="nome">
        </p>
        <p>
            <label>E-mail</label>
            <input type="email" name="email">
        </p>
        <p>
            <label>Senha</label>
            <input type="password" name="senha">
        </p>
        <p>
            <button type="submit">Cadastrar</button>
        </p>
    </form>
    <p><a href="../index.php">Já tem uma conta? Faça login</a></p>
</body>
</html>
