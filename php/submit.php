<?php
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$banco = 'cadastro_db';
$usuario = 'root';
$senha_db = 'moaby.root';

function resposta($ok, $msg) {
    echo json_encode(['success' => $ok, 'message' => $msg]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') resposta(false, 'Método inválido.');

$nome     = trim($_POST['nome'] ?? '');
$email    = trim($_POST['email'] ?? '');
$senha    = trim($_POST['senha'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

if (!$nome) resposta(false, 'Nome obrigatório.');
if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $nome)) resposta(false, 'Nome inválido.');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) resposta(false, 'E-mail inválido.');
if (strlen($senha) < 6) resposta(false, 'Senha muito curta.');
if (!$mensagem) resposta(false, 'Mensagem obrigatória.');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha_db, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    resposta(false, 'Erro na conexão com banco.');
}

try {
    $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha, mensagem) VALUES (?,?,?,?)');
    $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_BCRYPT), $mensagem]);
    resposta(true, 'Cadastro realizado com sucesso!');
} catch (PDOException $e) {
    resposta(false, 'Erro ao salvar.');
}
