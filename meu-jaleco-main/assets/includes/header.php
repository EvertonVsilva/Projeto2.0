<?php
//
// NOTA: session_start() deve ser chamado no início de CADA página 
// (ex: no topo do catalogo.php, index.php, etc.) ANTES do include do header.

// Verifica se o usuário está logado na sessão
$logado = isset($_SESSION['logado']) && $_SESSION['logado'] === true;

// Define as variáveis do usuário logado (se existirem)
$nome_exibicao = $logado ? htmlspecialchars($_SESSION['nome_exibicao']) : '';
$perfil_usuario = $logado ? (isset($_SESSION['perfil_usuario']) ? $_SESSION['perfil_usuario'] : 'CLIENTE') : '';

// Determina a página atual para destacar o item de navegação correto
$pagina_atual = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark barra-navegacao">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="/meu-jaleco-main/index.php">
            <img src="/meu-jaleco-main/assets/icon/logo.png" alt="Logo Meu Jaleco" title="Home" class="rounded-circle" style="height:50px;">
        </a>

        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
            data-bs-target="#menu-navegacao" aria-controls="menu-navegacao" aria-expanded="false"
            aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu-navegacao">
            <ul class="navbar-nav mb-2 mb-lg-0 text-center mx-auto">
                <li class="nav-item"><a class="nav-link <?php echo $pagina_atual === 'index.php' || $pagina_atual === '' ? 'active' : ''; ?>" href="/meu-jaleco-main/index.php">Início</a></li>
                <li class="nav-item"><a class="nav-link <?php echo $pagina_atual === 'sobre.php' ? 'active' : ''; ?>" href="/meu-jaleco-main/sobre.php">Sobre Nós</a></li>
                <?php if ($logado): ?>
                <li class="nav-item"><a class="nav-link <?php echo $pagina_atual === 'catalogo.php' ? 'active' : ''; ?>" href="/meu-jaleco-main/catalogo.php">Catálogo</a></li>
                <?php endif; ?>

                <?php if ($logado && ($perfil_usuario === 'Admin' || $perfil_usuario === 'Master')): ?>
                    <li class="nav-item">
                        <a class="nav-link text-warning fw-bold <?php echo $pagina_atual === 'painel.php' ? 'active' : ''; ?>" href="/meu-jaleco-main/admin/painel.php">Painel Admin</a>
                    </li>
                    <?php if ($perfil_usuario === 'Master'): ?>
                    <li class="nav-item">
                        <a class="nav-link text-warning fw-bold <?php echo $pagina_atual === 'dashboard-master.php' ? 'active' : ''; ?>" href="/meu-jaleco-main/admin/dashboard-master.php">Dashboard Master</a>
                    </li>
                    <?php endif; ?>
                <?php endif; ?>

                <li class="nav-item mt-2 d-lg-none">
                    <?php if ($logado): ?>
                        <span class="nav-link text-white">Olá, **<?php echo $nome_exibicao; ?>**!</span>
                        <a href="/meu-jaleco-main/logout.php" class="nav-link btn btn-outline-danger text-center mt-1">Sair</a>
                    <?php else: ?>
                        <a href="/meu-jaleco-main/login.php" class="nav-link btn text-center btn-warning text-dark fw-semibold">Login</a>
                    <?php endif; ?>
                </li>

                <li class="nav-item mb-2 d-lg-none">
                    <button id="botao-modo-escuro-mobile" class="btn btn-dark">
                        <i id="icone-modo-escuro-mobile" class="bi bi-moon-fill"></i> Alternar Tema
                    </button>
                </li>
            </ul>

            <div class="d-none d-lg-flex ms-auto align-items-center">
                <?php if ($logado): ?>
                    <span class="navbar-text me-3 text-white">
                        Olá, **<?php echo $nome_exibicao; ?>**!
                    </span>
                    <a href="/meu-jaleco-main/logout.php" class="btn btn-outline-danger fw-semibold me-2" id="botao_sair">
                        <i class="bi bi-box-arrow-right"></i> Sair
                    </a>
                <?php else: ?>
                    <a href="/meu-jaleco-main/login.php" class="btn btn-warning text-dark fw-semibold me-2">
                        <i class="bi bi-person-circle"></i> Login
                    </a>
                <?php endif; ?>

                <button id="botao-modo-escuro-desktop" class="btn btn-dark">
                    <i id="icone-modo-escuro-desktop" class="bi bi-moon-fill"></i>
                </button>
            </div>
        </div>
    </div>
</nav>