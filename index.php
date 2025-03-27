<?php 
    include('./config/database.php');

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $tipo_conta = $_POST['tipo_conta'] ?? '';
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        if (empty($email)) {
            echo "O campo de email é obrigatório!";
        } else if (empty($senha)) {
            echo "O campo de senha é obrigatório!";
        } else {
            if ($tipo_conta === 'usuario') {
                $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
            } else if ($tipo_conta === 'profissional') {
                $tipo_profissional = $mysqli -> real_escape_string($_POST['tipo_profissional']);
                $sql_code = "SELECT * FROM profissionais WHERE email = '$email' AND senha = '$senha' AND tipo = '$tipo_profissional'";
            } 

            $sql_query = $mysqli -> query($sql_code) or die("Erro na consulta!: " . $mysqli -> error);
            $quantidade = $sql_query -> num_rows;

            if ($quantidade === 1) {
                $usuario = $sql_query->fetch_assoc();
                session_start();
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];

                if ($tipo_conta === 'profissional') {
                    $_SESSION['tipo'] = $usuario['tipo'];
                }

                header("Location: ./templates/main.php");
            } else {
                echo "Erro! Email, senha ou tipo incorretos.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script>
        function toggleTipoProfissional() {
            var tipoConta = document.getElementById("tipo_conta").value;
            var tipoProfissionalField = document.getElementById("tipo_profissional_field");
            tipoProfissionalField.style.display = (tipoConta === "profissional") ? "block" : "none";
        }
    </script>
</head>
<body>
    <h1>Boas vindas!</h1>
    <form action="" method="POST">
        <p>
            <label>Tipo de Conta:</label>
            <select name="tipo_conta" id="tipo_conta" onchange="toggleTipoProfissional()" required>
                <option value="usuario">Usuário</option>
                <option value="profissional">Profissional</option>
            </select>
        </p>
        <p id="tipo_profissional_field" style="display: none;">
            <label>Tipo de Profissional:</label>
            <select name="tipo_profissional">
                <option value="tecnico">Técnico (TI)</option>
                <option value="administrativo">Administrativo</option>
                <option value="financeiro">Financeiro</option>
            </select>
        </p>
        <p>
            <label>E-mail</label>
            <input type="text" name="email" required>
        </p>
        <p>
            <label>Senha</label>
            <input type="password" name="senha" required>
        </p>
        <p>
            <button type="submit">Entrar</button>
        </p>
    </form>
    <h3>Ainda não é cadastrado? Registre-se aqui:</h3>
    <p><a href="./templates/register.php">Registrar</a></p>
</body>
</html>
