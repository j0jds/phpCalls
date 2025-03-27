<?php
    include('../config/database.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $mysqli -> real_escape_string($_POST['nome']);
        $email = $mysqli -> real_escape_string($_POST['email']);
        $senha = $mysqli -> real_escape_string($_POST['senha']);
        $tipo_conta = $_POST['tipo_conta'] ?? '';

        if (empty($nome)) {
            echo "O campo de nome é obrigatório!";
        } else if (empty($email)) {
            echo "O campo de email é obrigatório!";
        } else if (empty($senha)) {
            echo "O campo de senha é obrigatório!";
        } else if ($tipo_conta === 'profissional' && empty($_POST['tipo_profissional'])) {
            echo "Selecione um tipo de profissional!";
        } else {
            if ($tipo_conta === 'usuario') {
                $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
            } else {
                $tipo_profissional = $mysqli -> real_escape_string($_POST['tipo_profissional']);
                $sql = "INSERT INTO profissionais (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha', '$tipo_profissional')";
            }

            if ($mysqli->query($sql)) {
                session_start();
                $_SESSION['id'] = $mysqli->insert_id;
                $_SESSION['nome'] = $nome;
                if ($tipo_conta === 'profissional') {
                    $_SESSION['tipo'] = $tipo_profissional;
                }
                header("Location: ./main.php");
                exit();
            } else {
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
    <script>
        function toggleTipoProfissional() {
            var tipoConta = document.getElementById("tipo_conta").value;
            var tipoProfissionalField = document.getElementById("tipo_profissional_field");
            tipoProfissionalField.style.display = (tipoConta === "profissional") ? "block" : "none";
        }
    </script>
</head>
<body>
    <h1>Cadastro</h1>
    <form action="" method="POST">
        <p>
            <label>Tipo de Conta:</label>
            <select name="tipo_conta" id="tipo_conta" onchange="toggleTipoProfissional()" required>
                <option value="usuario">Usuário</option>
                <option value="profissional">Profissional</option>
            </select>
        </p>
        <p>
            <label>Nome</label>
            <input type="text" name="nome" required>
        </p>
        <p>
            <label>E-mail</label>
            <input type="email" name="email" required>
        </p>
        <p>
            <label>Senha</label>
            <input type="password" name="senha" required>
        </p>
        <p id="tipo_profissional_field" style="display: none;">
            <label>Tipo de Profissional:</label>
            <select name="tipo_profissional">
            <option value="tecnico">Técnico</option>
                <option value="administrativo">Administrativo</option>
                <option value="financeiro">Financeiro</option>
            </select>
        </p>
        <p>
            <button type="submit">Cadastrar</button>
        </p>
    </form>
    <p><a href="../index.php">Já tem uma conta? Faça login</a></p>
</body>
</html>
