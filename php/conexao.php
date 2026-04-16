<?php
header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$db = "cadastro_db";
$user = "root";
$pass = "moaby.root";

try {
    $conexao = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success'=>false,'message'=>'Erro na conexão']);
    exit;
}
