<?php
include('./config/database.php');
include('./includes/bootstrap.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipo_conta = $_POST['tipo_conta'] ?? '';
    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = $mysqli->real_escape_string($_POST['senha']);

        if ($tipo_conta === 'usuario') {
            $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        } else if ($tipo_conta === 'profissional') {
            $tipo_profissional = $mysqli -> real_escape_string($_POST['tipo_profissional']);
            $sql_code = "SELECT * FROM profissionais WHERE email = '$email' AND senha = '$senha' AND tipo = '$tipo_profissional'";
        }

        $sql_query = $mysqli -> query($sql_code) or die("Erro na consulta!: " . $mysqli->error);
        $quantidade = $sql_query->num_rows;

        if ($quantidade === 1) {
            $usuario = $sql_query->fetch_assoc();
            session_start();
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            if ($tipo_conta === 'profissional') {
                $_SESSION['tipo'] = $usuario['tipo'];
            } else {
                $_SESSION['tipo'] = 'usuario';
            }

            header("Location: ./templates/main.php");
            exit();
        } 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <script src="./js/index.js"></script>
</head>
<body class="bg-light" style="overflow-x: hidden;">
    <div class="container-fluid vh-100 p-0">
        <div class="row g-0 h-100">
            <!-- Carrossel -->
            <div class="col-md-8 d-none d-md-block">
                <div id="imageCarousel" class="carousel slide h-100" data-bs-ride="carousel">
                    <div class="carousel-inner h-100">
                        <div class="carousel-item active h-100">
                            <img src="./images/tecnico.jpg" class="d-block w-100 h-100" style="object-fit: cover;" alt="Imagem 1">
                        </div>
                        <div class="carousel-item h-100">
                            <img src="./images/contador.jpg" class="d-block w-100 h-100" style="object-fit: cover;" alt="Imagem 2">
                        </div>
                        <div class="carousel-item h-100">
                            <img src="./images/administrador.jpg" class="d-block w-100 h-100" style="object-fit: cover;" alt="Imagem 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            
            <!-- Formulário -->
            <div class="col-md-4 d-flex align-items-center justify-content-center bg-white">
                <div class="w-100 px-4 py-5" style="max-width: 400px;">
                    <h2 class="text-center mb-4">phpCalls</h2>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tipo de Conta:</label>
                            <select name="tipo_conta" id="tipo_conta" class="form-select" onchange="toggleTipoProfissional()" required>
                                <option value="usuario">Usuário</option>
                                <option value="profissional">Profissional</option>
                            </select>
                        </div>
                        <div class="mb-3" id="tipo_profissional_field" style="display: none;">
                            <label class="form-label">Tipo de Profissional:</label>
                            <select name="tipo_profissional" class="form-select">
                                <option value="tecnico">Técnico (TI)</option>
                                <option value="administrativo">Administrativo</option>
                                <option value="financeiro">Financeiro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="senha" class="form-control" placeholder="Senha" required>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <p class="mb-2">Ainda não é cadastrado?</p>
                        <a href="./templates/register.php" class="btn btn-outline-primary">Registrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>