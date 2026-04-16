<?php
header('Content-Type: application/json; charset=utf-8');
require 'conexao.php';

function resposta($ok, $msg) {
    echo json_encode(['success' => $ok, 'message' => $msg]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    resposta(false, 'Método inválido.');
}

$id       = $_POST['id'] ?? null;
$nome     = trim($_POST['nome'] ?? '');
$email    = trim($_POST['email'] ?? '');
$senha    = trim($_POST['senha'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

if (!$id) resposta(false, 'ID inválido.');
if (!$nome) resposta(false, 'Nome obrigatório.');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) resposta(false, 'Email inválido.');
if (!$mensagem) resposta(false, 'Mensagem obrigatória.');

try {

    if ($senha) {
        $sql = "UPDATE usuarios SET nome=?, email=?, senha=?, mensagem=? WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            $nome,
            $email,
            password_hash($senha, PASSWORD_DEFAULT),
            $mensagem,
            $id
        ]);
    } else {
        $sql = "UPDATE usuarios SET nome=?, email=?, mensagem=? WHERE id=?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            $nome,
            $email,
            $mensagem,
            $id
        ]);
    }

    resposta(true, 'Atualizado com sucesso!');

} catch (PDOException $e) {
    resposta(false, 'Erro ao atualizar: ' . $e->getMessage());
}
