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
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/sobre.css">

</head>

<body>

    <?php
    include './assets/includes/header.php';
    ?>

    <header id="cabecalho-principal" class="text-center">
        <div class="container">
            <h1 class="display-4 titulo-destaque">Nossa História na Área Hospitalar</h1>
            <p class="lead text-muted mt-3">
                Excelência, Segurança e Inovação em vestuário para a saúde, desde [Ano de Fundação].
            </p>
        </div>
    </header>

    <section id="introducao" class="secao-sobre">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="titulo-destaque mb-4">Quem Somos</h2>
                    <p class="fs-5">
                        A Meu Jaleco nasceu para ser a principal fonte de <strong class="text-secondary">roupas e uniformes médicos</strong> de alta performance. Unimos o rigor da área da saúde com o melhor da tecnologia têxtil, garantindo proteção, durabilidade e conforto inigualáveis.
                    </p>
                    <p>
                        Nosso compromisso vai além da venda: é garantir que o seu foco seja total na saúde, enquanto nós cuidamos do seu vestuário.
                    </p>
                </div>
                <div class="col-lg-6">
                    <img src="./assets/image/fabrica-textil.jpg" class="img-fluid rounded-3 shadow-lg" alt="Nossa Fábrica e Processo">
                </div>
            </div>
        </div>
    </section>

    <section id="mvv" class="secao-sobre bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="titulo-destaque">Nosso Propósito</h2>
                <p class="lead text-muted">Princípios que guiam nossa excelência no fornecimento.</p>
            </div>

            <div class="row text-center">

                <div class="col-md-4 mb-4">
                    <div class="card cartao-elevado p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-bullseye icone-principal"></i>
                            <h5 class="card-title fw-bold">Missão</h5>
                            <p class="card-text">Fornecer vestuário hospitalar que garanta segurança, higiene e máximo conforto.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card cartao-elevado p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-eye icone-principal"></i>
                            <h5 class="card-title fw-bold">Visão</h5>
                            <p class="card-text">Ser o catálogo online mais confiável e inovador do setor de roupas hospitalares.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card cartao-elevado p-4 h-100">
                        <div class="card-body">
                            <i class="fas fa-hands-helping icone-principal"></i>
                            <h5 class="card-title fw-bold">Valores</h5>
                            <p class="card-text">Qualidade Impecável, Responsabilidade, Confiança, e Inovação Contínua.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="habilidades" class="secao-sobre">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="titulo-destaque mb-4">Credibilidade em Números</h2>
                    <p class="lead mb-4">
                        Nossa dedicação à qualidade e eficiência é a base para o sucesso de nossos parceiros.
                    </p>

                    <h6 class="fw-bold mt-4">Qualidade Têxtil</h6>
                    <div class="progress mb-3" role="progressbar" aria-label="Qualidade Têxtil" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 95%;">95% Conformidade ABNT</div>
                    </div>

                    <h6 class="fw-bold mt-4">Eficiência Logística</h6>
                    <div class="progress mb-3" role="progressbar" aria-label="Eficiência Logística" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 90%;">90% Entrega no Prazo</div>
                    </div>

                    <h6 class="fw-bold mt-4">Índice de Satisfação</h6>
                    <div class="progress mb-3" role="progressbar" aria-label="Índice de Satisfação" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: 98%;">98% Aprovação do Cliente</div>
                    </div>
                </div>

                <div class="col-lg-6 text-center">
                    <img src="./assets/image/certificado-qualidade.png" class="certificado-qualidade img-fluid rounded-circle shadow-lg" alt="Certificações de Qualidade">
                </div>
            </div>
        </div>
    </section>

    <section id="depoimentos" class="secao-sobre bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="titulo-destaque">O Que Nossos Clientes Dizem</h2>
                <p class="lead text-muted">A voz de quem confia na nossa linha de vestuário hospitalar.</p>
            </div>

            <div id="carrosselDepoimentos" class="carousel slide carousel-dark" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <i class="fas fa-quote-left display-4 text-muted mb-3"></i>
                                <p class="depoimento-texto">
                                    "A durabilidade e a qualidade dos uniformes da [Nome da Sua Empresa] superaram nossas expectativas. Isso garante a segurança de nossos colaboradores e reduz nossos custos de reposição."
                                </p>
                                <p class="fw-bold mt-4 mb-0">Dr. Ricardo Almeida</p>
                                <p class="text-muted">Diretor Administrativo, Hospital Central de SP</p>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <i class="fas fa-quote-left display-4 text-muted mb-3"></i>
                                <p class="depoimento-texto">
                                    "O processo de compra online é incrivelmente fácil, e o suporte sempre nos ajuda a escolher os tecidos mais adequados para cada setor. Recomendo o catálogo!"
                                </p>
                                <p class="fw-bold mt-4 mb-0">Enf. Patricia Souza</p>
                                <p class="text-muted">Chefe de Enfermagem, Clínica Vida Nova</p>
                            </div>
                        </div>
                    </div>

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carrosselDepoimentos" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carrosselDepoimentos" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>
        </div>
    </section>

    <section id="chamada-acao" class="secao-sobre text-white" style="background-color: var(--cor-principal);">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Pronto para Modernizar Seu Estoque?</h2>
            <p class="lead mb-4">
                Explore nosso catálogo completo e descubra a diferença que a qualidade faz.
            </p>
            <a href="link-para-o-catalogo.html" class="btn btn-light btn-lg shadow-sm fw-bold">Ver Catálogo de Roupas</a>
        </div>
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
    <script src="assets/js/acessibilidade-fonte.js"></script>
</body>

</html>