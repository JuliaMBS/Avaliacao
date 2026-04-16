<?php
header('Content-Type: application/json; charset=utf-8');
require 'conexao.php';

function resposta($ok, $msg) {
    echo json_encode([
        'success' => $ok,
        'message' => $msg
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    resposta(false, 'Método inválido.');
}

$id    = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

// precisa de pelo menos um
if ($id <= 0 && !$email) {
    resposta(false, 'Informe ID ou e-mail.');
}

// valida email se for usado
if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    resposta(false, 'E-mail inválido.');
}

try {

    if ($id > 0) {
        // DELETE POR ID
        $stmt = $conexao->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);

    } else {
        // DELETE POR EMAIL (CORRIGIDO)
        $stmt = $conexao->prepare("
            DELETE FROM usuarios 
            WHERE LOWER(TRIM(email)) = LOWER(TRIM(?))
        ");
        $stmt->execute([$email]);
    }

    if ($stmt->rowCount() === 0) {
        resposta(false, 'Nenhum usuário encontrado.');
    }

    resposta(true, 'Usuário deletado com sucesso!');

} catch (PDOException $e) {
    resposta(false, 'Erro ao deletar: ' . $e->getMessage());
}
