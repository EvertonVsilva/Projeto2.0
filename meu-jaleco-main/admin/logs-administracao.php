<?php
session_start();
// Verifica se está logado como admin
if (!isset($_SESSION['logado']) || !isset($_SESSION['perfil_usuario']) || $_SESSION['perfil_usuario'] !== 'ADMIN') {
    header('Location: ../login.php');
    exit;
}

$mysqli = require __DIR__ . '/db.php';

// Parâmetros de filtro
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';
$id_usuario = isset($_GET['id_usuario']) ? intval($_GET['id_usuario']) : 0;

// Construir query base
$sql = "SELECT l.id, l.data_hora, l.status_autenticacao, u.nome_completo, u.email, p.nome_perfil 
        FROM log l 
        LEFT JOIN usuario u ON l.id_usuario = u.id 
        LEFT JOIN perfil p ON u.id_perfil = p.id 
        WHERE 1=1";
$params = [];
$types = '';

// Adicionar filtros
if ($data_inicio) {
    $sql .= " AND l.data_hora >= ?";
    $params[] = $data_inicio . ' 00:00:00';
    $types .= 's';
}
if ($data_fim) {
    $sql .= " AND l.data_hora <= ?";
    $params[] = $data_fim . ' 23:59:59';
    $types .= 's';
}
if ($id_usuario > 0) {
    $sql .= " AND l.id_usuario = ?";
    $params[] = $id_usuario;
    $types .= 'i';
}

$sql .= " ORDER BY l.data_hora DESC LIMIT 1000";

// Executar query
$logs = [];
$stmt = $mysqli->prepare($sql);
if ($stmt) {
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $logs[] = $row;
    }
    $stmt->close();
}

// Buscar usuários para o filtro
$usuarios = [];
if ($res = $mysqli->query("SELECT id, nome_completo, email FROM usuario ORDER BY nome_completo")) {
    while ($row = $res->fetch_assoc()) {
        $usuarios[] = $row;
    }
    $res->free();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logs de Administração</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/telaadmin.css">
</head>
<body>
    <?php include __DIR__ . '/../assets/includes/header.php'; ?>

    <main class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Logs de Administração</h2>
            <div>
                <a href="painel.php" class="btn btn-secondary">Voltar ao Painel</a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Filtros</h5>
            </div>
            <div class="card-body">
                <form method="get" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Data Início</label>
                        <input type="date" name="data_inicio" class="form-control" value="<?php echo htmlspecialchars($data_inicio); ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data Fim</label>
                        <input type="date" name="data_fim" class="form-control" value="<?php echo htmlspecialchars($data_fim); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Usuário</label>
                        <select name="id_usuario" class="form-select">
                            <option value="">Todos</option>
                            <?php foreach ($usuarios as $u): ?>
                                <option value="<?php echo htmlspecialchars($u['id']); ?>" <?php echo ($id_usuario == $u['id'] ? 'selected' : ''); ?>>
                                    <?php echo htmlspecialchars($u['nome_completo']); ?> (<?php echo htmlspecialchars($u['email']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Data/Hora</th>
                        <th>Usuário</th>
                        <th>Perfil</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($logs) === 0): ?>
                        <tr><td colspan="5" class="text-center">Nenhum log encontrado.</td></tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($log['id']); ?></td>
                                <td><?php echo htmlspecialchars($log['data_hora']); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($log['nome_completo']); ?>
                                    <br>
                                    <small class="text-muted"><?php echo htmlspecialchars($log['email']); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($log['nome_perfil']); ?></td>
                                <td><?php echo htmlspecialchars($log['status_autenticacao']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include __DIR__ . '/../assets/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
