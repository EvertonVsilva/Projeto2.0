<?php
session_start();
// Somente admins e master podem executar essas ações
if (!isset($_SESSION['logado']) || !isset($_SESSION['perfil_usuario']) || ($_SESSION['perfil_usuario'] !== 'Admin' && $_SESSION['perfil_usuario'] !== 'Master')) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: painel.php');
    exit;
}

$action = isset($_POST['action']) ? $_POST['action'] : null;
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if (!$action || $id <= 0) {
    header('Location: painel.php');
    exit;
}

$mysqli = require __DIR__ . '/db.php';

// Verificar token CSRF
require_once __DIR__ . '/csrf.php';
$csrf = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : null;
if (!verify_csrf_token($csrf)) {
    header('Location: painel.php?err=csrf');
    exit;
}

if ($action === 'delete_user') {
    $userInfo = null;
    $q = $mysqli->prepare('SELECT id, nome_completo, email FROM usuario WHERE id = ? LIMIT 1');
    if ($q) {
        $q->bind_param('i', $id);
        $q->execute();
        $res = $q->get_result();
        $userInfo = $res ? $res->fetch_assoc() : null;
        $q->close();
    }

    // Excluir usuário
    $stmt = $mysqli->prepare('DELETE FROM usuario WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    // Registrar log da ação
    $id_usuario = $_SESSION['id_usuario'] ?? 0;
    $status = 'USUARIO_DELETADO';
    $ins = $mysqli->prepare('INSERT INTO log (id_usuario, data_hora, status_autenticacao) VALUES (?, NOW(), ?)');
    if ($ins) {
        $ins->bind_param('is', $id_usuario, $status);
        $ins->execute();
        $ins->close();
    }

    header('Location: painel.php');
    exit;
}

if ($action === 'delete_log') {
    $stmt = $mysqli->prepare('DELETE FROM log WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    // Registrar que um admin removeu um log
    $id_usuario = $_SESSION['id_usuario'] ?? 0;
    $status = 'LOG_DELETADO';
    $ins = $mysqli->prepare('INSERT INTO log (id_usuario, data_hora, status_autenticacao) VALUES (?, NOW(), ?)');
    if ($ins) {
        $ins->bind_param('is', $id_usuario, $status);
        $ins->execute();
        $ins->close();
    }

    header('Location: painel.php');
    exit;
}

// Ação não reconhecida

header('Location: painel.php');
exit;

?>
