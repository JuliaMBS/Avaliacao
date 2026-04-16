<?php
header('Content-Type: application/json; charset=utf-8');
 
$host     = getenv('DB_HOST') ?: 'localhost';
$banco    = getenv('DB_NAME') ?: 'cadastro_db';
$usuario  = getenv('DB_USER') ?: 'root';
$senha_db = getenv('DB_PASS') ?: 'moaby.root';
 
function resposta($ok, $msg) {
    echo json_encode(['success' => $ok, 'message' => $msg]);
    exit;
}
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') resposta(false, 'Método inválido.');
 
$id    = isset($_POST['id'])    ? (int) $_POST['id']    : 0;
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
 
// Precisa de ID ou e-mail para deletar
if (!$id && !$email) resposta(false, 'Informe o ID ou o e-mail do usuário.');
if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) resposta(false, 'E-mail inválido.');
 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha_db, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    resposta(false, 'Erro na conexão com banco.');
}
 
try {
    if ($id) {
        $stmt = $pdo->prepare('DELETE FROM usuarios WHERE id = ?');
        $stmt->execute([$id]);
    } else {
        $stmt = $pdo->prepare('DELETE FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
    }
 
    if ($stmt->rowCount() === 0) {
        resposta(false, 'Nenhum usuário encontrado para deletar.');
    }
 
    resposta(true, 'Usuário deletado com sucesso!');
} catch (PDOException $e) {
    resposta(false, 'Erro ao deletar usuário.');
}
 