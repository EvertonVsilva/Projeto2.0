<?php
session_start();

// Verifica se está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: login.php');
    exit;
}

// Verifica se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: perfil.php');
    exit;
}

// Conecta ao banco de dados
$mysqli = require __DIR__ . '/admin/db.php';

// Recebe e valida os dados
$senha_atual = $_POST['senha_atual'] ?? '';
$nova_senha = $_POST['nova_senha'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';

// Validações
if (empty($senha_atual) || empty($nova_senha) || empty($confirmar_senha)) {
    $_SESSION['erro_senha'] = 'Todos os campos são obrigatórios.';
    header('Location: perfil.php');
    exit;
}

// Validação: senha deve ter exatamente 8 caracteres alfanuméricos
if (!preg_match('/^[a-zA-Z0-9]{8}$/', $nova_senha)) {
    $_SESSION['erro_senha'] = 'A nova senha deve ter exatamente 8 caracteres alfanuméricos (letras e números).';
    header('Location: perfil.php');
    exit;
}

// Validação: senhas devem coincidir
if ($nova_senha !== $confirmar_senha) {
    $_SESSION['erro_senha'] = 'A nova senha e a confirmação não coincidem.';
    header('Location: perfil.php');
    exit;
}

/**
 * Processamento de Alteração de Senha
 * 
 * Fluxo de Validação e Atualização:
 * 1. Verifica autenticação (usuário logado)
 * 2. Valida campos obrigatórios
 * 3. Valida formato da nova senha (8 caracteres alfanuméricos)
 * 4. Verifica se as senhas (nova e confirmação) coincidem
 * 5. Busca o hash da senha atual no banco
 * 6. Verifica se a senha atual informada está correta (password_verify)
 * 7. Verifica se a nova senha é diferente da atual
 * 8. Criptografa a nova senha (bcrypt via password_hash)
 * 9. Atualiza no banco de dados
 * 10. Registra log da alteração
 * 
 * Segurança Implementada:
 * - Verificação de autenticação via sessão
 * - Validação de senha atual antes de permitir alteração
 * - Regex para garantir formato correto (8 alfanuméricos)
 * - Criptografia bcrypt (não armazena senha em texto plano)
 * - Prepared statements (previne SQL injection)
 * - Log de auditoria da ação
 */

// Busca o usuário no banco
$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT senha FROM usuario WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

if (!$usuario) {
    $_SESSION['erro_senha'] = 'Usuário não encontrado.';
    header('Location: perfil.php');
    exit;
}

/**
 * Verificação de Senha Atual
 * 
 * Usa password_verify() para comparar:
 * - Senha em texto plano informada pelo usuário
 * - Hash bcrypt armazenado no banco
 * 
 * password_verify() é seguro porque:
 * - Compara de forma constante no tempo (evita timing attacks)
 * - Funciona com qualquer salt gerado automaticamente pelo bcrypt
 */
if (!password_verify($senha_atual, $usuario['senha'])) {
    $_SESSION['erro_senha'] = 'A senha atual está incorreta.';
    header('Location: perfil.php');
    exit;
}

// Verifica se a nova senha é diferente da atual
if ($senha_atual === $nova_senha) {
    $_SESSION['erro_senha'] = 'A nova senha deve ser diferente da senha atual.';
    header('Location: perfil.php');
    exit;
}

// Criptografa a nova senha
$senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

// Atualiza a senha no banco de dados
$sql_update = "UPDATE usuario SET senha = ? WHERE id = ?";
$stmt_update = $mysqli->prepare($sql_update);
$stmt_update->bind_param('si', $senha_hash, $id_usuario);

if ($stmt_update->execute()) {
    $_SESSION['sucesso_senha'] = 'Senha alterada com sucesso!';
    
    // Registrar log da alteração de senha
    $status = 'SENHA_ALTERADA';
    $ins = $mysqli->prepare('INSERT INTO log (id_usuario, data_hora, status_autenticacao) VALUES (?, NOW(), ?)');
    if ($ins) {
        $ins->bind_param('is', $id_usuario, $status);
        $ins->execute();
        $ins->close();
    }
} else {
    $_SESSION['erro_senha'] = 'Erro ao alterar a senha. Tente novamente.';
}

$stmt_update->close();
$mysqli->close();

header('Location: perfil.php');
exit;
?>
