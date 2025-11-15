<?php
// Inicia a sessão
session_start();

// Registrar log de logout antes de destruir a sessão
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true && isset($_SESSION['id_usuario'])) {
    $mysqli = require __DIR__ . '/admin/db.php';
    $id_usuario = $_SESSION['id_usuario'];
    $status = 'LOGOUT';
    
    $stmt = $mysqli->prepare('INSERT INTO log (id_usuario, data_hora, status_autenticacao) VALUES (?, NOW(), ?)');
    if ($stmt) {
        $stmt->bind_param('is', $id_usuario, $status);
        $stmt->execute();
        $stmt->close();
    }
    $mysqli->close();
}

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Destrói a sessão
session_destroy();

// Redireciona para a tela de login
header("Location: login.php");
exit();

?>