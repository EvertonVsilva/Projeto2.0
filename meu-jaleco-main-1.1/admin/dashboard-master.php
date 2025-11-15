<?php
session_start();
// Verifica se está logado como master
if (!isset($_SESSION['logado']) || !isset($_SESSION['perfil_usuario']) || ($_SESSION['perfil_usuario'] !== 'Master' && $_SESSION['perfil_usuario'] !== 'Admin')) {
    header('Location: ../login.php');
    exit;
}

$mysqli = require __DIR__ . '/db.php';

// Estatísticas gerais
$stats = [
    'total_usuarios' => 0,
    'total_logs' => 0,
    'usuarios_por_perfil' => []
];

// Total de usuários
if ($res = $mysqli->query('SELECT COUNT(*) as total FROM usuario')) {
    $row = $res->fetch_assoc();
    $stats['total_usuarios'] = $row['total'];
    $res->free();
}

// Total de logs
if ($res = $mysqli->query('SELECT COUNT(*) as total FROM log')) {
    $row = $res->fetch_assoc();
    $stats['total_logs'] = $row['total'];
    $res->free();
}

// Usuários por perfil
if ($res = $mysqli->query('SELECT p.nome_perfil, COUNT(u.id) as total FROM perfil p LEFT JOIN usuario u ON p.id = u.id_perfil GROUP BY p.id, p.nome_perfil')) {
    while ($row = $res->fetch_assoc()) {
        $stats['usuarios_por_perfil'][] = $row;
    }
    $res->free();
}

// Últimos logs
$ultimos_logs = [];
$sql = "SELECT l.id, u.nome_completo, l.data_hora, l.status_autenticacao 
        FROM log l 
        LEFT JOIN usuario u ON l.id_usuario = u.id 
        ORDER BY l.data_hora DESC 
        LIMIT 10";
if ($res = $mysqli->query($sql)) {
    while ($row = $res->fetch_assoc()) {
        $ultimos_logs[] = $row;
    }
    $res->free();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Master</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/telaadmin.css">
</head>
<body>
    <?php include __DIR__ . '/../assets/includes/header.php'; ?>

    <main class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard Master</h2>
            <div>
                <a href="painel.php" class="btn btn-secondary">Voltar ao Painel</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Estatísticas Gerais</h5>
                    </div>
                    <div class="card-body">
                        <p>Total de Usuários: <?php echo htmlspecialchars($stats['total_usuarios']); ?></p>
                        <p>Total de Logs: <?php echo htmlspecialchars($stats['total_logs']); ?></p>
                        
                        <h6 class="mt-4">Usuários por Perfil:</h6>
                        <ul class="list-unstyled">
                            <?php foreach ($stats['usuarios_por_perfil'] as $up): ?>
                                <li><?php echo htmlspecialchars($up['nome_perfil']); ?>: <?php echo htmlspecialchars($up['total']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Últimos Logs</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Data/Hora</th>
                                        <th>Usuário</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ultimos_logs as $log): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($log['data_hora']); ?></td>
                                            <td><?php echo htmlspecialchars($log['nome_completo']); ?></td>
                                            <td><?php echo htmlspecialchars($log['status_autenticacao']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../assets/includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dark-mode.js"></script>
    <script src="../assets/js/acessibilidade-fonte.js"></script>
</body>
</html>
