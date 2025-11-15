<?php
session_start();

// Verifica se está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: login.php');
    exit;
}

// Conecta ao banco de dados
$mysqli = require __DIR__ . '/admin/db.php';

// Busca as informações completas do usuário
$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT u.*, e.logradouro, e.numero, e.complemento, e.bairro, e.cidade, e.estado, e.cep, p.nome_perfil 
        FROM usuario u 
        LEFT JOIN endereco e ON u.id_endereco = e.id 
        LEFT JOIN perfil p ON u.id_perfil = p.id 
        WHERE u.id = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

if (!$usuario) {
    echo "Erro ao carregar perfil.";
    exit;
}

// Formata a data de nascimento
$data_nascimento = DateTime::createFromFormat('Y-m-d', $usuario['data_nascimento']);
$data_formatada = $data_nascimento ? $data_nascimento->format('d/m/Y') : 'N/A';

// Formata o CPF
$cpf_formatado = substr($usuario['cpf'], 0, 3) . '.' . 
                 substr($usuario['cpf'], 3, 3) . '.' . 
                 substr($usuario['cpf'], 6, 3) . '-' . 
                 substr($usuario['cpf'], 9, 2);

// Formata o sexo
$sexo_completo = [
    'M' => 'Masculino',
    'F' => 'Feminino',
    'O' => 'Outro'
];
$sexo_exibicao = isset($sexo_completo[$usuario['sexo']]) ? $sexo_completo[$usuario['sexo']] : $usuario['sexo'];
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meu Perfil - Meu Jaleco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include './assets/includes/header.php'; ?>

    <main class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="bi bi-person-circle"></i> Meu Perfil</h2>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-person-badge"></i> Informações Pessoais</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nome Completo:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['nome_completo']); ?></p>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Data de Nascimento:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($data_formatada); ?></p>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Sexo:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($sexo_exibicao); ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nome Materno:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['nome_materno']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">CPF:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($cpf_formatado); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-envelope"></i> Informações de Contato</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">E-mail:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['email']); ?></p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Celular:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['celular']); ?></p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Telefone Fixo:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['telefone']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Endereço</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">CEP:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['cep'] ?? 'N/A'); ?></p>
                            </div>
                            <div class="col-md-9">
                                <label class="form-label fw-bold">Logradouro:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['logradouro'] ?? 'N/A'); ?></p>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Número:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['numero'] ?? 'N/A'); ?></p>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold">Complemento:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['complemento'] ?? 'N/A'); ?></p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Bairro:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['bairro'] ?? 'N/A'); ?></p>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Cidade:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['cidade'] ?? 'N/A'); ?></p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Estado:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['estado'] ?? 'N/A'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-key"></i> Informações de Acesso</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['erro_senha'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php 
                                echo htmlspecialchars($_SESSION['erro_senha']); 
                                unset($_SESSION['erro_senha']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['sucesso_senha'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php 
                                echo htmlspecialchars($_SESSION['sucesso_senha']); 
                                unset($_SESSION['sucesso_senha']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Login:</label>
                                <p class="form-control-plaintext"><?php echo htmlspecialchars($usuario['login']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Perfil:</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-primary"><?php echo htmlspecialchars($usuario['nome_perfil']); ?></span>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Senha:</label>
                                <div class="d-flex align-items-center">
                                    <p class="form-control-plaintext mb-0">••••••••</p>
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-3" data-bs-toggle="modal" data-bs-target="#modalTrocarSenha">
                                        <i class="bi bi-pencil"></i> Alterar Senha
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Modal para Trocar Senha -->
    <div class="modal fade" id="modalTrocarSenha" tabindex="-1" aria-labelledby="modalTrocarSenhaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTrocarSenhaLabel">
                        <i class="bi bi-key-fill"></i> Alterar Senha
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="alterar_senha.php" id="formTrocarSenha">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="senha_atual" class="form-label">Senha Atual *</label>
                            <input type="password" class="form-control" id="senha_atual" name="senha_atual" required maxlength="8">
                            <div class="form-text">Digite sua senha atual para confirmar.</div>
                        </div>
                        <div class="mb-3">
                            <label for="nova_senha" class="form-label">Nova Senha *</label>
                            <input type="password" class="form-control" id="nova_senha" name="nova_senha" required maxlength="8">
                            <div class="form-text">A senha deve ter exatamente 8 caracteres alfanuméricos (letras e números).</div>
                        </div>
                        <div class="mb-3">
                            <label for="confirmar_senha" class="form-label">Confirmar Nova Senha *</label>
                            <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required maxlength="8">
                            <div id="feedback_confirmar" class="invalid-feedback">As senhas não coincidem.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Confirmar Alteração
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include './assets/includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dark-mode.js"></script>
    <script src="assets/js/acessibilidade-fonte.js"></script>
    <script>
        // Validação do formulário de troca de senha
        document.getElementById('formTrocarSenha').addEventListener('submit', function(e) {
            const novaSenha = document.getElementById('nova_senha').value;
            const confirmarSenha = document.getElementById('confirmar_senha').value;
            const confirmarInput = document.getElementById('confirmar_senha');
            
            // Validação: senha deve ter exatamente 8 caracteres alfanuméricos
            const regexSenha = /^[a-zA-Z0-9]{8}$/;
            
            if (!regexSenha.test(novaSenha)) {
                e.preventDefault();
                alert('A nova senha deve ter exatamente 8 caracteres alfanuméricos (letras e números).');
                return false;
            }
            
            // Validação: senhas devem ser iguais
            if (novaSenha !== confirmarSenha) {
                e.preventDefault();
                confirmarInput.classList.add('is-invalid');
                return false;
            }
            
            confirmarInput.classList.remove('is-invalid');
            return true;
        });
        
        // Remove a classe de erro quando o usuário digita
        document.getElementById('confirmar_senha').addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    </script>
</body>
</html>
