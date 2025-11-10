<?php
session_start();
// Verifica se está logado como admin ou master
if (!isset($_SESSION['logado']) || !isset($_SESSION['perfil_usuario']) || ($_SESSION['perfil_usuario'] !== 'Admin' && $_SESSION['perfil_usuario'] !== 'Master')) {
    header('Location: ../login.php');
    exit;
}

// Inclui conexão
$mysqli = require __DIR__ . '/db.php';

// Gerar token CSRF para formulários
require_once __DIR__ . '/csrf.php';
$csrf_token = generate_csrf_token();

// Buscar usuários
// Buscar usuários com nome do perfil
$users = [];
$sql = "SELECT u.id, u.nome_completo, u.email, p.nome_perfil FROM usuario u JOIN perfil p ON u.id_perfil = p.id ORDER BY u.id DESC LIMIT 500";
if ($res = $mysqli->query($sql)) {
    while ($row = $res->fetch_assoc()) {
        $users[] = $row;
    }
    $res->free();
}

// Buscar logs
// Buscar logs com nome do usuário
$logs = [];
$sql = "SELECT l.id, u.nome_completo AS usuario, l.data_hora, l.status_autenticacao FROM log l LEFT JOIN usuario u ON l.id_usuario = u.id ORDER BY l.id DESC LIMIT 500";
if ($res = $mysqli->query($sql)) {
    while ($row = $res->fetch_assoc()) {
        $logs[] = $row;
    }
    $res->free();
}

?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel Admin — Gerenciamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/telaadmin.css">
</head>
<body>
    <?php include __DIR__ . '/../assets/includes/header.php'; ?>

    <main class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Gerenciamento</h2>
            <div>
                <a href="../index.php" class="btn btn-secondary">Voltar</a>
            </div>
        </div>

        <ul class="nav nav-tabs" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="usuarios-tab" data-bs-toggle="tab" data-bs-target="#usuarios" type="button" role="tab">Usuários</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="logs-tab" data-bs-toggle="tab" data-bs-target="#logs" type="button" role="tab">Logs de Ações</button>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="usuarios" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nome Completo</th>
                                <th>Email</th>
                                <th>Perfil</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($users) === 0): ?>
                                <tr><td colspan="5">Nenhum usuário encontrado.</td></tr>
                            <?php else: ?>
                                <?php foreach ($users as $u): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($u['id']); ?></td>
                                        <td><?php echo htmlspecialchars($u['nome_completo']); ?></td>
                                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                                        <td><?php echo htmlspecialchars($u['nome_perfil']); ?></td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="editar_usuario.php?id=<?php echo urlencode($u['id']); ?>">Editar</a>
                                            <form method="post" action="actions.php" style="display:inline;" onsubmit="return confirm('Confirmar exclusão do usuário?');">
                                                <input type="hidden" name="action" value="delete_user">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($u['id']); ?>">
                                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="logs" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-secondary">
                            <tr>
                                <th>#</th>
                                <th>Usuário</th>
                                <th>Status</th>
                                <th>Data/Hora</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($logs) === 0): ?>
                                <tr><td colspan="5">Nenhum log encontrado.</td></tr>
                            <?php else: ?>
                                <?php foreach ($logs as $l): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($l['id']); ?></td>
                                        <td><?php echo htmlspecialchars($l['usuario']); ?></td>
                                        <td><?php echo htmlspecialchars($l['status_autenticacao']); ?></td>
                                        <td><?php echo htmlspecialchars($l['data_hora']); ?></td>
                                        <td>
                                            <form method="post" action="actions.php" style="display:inline;" onsubmit="return confirm('Remover este log?');">
                                                <input type="hidden" name="action" value="delete_log">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($l['id']); ?>">
                                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../assets/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
