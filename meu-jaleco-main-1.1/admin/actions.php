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

// Verificar token CSRF
require_once __DIR__ . '/csrf.php';
$csrf = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : null;
if (!verify_csrf_token($csrf)) {
    header('Location: painel.php?err=csrf');
    exit;
}

if (!$action) {
    header('Location: painel.php');
    exit;
}

$mysqli = require __DIR__ . '/db.php';

// Ação: Inserir usuário teste
if ($action === 'insert_test_user') {
    // Buscar o próximo número de usuário teste
    $result = $mysqli->query("SELECT nome_completo FROM usuario WHERE nome_completo LIKE 'Usuario Teste%' ORDER BY id DESC LIMIT 1");
    $nextNumber = 1;
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Extrai o número do último usuário teste (ex: "Usuario Teste 5" -> 5)
        if (preg_match('/Usuario Teste (\d+)/', $row['nome_completo'], $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        }
    }
    
    // Dados do usuário teste
    $nomeCompleto = "Usuario Teste " . $nextNumber;
    $email = "usuario" . $nextNumber . "@teste.com";
    $login = "user" . str_pad($nextNumber, 2, '0', STR_PAD_LEFT); // user01, user02, etc
    $senha = password_hash("teste123", PASSWORD_DEFAULT); // senha padrão: teste123
    $cpf = str_pad($nextNumber, 11, '0', STR_PAD_LEFT); // CPF: 00000000001, 00000000002, etc
    $dataNascimento = "2000-01-01";
    $sexo = "O";
    $nomeMaterno = "Mae Teste " . $nextNumber;
    $celular = "(11) 9" . str_pad($nextNumber, 8, '0', STR_PAD_LEFT);
    $telefone = "(11) " . str_pad($nextNumber, 8, '0', STR_PAD_LEFT);
    $idPerfil = 2; // Perfil Comum
    
    // Inserir endereço
    $logradouro = "Rua Teste " . $nextNumber;
    $numero = (string)$nextNumber;
    $complemento = "Apto " . $nextNumber;
    $bairro = "Bairro Teste";
    $cidade = "Cidade Teste";
    $estado = "SP";
    $cep = str_pad($nextNumber, 8, '0', STR_PAD_LEFT); // CEP: 00000001, 00000002, etc
    $cep_formatado = substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
    
    $stmt_endereco = $mysqli->prepare("INSERT INTO endereco (logradouro, numero, complemento, bairro, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt_endereco->bind_param('sssssss', $logradouro, $numero, $complemento, $bairro, $cidade, $estado, $cep_formatado);
    
    if ($stmt_endereco->execute()) {
        $idEndereco = $stmt_endereco->insert_id;
        $stmt_endereco->close();
        
        // Inserir usuário
        $stmt_usuario = $mysqli->prepare("INSERT INTO usuario (id_perfil, id_endereco, nome_completo, data_nascimento, sexo, nome_materno, cpf, email, celular, telefone, login, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_usuario->bind_param('iissssssssss', $idPerfil, $idEndereco, $nomeCompleto, $dataNascimento, $sexo, $nomeMaterno, $cpf, $email, $celular, $telefone, $login, $senha);
        
        if ($stmt_usuario->execute()) {
            $stmt_usuario->close();
            
            // Registrar log
            $id_usuario = $_SESSION['id_usuario'] ?? 0;
            $status = 'USUARIO_TESTE_CRIADO';
            $ins = $mysqli->prepare('INSERT INTO log (id_usuario, data_hora, status_autenticacao) VALUES (?, NOW(), ?)');
            if ($ins) {
                $ins->bind_param('is', $id_usuario, $status);
                $ins->execute();
                $ins->close();
            }
        } else {
            $stmt_usuario->close();
        }
    } else {
        $stmt_endereco->close();
    }
    
    header('Location: painel.php');
    exit;
}

// Ação necessita de ID
if ($id <= 0) {
    header('Location: painel.php');
    exit;
}

if ($action === 'delete_user') {
    $userInfo = null;
    $q = $mysqli->prepare('SELECT id, nome_completo, email, id_endereco FROM usuario WHERE id = ? LIMIT 1');
    if ($q) {
        $q->bind_param('i', $id);
        $q->execute();
        $res = $q->get_result();
        $userInfo = $res ? $res->fetch_assoc() : null;
        $q->close();
    }

    // Primeiro, excluir todos os logs relacionados ao usuário
    $stmt_logs = $mysqli->prepare('DELETE FROM log WHERE id_usuario = ?');
    if ($stmt_logs) {
        $stmt_logs->bind_param('i', $id);
        $stmt_logs->execute();
        $stmt_logs->close();
    }

    // Depois, excluir o usuário
    $stmt = $mysqli->prepare('DELETE FROM usuario WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    // Se o usuário tinha um endereço, excluir também
    if ($userInfo && isset($userInfo['id_endereco'])) {
        $stmt_endereco = $mysqli->prepare('DELETE FROM endereco WHERE id = ?');
        if ($stmt_endereco) {
            $stmt_endereco->bind_param('i', $userInfo['id_endereco']);
            $stmt_endereco->execute();
            $stmt_endereco->close();
        }
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
