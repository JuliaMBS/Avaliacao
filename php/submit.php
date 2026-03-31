<?php
header('Content-Type: application/json; charset=utf-8');

// Configurações do banco
$host = 'localhost';
$banco = 'cadastro_db';
$usuario = 'root';   
$senha_db = 'root';      

function resposta($ok, $msg) {
    echo json_encode(['success' => $ok, 'message' => $msg]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') resposta(false, 'Método inválido.');

// Captura os dados
$nome     = trim($_POST['nome']     ?? '');
$email    = trim($_POST['email']    ?? '');
$senha    = trim($_POST['senha']    ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

// Validações
if (!$nome)                                        resposta(false, 'Nome obrigatório.');
if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $nome))     resposta(false, 'Nome deve conter apenas letras.');
if (!filter_var($email, FILTER_VALIDATE_EMAIL))    resposta(false, 'E-mail inválido.');
if (strlen($senha) < 6)                            resposta(false, 'Senha muito curta.');
if (!$mensagem)                                    resposta(false, 'Mensagem obrigatória.');
if (mb_strlen($mensagem) > 250)                    resposta(false, 'Mensagem muito longa.');

// Conexão
try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha_db, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    resposta(false, 'Falha na conexão com o banco.');
}

// Salva no banco
try {
    $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha, mensagem) VALUES (?,?,?,?)');
    $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_BCRYPT), $mensagem]);
    resposta(true, 'Cadastro realizado com sucesso!');
} catch (PDOException $e) {
    $msg = $e->getCode() === '23000' ? 'E-mail já cadastrado.' : 'Erro ao salvar.';
    resposta(false, $msg);
}