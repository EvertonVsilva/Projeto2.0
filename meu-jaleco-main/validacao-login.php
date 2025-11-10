<?php
// Inicia a sessão
session_start();

// Verifica se o formulário foi enviado
if (isset($_POST['botao_entrar'])) {

    // 1. Coleta e limpa os dados do formulário
    $login_usuario = trim($_POST['campo_login']);
    $senha_digitada = $_POST['campo_senha'];

    // 2. Autenticar usando a tabela `usuario` do banco de dados
    // Verifica login por email ou pelo campo login
    try {
        $mysqli = require __DIR__ . '/admin/db.php';
    } catch (Throwable $e) {
        $_SESSION['erro_login'] = "Erro ao conectar ao banco de dados.";
        header("Location: login.php");
        exit();
    }

    $stmt = $mysqli->prepare('SELECT u.id, u.nome_completo, u.email, u.senha, p.nome_perfil, u.id_perfil 
                             FROM usuario u 
                             JOIN perfil p ON u.id_perfil = p.id 
                             WHERE u.email = ? OR u.login = ? 
                             LIMIT 1');
    if (!$stmt) {
        $_SESSION['erro_login'] = "Erro interno.";
        header("Location: login.php");
        exit();
    }
    $stmt->bind_param('ss', $login_usuario, $login_usuario);
    $stmt->execute();
    $res = $stmt->get_result();
    $usuario_dados = $res ? $res->fetch_assoc() : null;
    $stmt->close();

    if (!$usuario_dados) {
        $_SESSION['erro_login'] = "Usuário não encontrado. Verifique seu login.";
        header("Location: login.php");
        exit();
    }

    // 3. Verifica a senha hashed
    if (!isset($usuario_dados['senha']) || !password_verify($senha_digitada, $usuario_dados['senha'])) {
        $_SESSION['erro_login'] = "Senha incorreta. Tente novamente.";
        header("Location: login.php");
        exit();
    }

    // 4. Autenticação bem-sucedida: Cria as variáveis de sessão
    $_SESSION['logado'] = true;
    $_SESSION['id_usuario'] = $usuario_dados['id'];
    $_SESSION['email'] = $usuario_dados['email'];
    $_SESSION['nome_exibicao'] = $usuario_dados['nome_completo'];
    $_SESSION['id_perfil'] = $usuario_dados['id_perfil'];
    $_SESSION['perfil_usuario'] = $usuario_dados['nome_perfil'];

    // Registrar log de login
    $stmt = $mysqli->prepare('INSERT INTO log (id_usuario, data_hora, status_autenticacao) VALUES (?, NOW(), ?)');
    if ($stmt) {
        $status = 'LOGIN_OK';
        $stmt->bind_param('is', $usuario_dados['id'], $status);
        $stmt->execute();
        $stmt->close();
    }

    // 5. Redireciona para a página apropriada baseada no perfil
    if ($usuario_dados['nome_perfil'] === 'Master') {
        header("Location: admin/dashboard-master.php");
    } elseif ($usuario_dados['nome_perfil'] === 'Admin') {
        header("Location: admin/painel.php");
    } else {
        header("Location: index.php"); // Redireciona para a página inicial
    }
    exit();
} else {
    // Acesso direto ao validacao-login.php sem envio do formulário
    header("Location: login.php");
    exit();
}
