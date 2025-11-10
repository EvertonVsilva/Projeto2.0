<?php
session_start();
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
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>

    <?php
    include './assets/includes/header.php';
    ?>

    <!-- Banner -->
    <section class="secao-banner text-center text-white mb-5 py-5">
        <div class="container">
            <h1 class="display-5 fw-bold">Bem-vindo, Somos um Catálogo Virtual</h1>
            <p class="lead">Estamos aqui para lhe auxiliar na escolha de cores e tamanhos desejados</p>
        </div>
    </section>

    <!-- Produtos em destaque -->
    <section class="container mb-5 secao-produtos">
        <h2 class="text-center mb-4">Produtos em Destaque</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 shadow-sm text-center">
                    <img src="./assets/image/produtos/jaleco-feminino.png" class="card-img-top" alt="Jaleco Feminino">
                    <div class="card-body">
                        <h5 class="card-title">Jaleco Feminino</h5>
                        <p class="card-text text-danger fw-bold">R$ 99,90</p>
                        <a href="./cadastro.php" class="btn btn-primary">Ver Detalhes</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm text-center">
                    <img src="./assets/image/produtos/jaleco-masculino.jpg" class="card-img-top" alt="Jaleco Masculino">
                    <div class="card-body">
                        <h5 class="card-title">Jaleco Masculino</h5>
                        <p class="card-text text-danger fw-bold">R$ 104,90</p>
                        <a href="./cadastro.php" class="btn btn-primary">Ver Detalhes</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm text-center">
                    <img src="./assets/image/produtos/calcado-hospitalar.jpg" class="card-img-top" alt="Calçado Hospitalar">
                    <div class="card-body">
                        <h5 class="card-title">Calçado Hospitalar</h5>
                        <p class="card-text text-danger fw-bold">R$ 129,90</p>
                        <a href="./cadastro.php" class="btn btn-primary">Ver Detalhes</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefícios -->
    <section class="container text-center py-5 mb-5 secao-beneficios">
        <h2 class="mb-5">Por que escolher nossos uniformes?</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <div class="col">
                <div class="card p-3 h-100">
                    <i class="bi bi-person-check-fill text-primary fs-1 mb-3"></i>
                    <h5 class="fw-bold">Conforto</h5>
                    <p>Tecidos respiráveis e confortáveis</p>
                </div>
            </div>
            <div class="col">
                <div class="card p-3 h-100">
                    <i class="bi bi-truck text-primary fs-1 mb-3"></i>
                    <h5 class="fw-bold">Entrega Rápida</h5>
                    <p>Entrega em todo o Brasil</p>
                </div>
            </div>
            <div class="col">
                <div class="card p-3 h-100">
                    <i class="bi bi-shield-lock-fill text-primary fs-1 mb-3"></i>
                    <h5 class="fw-bold">Durabilidade</h5>
                    <p>Fácil de lavar e muito resistente</p>
                </div>
            </div>
            <div class="col">
                <div class="card p-3 h-100">
                    <i class="bi bi-palette-fill text-primary fs-1 mb-3"></i>
                    <h5 class="fw-bold">Personalização</h5>
                    <p>Personalize com o logo da sua clínica</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Quem Somos -->
    <section class="container text-center mb-5 secao-sobre">
        <h2 class="mb-3">Quem Somos</h2>
        <p class="mb-4">Somos especialistas em roupas hospitalares, oferecendo qualidade, conforto e confiança para
            profissionais da saúde.</p>
        <h3 class="mb-3">Pronto para renovar seu uniforme?</h3>
        <a href="https://wa.me/+5521970282127" class="btn btn-success btn-lg" target="_blank">Fale no WhatsApp</a>
    </section>

    <?php
    include './assets/includes/footer.php';
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Script modo escuro -->
    <script src="assets/js/dark-mode.js"></script>
</body>

</html>