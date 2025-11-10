<?php
session_start();
// Proteção: somente usuários logados podem ver o catálogo
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: login.php');
    exit;
}
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
</head>

<body>

    <?php
    include './assets/includes/header.php';
    ?>

    <main class="container my-5">
        <h2 class="text-center mb-4">Catálogo de Jalecos</h2>

        <div class="row">

            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card text-center h-100 ">
                    <img src="./assets/image/produtos/jaleco-feminino.png" class="image-card card-img-top" alt="Jaleco Gola Padre Branco">
                    <div class="card-body">
                        <h4 class="card-title">Jaleco Gola Padre</h4>
                        <p class="card-text">Jaleco Feminino Branco Gola Padre com Zíper</p>
                        <a href="#" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-prod1">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card text-center h-100">
                    <img src="./assets/image/produtos/jaleco-masculino.jpg" class=" card-img-top" alt="Jaleco Tradicional Branco">
                    <div class="card-body">
                        <h4 class="card-title">Jaleco Tradicional</h4>
                        <p class="card-text">Jaleco Masculino Branco Gola Tradicional com Botões.</p>
                        <a href="#" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-prod2">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card text-center h-100">
                    <img src="./assets/image/produtos/scrub-feminino.jpg" class="card-img-top" alt="Conjunto Pijama Cirurgico Scrub Vinho">
                    <div class="card-body">
                        <h4 class="card-title">Conjunto Pijama Cirurgico Scrub</h4>
                        <p class="card-text">Conjunto Pijama Cirurgico Scrub Vinho Gola V</p>
                        <a href="#" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-prod3">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card text-center h-100">
                    <img src="./assets/image/produtos/scrub-masculino.jpg" class="card-img-top" alt="Conjunto Pijama Cirurgico Scrub Azul">
                    <div class="card-body">
                        <h4 class="card-title">Conjunto Pijama Cirurgico Scrub</h4>
                        <p class="card-text">Conjunto Pijama Cirurgico Scrub Azul Gola V</p>
                        <a href="#" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-prod4">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card text-center h-100">
                    <img src="./assets/image/produtos/touca-cirurgica.jpg" class="card-img-top" alt="Touca Cirúrgica Hospitalar">
                    <div class="card-body">
                        <h4 class="card-title">Touca Cirúrgica</h4>
                        <p class="card-text">Touca Cirúrgica Hospitalar Azul Claro com Amarração</p>
                        <a href="#" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-prod5">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card text-center h-100">
                    <img src="./assets/image/produtos/mascara-protetora-facial.jpg" class="card-img-top" alt="Protetor Facial Face Shield">
                    <div class="card-body">
                        <h4 class="card-title">Protetor Facial</h4>
                        <p class="card-text">Protetor Facial Face Shield EPI Transparente Ajustável.</p>
                        <a href="#" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-prod6">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card text-center h-100">
                    <img src="./assets/image/produtos/camisola-paciente-hospitalar.jpg" class="card-img-top" alt="Avental Hospitalar para Paciente">
                    <div class="card-body">
                        <h4 class="card-title">Avental Hospitalar</h4>
                        <p class="card-text">Avental Hospitalar Descartável Azul Paciente.</p>
                        <a href="#" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-prod7">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card text-center h-100">
                    <img src="./assets/image/produtos/calcado-hospitalar.jpg" class="card-img-top" alt="Sapato Hospitalar Antiderrapante">
                    <div class="card-body">
                        <h4 class="card-title">Sapato Hospitalar</h4>
                        <p class="card-text">Sapato Hospitalar Branco Antiderrapante EPI</p>
                        <a href="#" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-prod8">Ver Detalhes</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4 mb-4">
                <div class="card text-center h-100">
                    <img src="./assets/image/produtos/avental-cirurgico.jpg" class="card-img-top" alt="Avental Cirúrgico Azul">
                    <div class="card-body">
                        <h4 class="card-title">Avental Cirúrgico</h4>
                        <p class="card-text">Avental Cirúrgico Azul Descartável.</p>
                        <a href="#" class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-prod9">Ver Detalhes</a>
                    </div>
                </div>
            </div>

        </div>
    </main>


    <!-- MODAL DE PRODUTOS -->
    <div class="modal fade" id="modal-prod1" tabindex="-1" aria-labelledby="modal-prod1-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="./assets/image/produtos/jaleco-feminino.png" class="img-fluid" alt="Jaleco Branco Gola Padre">
                        </div>
                        <div class="col-md-7">
                            <h3>Jaleco Branco Gola Padre</h3>
                            <h4 class="text-success">R$: 139,99</h4>
                            <p>
                            <ul>
                                <li>Fechamento: Zíper frontal (total ou invisível).</li>
                                <li>Gola: Gola Padre / Mandarim, que proporciona um visual elegante.</li>
                                <li>Manga: Longa com punho de elástico para melhor ajuste e proteção.</li>
                                <li>Bolsos: 2 bolsos inferiores amplos e funcionais, ideais para guardar instrumentos.</li>
                                <li>Tecido: Oxford de alta qualidade, 100% Poliéster.</li>
                            </ul>
                            </p>

                            <form>
                                <div class="mb-3">
                                    <label for="tamanho1" class="form-label">Tamanhos Disponíveis:</label>
                                    <select class="form-select" id="tamanho1" required>
                                        <option value="">Escolha...</option>
                                        <option value="PP">PP</option>
                                        <option value="P">P</option>
                                        <option value="M">M</option>
                                        <option value="G">G</option>
                                        <option value="GG">GG</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-prod2" tabindex="-1" aria-labelledby="modal-prod2-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="./assets/image/produtos/jaleco-masculino.jpg" class="img-fluid" alt="Jaleco Branco Tradicional">
                        </div>
                        <div class="col-md-7">
                            <h3>Jaleco Branco Tradicional</h3>
                            <h4 class="text-success">R$: 119,99</h4>
                            <p>
                            <ul>
                                <li>Fechamento: Botões frontais tradicionais.</li>
                                <li>Gola: Gola de Ponta/Vira (ou Gola Esporte), o padrão clássico profissional.</li>
                                <li>Manga: Manga Longa com punho simples e costura reforçada.</li>
                                <li>Bolsos: Três bolsos funcionais: Um bolso superior e Dois bolsos inferiores frontais.</li>
                                <li>Tecido: Oxford de alta qualidade, 100% Poliéster.</li>
                            </ul>
                            </p>

                            <form>
                                <div class="mb-3">
                                    <label for="tamanho2" class="form-label">Tamanhos Disponíveis:</label>
                                    <select class="form-select" id="tamanho2" required>
                                        <option value="">Escolha...</option>
                                        <option value="PP">PP</option>
                                        <option value="P">P</option>
                                        <option value="M">M</option>
                                        <option value="G">G</option>
                                        <option value="GG">GG</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-prod3" tabindex="-1" aria-labelledby="modal-prod3-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="./assets/image/produtos/scrub-feminino.jpg" class="img-fluid" alt="Conjunto Scrub Pijama Cirúrgico Vinho">
                        </div>
                        <div class="col-md-7">
                            <h3>Conjunto Scrub Pijama Cirúrgico Vinho</h3>
                            <h4 class="text-success">R$: 95,99</h4>
                            <p>
                            <ul>
                                <li>Cor: Vinho / Bordô</li>
                                <li>Gola: Decote V (Gola V), design clássico.</li>
                                <li>Manga: Curta, com costura e barra simples.</li>
                                <li>Bolsos: Três bolsos funcionais: Um bolso superior e Dois bolsos inferiores frontais.</li>
                                <li>Tecido: Oxford de alta qualidade, 100% Poliéster.</li>
                            </ul>
                            </p>

                            <form>
                                <div class="mb-3">
                                    <label for="tamanho3" class="form-label">Tamanhos Disponíveis:</label>
                                    <select class="form-select" id="tamanho3" required>
                                        <option value="">Escolha...</option>
                                        <option value="PP">PP</option>
                                        <option value="P">P</option>
                                        <option value="M">M</option>
                                        <option value="G">G</option>
                                        <option value="GG">GG</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-prod4" tabindex="-1" aria-labelledby="modal-prod4-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="./assets/image/produtos/scrub-masculino.jpg" class="img-fluid" alt="Conjunto Scrub Pijama Cirúrgico Azul Marinho">
                        </div>
                        <div class="col-md-7">
                            <h3>Conjunto Scrub Pijama Cirúrgico Azul Marinho</h3>
                            <h4 class="text-success">R$: 95,99</h4>
                            <p>
                            <ul>
                                <li>Cor: Azul Marinho</li>
                                <li>Gola: Decote V (Gola V), design clássico.</li>
                                <li>Manga: Curta, com costura e barra simples.</li>
                                <li>Bolsos: Três bolsos funcionais: Um bolso superior e Dois bolsos inferiores frontais.</li>
                                <li>Tecido: Oxford de alta qualidade, 100% Poliéster.</li>
                            </ul>
                            </p>

                            <form>
                                <div class="mb-3">
                                    <label for="tamanho3" class="form-label">Tamanhos Disponíveis:</label>
                                    <select class="form-select" id="tamanho3" required>
                                        <option value="">Escolha...</option>
                                        <option value="PP">PP</option>
                                        <option value="P">P</option>
                                        <option value="M">M</option>
                                        <option value="G">G</option>
                                        <option value="GG">GG</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-prod5" tabindex="-1" aria-labelledby="modal-prod5-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="assets/image/produtos/touca-cirurgica.jpg" class="img-fluid" alt="Touca Cirúrgica Hospitalar Azul Claro">
                        </div>
                        <div class="col-md-7">
                            <h3>Touca Cirúrgica Hospitalar Azul Claro com Amarração</h3>
                            <h4 class="text-success">R$: 59,99</h4>
                            <p>
                            <ul>
                                <li>Cor: Azul Claro</li>
                                <li>Ajuste: Fechamento e ajuste por tiras de amarração na parte traseira.</li>
                                <li>Formato: Modelagem anatômica que cobre totalmente os cabelos, seguindo as normas de biossegurança.</li>
                                <li>Indicação: Ideal para uso em Centros Cirúrgicos.</li>
                                <li>Tecido: 100% Algodão.</li>
                            </ul>
                            </p>
                            <form>
                                <div class="mb-3">
                                    <label for="tamanho3" class="form-label">Tamanhos Disponíveis:</label>
                                    <select class="form-select" id="tamanho3" required>
                                        <option value="">Escolha...</option>
                                        <option value="P">P</option>
                                        <option value="M">M</option>
                                        <option value="G">G</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-prod6" tabindex="-1" aria-labelledby="modal-prod6-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="./assets/image/produtos/mascara-protetora-facial.jpg" class="img-fluid" alt="Protetor Facial Face Shield">
                        </div>
                        <div class="col-md-7">
                            <h3>Protetor Facial Face Shield</h3>
                            <h4 class="text-success">R$: 19,99</h4>
                            <p>
                            <ul>
                                <li>Função: Equipamento de Proteção Individual (EPI).</li>
                                <li>Suporte: Tira de apoio na testa.</li>
                                <li>Ajuste: Fita elástica para ajuste universal.</li>
                                <li>Indicação: Ideal para uso em Centros Cirúrgicos.</li>
                                <li>Material: Policarbonato Transparente.</li>
                            </ul>
                            </p>
                            <form>
                                <div class="mb-3">
                                    <label for="quantidade4" class="form-label">Quantidades:</label>
                                    <input type="number" class="form-control" id="quantidade4" value="1" min="1" required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-prod7" tabindex="-1" aria-labelledby="modal-prod7-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="assets/image/produtos/camisola-paciente-hospitalar.jpg" class="img-fluid" alt="Avental Hospitalar Descartável">
                        </div>
                        <div class="col-md-7">
                            <h3>Avental Hospitalar</h3>
                            <h4 class="text-success">R$: 49,99</h4>
                            <p>
                            <ul>
                                <li>Cor: Azul Claro</li>
                                <li>Modelo: Manga curta, comprimento até os joelhos.</li>
                                <li>Indicação: Ideal para uso por pacientes durante exames, procedimentos ou internação.</li>
                                <li>Fechamento: Abertura total nas costas com tiras de amarração ajustáveis.</li>
                                <li>Material: Oxford.</li>
                            </ul>
                            </p>
                            <form>
                                <div class="mb-3">
                                    <label for="tamanho7" class="form-label">Selecione o Tamanho:</label>
                                    <select class="form-select" id="tamanho7" required>
                                        <option value="">Escolha...</option>
                                        <option value="P">P</option>
                                        <option value="M">M</option>
                                        <option value="G">G</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-prod8" tabindex="-1" aria-labelledby="modal-prod8-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="assets/image/produtos/calcado-hospitalar.jpg" class="img-fluid" alt="Camisola de Paciente">
                        </div>
                        <div class="col-md-7">
                            <h3>Sapato Hospitalar Branco Antiderrapante EPI</h3>
                            <h4 class="text-success">R$ 79,99</h4>
                            <p>
                            <ul>
                                <li>Cor: Branco</li>
                                <li>Modelo: Slip On.</li>
                                <li>Indicação: Ideal para profissionais de Saúde.</li>
                                <li>Material: EVA.</li>
                            </ul>
                            </p>
                            <form>
                                <div class="mb-3">
                                    <label for="tamanho8" class="form-label">Tamanho Disponíveis:</label>
                                    <select class="form-select" id="tamanho8" required>
                                        <option value="">Escolha...</option>
                                        <option value="P">P (36 - 38)</option>
                                        <option value="M">M (39 - 41)</option>
                                        <option value="G">G (42 - 44)</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-prod9" tabindex="-1" aria-labelledby="modal-prod9-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="assets/image/produtos/avental-cirurgico.jpg" class="img-fluid" alt="Avental Cirurgico Azul Descartável">
                        </div>
                        <div class="col-md-7">
                            <h3>Avental Cirurgico Descartável</h3>
                            <h4 class="text-success">R$: 29,99</h4>
                            <p>
                            <ul>
                                <li>Cor: Azul.</li>
                                <li>Função: Equipamento de Proteção Individual (EPI).</li>
                                <li>Modelo: Manga Longa, Comprimento padrão.</li>
                                <li>Indicação: Centro Cirúrgico, UTIs, Procedimentos Invasivos e Ambientes de Alto Risco.</li>
                                <li>Material: TNT.</li>
                            </ul>
                            </p>
                            <form>
                                <div class="mb-3">
                                    <label for="quantidade9" class="form-label">Quantidade:</label>
                                    <input type="number" class="form-control" id="quantidade9" value="1" min="1" required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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