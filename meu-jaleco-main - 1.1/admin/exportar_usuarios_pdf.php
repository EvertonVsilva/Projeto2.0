<?php
session_start();
// Verifica se está logado como admin ou master
if (!isset($_SESSION['logado']) || !isset($_SESSION['perfil_usuario']) || ($_SESSION['perfil_usuario'] !== 'Admin' && $_SESSION['perfil_usuario'] !== 'Master')) {
    header('Location: ../login.php');
    exit;
}

// Conecta ao banco de dados
$mysqli = require __DIR__ . '/db.php';

// Buscar todos os usuários com informações completas
$sql = "SELECT u.id, u.nome_completo, u.email, u.cpf, u.celular, u.telefone, 
               u.data_nascimento, u.sexo, p.nome_perfil,
               e.logradouro, e.numero, e.bairro, e.cidade, e.estado, e.cep
        FROM usuario u 
        LEFT JOIN perfil p ON u.id_perfil = p.id 
        LEFT JOIN endereco e ON u.id_endereco = e.id
        ORDER BY u.id ASC";

$result = $mysqli->query($sql);
$usuarios = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
    $result->free();
}

// Criar PDF usando HTML e CSS (método alternativo sem biblioteca externa)
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .info {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .usuario {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 15px;
            page-break-inside: avoid;
            background-color: #f9f9f9;
        }
        .usuario-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            margin: -15px -15px 15px -15px;
            font-weight: bold;
            font-size: 14px;
        }
        .row {
            display: flex;
            margin-bottom: 8px;
        }
        .label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        .value {
            flex: 1;
            color: #333;
        }
        .section-title {
            font-weight: bold;
            color: #007bff;
            margin-top: 15px;
            margin-bottom: 10px;
            font-size: 13px;
            border-bottom: 1px solid #007bff;
            padding-bottom: 5px;
        }
        .btn-print {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }
        .btn-print:hover {
            background-color: #0056b3;
        }
        @page {
            margin: 1cm;
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">🖨️ Imprimir / Salvar PDF</button>
    
    <h1>Lista de Usuários Cadastrados</h1>
    <div class="info">
        Total de usuários: <?php echo count($usuarios); ?> | 
        Data de geração: <?php echo date('d/m/Y H:i:s'); ?> |
        Gerado por: <?php echo htmlspecialchars($_SESSION['nome_exibicao']); ?>
    </div>

    <?php foreach ($usuarios as $u): ?>
        <div class="usuario">
            <div class="usuario-header">
                Usuário #<?php echo htmlspecialchars($u['id']); ?> - <?php echo htmlspecialchars($u['nome_completo']); ?>
            </div>

            <div class="section-title">Dados Pessoais</div>
            <div class="row">
                <span class="label">Nome Completo:</span>
                <span class="value"><?php echo htmlspecialchars($u['nome_completo']); ?></span>
            </div>
            <div class="row">
                <span class="label">CPF:</span>
                <span class="value"><?php 
                    $cpf = $u['cpf'];
                    echo substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
                ?></span>
            </div>
            <div class="row">
                <span class="label">Data Nascimento:</span>
                <span class="value"><?php 
                    $data = DateTime::createFromFormat('Y-m-d', $u['data_nascimento']);
                    echo $data ? $data->format('d/m/Y') : 'N/A';
                ?></span>
            </div>
            <div class="row">
                <span class="label">Sexo:</span>
                <span class="value"><?php 
                    $sexo = ['M' => 'Masculino', 'F' => 'Feminino', 'O' => 'Outro'];
                    echo isset($sexo[$u['sexo']]) ? $sexo[$u['sexo']] : $u['sexo'];
                ?></span>
            </div>

            <div class="section-title">Contato</div>
            <div class="row">
                <span class="label">E-mail:</span>
                <span class="value"><?php echo htmlspecialchars($u['email']); ?></span>
            </div>
            <div class="row">
                <span class="label">Celular:</span>
                <span class="value"><?php echo htmlspecialchars($u['celular']); ?></span>
            </div>
            <div class="row">
                <span class="label">Telefone Fixo:</span>
                <span class="value"><?php echo htmlspecialchars($u['telefone']); ?></span>
            </div>

            <div class="section-title">Endereço</div>
            <div class="row">
                <span class="label">Logradouro:</span>
                <span class="value"><?php echo htmlspecialchars($u['logradouro'] ?? 'N/A'); ?></span>
            </div>
            <div class="row">
                <span class="label">Número:</span>
                <span class="value"><?php echo htmlspecialchars($u['numero'] ?? 'N/A'); ?></span>
            </div>
            <div class="row">
                <span class="label">Bairro:</span>
                <span class="value"><?php echo htmlspecialchars($u['bairro'] ?? 'N/A'); ?></span>
            </div>
            <div class="row">
                <span class="label">Cidade/Estado:</span>
                <span class="value"><?php echo htmlspecialchars(($u['cidade'] ?? 'N/A') . ' - ' . ($u['estado'] ?? 'N/A')); ?></span>
            </div>
            <div class="row">
                <span class="label">CEP:</span>
                <span class="value"><?php echo htmlspecialchars($u['cep'] ?? 'N/A'); ?></span>
            </div>

            <div class="section-title">Informações de Sistema</div>
            <div class="row">
                <span class="label">Perfil:</span>
                <span class="value"><?php echo htmlspecialchars($u['nome_perfil']); ?></span>
            </div>
        </div>
    <?php endforeach; ?>

    <script>
        // Auto-imprime ao carregar (opcional)
        // window.onload = function() { window.print(); };
    </script>
</body>
</html>
