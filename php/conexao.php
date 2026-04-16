<?php
$host = "localhost";
$db = "cadastro_db";
$user = "root";
$pass = "root";

try {
    $conexao = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    
    // Configura para mostrar erros
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conectado com sucesso!";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>