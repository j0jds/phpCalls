<?php 
  $usuario = 'root';
  $senha = 'dipirona123';
  $database = 'Sistema';
  $host = 'localhost';
  
  $mysqli = new mysqli($host, $usuario, $senha, $database);

    if($mysqli -> error) {
        die("Erro ao tentar conexão: " . $mysqli -> error);
    }
?>