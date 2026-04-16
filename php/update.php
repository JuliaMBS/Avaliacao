<?php
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$banco = 'cadastro_db';
$usuario = 'root';
$senha_db = '&tec77@info!';

function resposta($ok, $msg) {
    echo json_encode(['success' => $ok, 'message' => $msg]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    resposta(false, 'Método inválido.');
}

// dados
$id       = $_POST['id'] ?? null;
$nome     = trim($_POST['nome'] ?? '');
$email    = trim($_POST['email'] ?? '');
$senha    = trim($_POST['senha'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

// validações
if (!$id || !is_numeric($id)) {
    resposta(false, 'ID inválido.');
}

if (!$nome) {
    resposta(false, 'Nome obrigatório.');
}

if (!preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $nome)) {
    resposta(false, 'Nome inválido.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    resposta(false, 'E-mail inválido.');
}

if ($senha && strlen($senha) < 6) {
    resposta(false, 'Senha muito curta.');
}

if (!$mensagem) {
    resposta(false, 'Mensagem obrigatória.');
}

// conexão com banco (RESTAURADA)
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha_db,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );
} catch (PDOException $e) {
    resposta(false, 'Erro na conexão com banco.');
}

try {

    // verifica email duplicado (exceto o próprio usuário)
    $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
    $check->execute([$email, $id]);

    if ($check->fetch()) {
        resposta(false, 'E-mail já está em uso.');
    }

    // UPDATE com ou sem senha
    if ($senha) {
        $sql = "UPDATE usuarios 
                SET nome = ?, email = ?, senha = ?, mensagem = ? 
                WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nome,
            $email,
            password_hash($senha, PASSWORD_BCRYPT),
            $mensagem,
            $id
        ]);
    } else {
        $sql = "UPDATE usuarios 
                SET nome = ?, email = ?, mensagem = ? 
                WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nome,
            $email,
            $mensagem,
            $id
        ]);
    }

    resposta(true, 'Atualizado com sucesso!');

} catch (PDOException $e) {
    resposta(false, 'Erro ao atualizar.');
}
