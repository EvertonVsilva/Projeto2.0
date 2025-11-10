<?php
session_start();
// Verifica permissão de admin ou master
if (!isset($_SESSION['logado']) || !isset($_SESSION['perfil_usuario']) || ($_SESSION['perfil_usuario'] !== 'Admin' && $_SESSION['perfil_usuario'] !== 'Master')) {
    header('Location: ../login.php');
    exit;
}

require_once __DIR__ . '/csrf.php';
$mysqli = require __DIR__ . '/db.php';
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $csrf = $_POST['csrf_token'] ?? null;
    if (!verify_csrf_token($csrf)) {
        header('Location: painel.php?err=csrf');
        exit;
    }

    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nome_completo = isset($_POST['nome_completo']) ? trim($_POST['nome_completo']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $id_perfil = isset($_POST['id_perfil']) ? intval($_POST['id_perfil']) : 0;
    $senha_nova = isset($_POST['senha']) ? trim($_POST['senha']) : '';

    if ($id <= 0 || $email === '') {
        header('Location: painel.php?err=invalid');
        exit;
    }

    // buscar dados antigos para log
    $old = null;
    $q = $mysqli->prepare('SELECT id, nome_completo, email, id_perfil FROM usuario WHERE id = ? LIMIT 1');
    if ($q) {
        $q->bind_param('i', $id);
        $q->execute();
        $res = $q->get_result();
        $old = $res ? $res->fetch_assoc() : null;
        $q->close();
    }

    $stmt = $mysqli->prepare('UPDATE usuario SET nome_completo = ?, email = ?, id_perfil = ? WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('ssii', $nome_completo, $email, $id_perfil, $id);
        $stmt->execute();
        $stmt->close();
    }

    // Se foi fornecida uma nova senha, atualiza também (hash)
    if ($senha_nova !== '') {
        $hash = password_hash($senha_nova, PASSWORD_DEFAULT);
        $s2 = $mysqli->prepare('UPDATE usuario SET senha = ? WHERE id = ?');
        if ($s2) {
            $s2->bind_param('si', $hash, $id);
            $s2->execute();
            $s2->close();
        }
    }


    // registrar log de edição
    $usuarioLog = isset($_SESSION['nome_exibicao']) ? $_SESSION['nome_exibicao'] : 'system';
    $acao = 'Editar usuário';
    $detalhe = 'ID=' . $id;
    if ($old) {
        $detalhe .= ' / antes: ' . ($old['email'] ?? '') . ' / depois: ' . $email;
    }
    $ins = $mysqli->prepare('INSERT INTO log (id_usuario, data_hora, status_autenticacao) VALUES (?, NOW(), ?)');
    if ($ins) {
        $status = 'USUARIO_EDITADO';
        $ins->bind_param('is', $id, $status);
        $ins->execute();
        $ins->close();
    }

    header('Location: painel.php?msg=updated');
    exit;
}

// GET: mostrar formulário
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('Location: painel.php');
    exit;
}

$user = null;
$q = $mysqli->prepare('SELECT id, nome_completo, email, id_perfil FROM usuario WHERE id = ? LIMIT 1');
if ($q) {
    $q->bind_param('i', $id);
    $q->execute();
    $res = $q->get_result();
    $user = $res ? $res->fetch_assoc() : null;
    $q->close();
}

if (!$user) {
    header('Location: painel.php');
    exit;
}

// Buscar perfis disponíveis
$perfis = [];
$stmt = $mysqli->query("SELECT id, nome_perfil FROM perfil ORDER BY id");
if ($stmt) {
    while ($row = $stmt->fetch_assoc()) {
        $perfis[] = $row;
    }
    $stmt->close();
}

$csrf_token = generate_csrf_token();

?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include __DIR__ . '/../assets/includes/header.php'; ?>

    <main class="container my-4">
        <h2>Editar Usuário</h2>
        <form method="post" action="editar_usuario.php" class="mt-3">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

            <div class="mb-3">
                <label class="form-label">Nome Completo</label>
                <input name="nome_completo" class="form-control" value="<?php echo htmlspecialchars($user['nome_completo'] ?? ''); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Perfil</label>
                <select name="id_perfil" class="form-select">
                    <?php foreach ($perfis as $p): ?>
                        <option value="<?php echo htmlspecialchars($p['id']); ?>" <?php echo ($user['id_perfil'] == $p['id'] ? 'selected' : ''); ?>>
                            <?php echo htmlspecialchars($p['nome_perfil']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Senha (deixe em branco para manter)</label>
                <input name="senha" type="password" class="form-control" value="">
            </div>

            <button class="btn btn-primary" type="submit">Salvar</button>
            <a class="btn btn-secondary" href="painel.php">Cancelar</a>
        </form>
    </main>

    <?php include __DIR__ . '/../assets/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
