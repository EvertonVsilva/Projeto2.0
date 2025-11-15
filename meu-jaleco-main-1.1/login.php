<?php
// Inicia a sessão
session_start();
include './assets/includes/header.php';

// Verifica se o usuário já está logado, se sim, redireciona apropriadamente
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    if (isset($_SESSION['id_perfil']) && $_SESSION['id_perfil'] == 1) {
        header("Location: admin/dashboard-master.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

// Variáveis para mensagens
$mensagem_erro = isset($_SESSION['erro_login']) ? $_SESSION['erro_login'] : '';
$mensagem_sucesso = isset($_SESSION['mensagem_sucesso']) ? $_SESSION['mensagem_sucesso'] : '';
unset($_SESSION['erro_login']); // Limpa a mensagem de erro da sessão
unset($_SESSION['mensagem_sucesso']); // Limpa a mensagem de sucesso da sessão
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meu Jaleco - Catálogo Virtual</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/login.css">

</head>

<body>

    <div class="container container-login">
        <div class="card cartao-login shadow-lg">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Acesso ao Sistema</h3>

                <?php if ($mensagem_erro): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $mensagem_erro; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($mensagem_sucesso): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $mensagem_sucesso; ?>
                    </div>
                <?php endif; ?>

                <form action="/meu-jaleco-main/validacao-login.php" method="POST">

                    <div class="mb-3">
                        <label for="campo_login" class="form-label">Login (Usuário ou E-mail)</label>
                        <input type="text"
                            class="form-control"
                            id="campo_login"
                            name="campo_login"
                            placeholder="Seu login"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="campo_senha" class="form-label">Senha</label>
                        <input type="password"
                            class="form-control"
                            id="campo_senha"
                            name="campo_senha"
                            placeholder="Sua senha"
                            required>
                    </div>

                    <button type="submit" name="botao_entrar" class="btn btn-primary w-100">Entrar</button>
                    <button type="reset" class="btn btn-secondary w-100 mt-2">
                        <i class="bi bi-x-circle"></i> Limpar
                    </button>
                </form>

                <hr>

                <div class="text-center mt-3">
                    <p class="mb-1">É novo por aqui?</p>
                    <a href="/meu-jaleco-main/cadastro.php" class="btn btn-outline-secondary w-100" id="link_cadastro">
                        Cadastre-se Agora
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Script modo escuro -->
    <script src="assets/js/dark-mode.js"></script>
    <script src="assets/js/acessibilidade-fonte.js"></script>

</body>

</html>