<?php
header('Content-Type: application/json; charset=utf-8');
require 'conexao.php';

function resposta($ok, $msg, $data = null) {
    echo json_encode(['success' => $ok, 'message' => $msg, 'data' => $data]);
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    resposta(false, 'ID não informado.');
}

try {
    $stmt = $conexao->prepare("SELECT id, nome, email, mensagem FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        resposta(false, 'Usuário não encontrado.');
    }

    resposta(true, 'OK', $user);

} catch (PDOException $e) {
    resposta(false, 'Erro ao buscar.');
}