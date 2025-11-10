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
    <link rel="stylesheet" href="assets/css/cadastro.css">
</head>

<body>
    <?php
    include './assets/includes/header.php';
    ?>

    <div class="container">
        <h2 class="mb-4 text-center">Cadastro de Usuário</h2>

        <?php if (isset($_SESSION['erro_cadastro'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                echo htmlspecialchars($_SESSION['erro_cadastro']); 
                unset($_SESSION['erro_cadastro']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form
            class="row g-3 needs-validation"
            id="form_cadastro"
            method="POST"
            action="cadastro_usuario_submit.php">

            <h5 class="mt-4 border-bottom pb-2">Dados Pessoais</h5>

            <div class="col-md-6">
                <label for="campo_nome_completo" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="campo_nome_completo" name="nome_completo" maxlength="60" required>
                <div id="feedback_nome" class="invalid-feedback">
                    O nome deve ter no mínimo 8 e no máximo 60 caracteres e conter apenas letras.
                </div>
            </div>

            <div class="col-md-3">
                <label for="campo_data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="text" class="form-control" id="campo_data_nascimento" name="data_nascimento" placeholder="DD/MM/AAAA" maxlength="10" required>
                <div id="feedback_data_nascimento" class="invalid-feedback">
                    A Data de Nascimento é obrigatória no formato DD/MM/AAAA.
                </div>
            </div>

            <div class="col-md-3">
                <label for="campo_sexo" class="form-label">Sexo</label>
                <select class="form-select" id="campo_sexo" name="sexo" required>
                    <option value="">Selecione...</option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                    <option value="O">Outro</option>
                </select>
                <div id="feedback_sexo" class="invalid-feedback">
                    O campo Sexo é obrigatório.
                </div>
            </div>

            <div class="col-md-6">
                <label for="campo_nome_materno" class="form-label">Nome Materno</label>
                <input type="text" class="form-control" id="campo_nome_materno" name="nome_materno" required>
                <div id="feedback_nome_materno" class="invalid-feedback">
                    O Nome Materno é obrigatório.
                </div>
            </div>

            <div class="col-md-6">
                <label for="campo_cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="campo_cpf" name="cpf" required placeholder="999.999.999-99" maxlength="14">
                <div id="feedback_cpf" class="invalid-feedback">
                    O CPF é obrigatório e deve ser válido.
                </div>
            </div>

            <h5 class="mt-4 border-bottom pb-2">Contato</h5>

            <div class="col-md-4">
                <label for="campo_email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="campo_email" name="email" required>
                <div id="feedback_email" class="invalid-feedback">
                    O E-mail é obrigatório e deve ser um endereço válido.
                </div>
            </div>

            <div class="col-md-4">
                <label for="campo_telefone_celular" class="form-label">Telefone Celular</label>
                <input type="tel" class="form-control" id="campo_telefone_celular" name="telefone_celular" placeholder="(XX) 9XXXX-XXXX" required maxlength="15">
                <div class="invalid-feedback" id="feedback_celular">
                    O Celular é obrigatório e deve ter 11 dígitos numéricos no formato (XX) 9XXXX-XXXX.
                </div>
            </div>

            <div class="col-md-4">
                <label for="campo_telefone_fixo" class="form-label">Telefone Fixo</label>
                <input type="tel" class="form-control" id="campo_telefone_fixo" name="telefone_fixo" placeholder="(XX) XXXX-XXXX" required maxlength="14">
                <div class="invalid-feedback" id="feedback_fixo">
                    O Fixo é obrigatório e deve ter 10 dígitos numéricos no formato (XX) XXXX-XXXX.
                </div>
            </div>

            <h5 class="mt-4 border-bottom pb-2">Endereço Completo</h5>

            <div class="col-md-3">
                <label for="campo_cep" class="form-label">CEP</label>
                <input type="text" class="form-control" id="campo_cep" name="cep" required placeholder="XXXXX-XXX" maxlength="9">
                <div id="feedback_cep" class="invalid-feedback">
                    O CEP é obrigatório e deve ter 8 dígitos para buscar o endereço.
                </div>
            </div>

            <div class="col-md-9">
                <label for="campo_logradouro" class="form-label">Logradouro</label>
                <input type="text" class="form-control" id="campo_logradouro" name="logradouro" required>
                <div id="feedback_campo_logradouro" class="invalid-feedback">
                    O Logradouro é obrigatório.
                </div>
            </div>

            <div class="col-md-3">
                <label for="campo_numero" class="form-label">Número</label>
                <input type="text" class="form-control" id="campo_numero" name="numero" required>
                <div id="feedback_campo_numero" class="invalid-feedback">
                    O Número é obrigatório.
                </div>
            </div>

            <div class="col-md-5">
                <label for="campo_complemento" class="form-label">Complemento</label>
                <input type="text" class="form-control" id="campo_complemento" name="complemento">
            </div>

            <div class="col-md-4">
                <label for="campo_bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="campo_bairro" name="bairro" required>
                <div id="feedback_campo_bairro" class="invalid-feedback">
                    O Bairro é obrigatório.
                </div>
            </div>

            <div class="col-md-5">
                <label for="campo_cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="campo_cidade" name="cidade" required>
                <div id="feedback_campo_cidade" class="invalid-feedback">
                    A Cidade é obrigatória.
                </div>
            </div>

            <div class="col-md-4">
                <label for="campo_estado" class="form-label">Estado</label>
                <input type="text" class="form-control" id="campo_estado" name="estado" required maxlength="2">
                <div id="feedback_campo_estado" class="invalid-feedback">
                    O Estado é obrigatório.
                </div>
            </div>

            <h5 class="mt-4 border-bottom pb-2">Login de Acesso</h5>

            <div class="col-md-4">
                <label for="campo_login" class="form-label">Login</label>
                <input type="text" class="form-control" id="campo_login" name="login" required maxlength="6">
                <div id="feedback_login" class="invalid-feedback">
                    O Login é obrigatório e deve ter **exatamente 6 caracteres alfabéticos**.
                </div>
            </div>

            <div class="col-md-4">
                <label for="campo_senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="campo_senha" name="senha" required maxlength="8">
                <div id="feedback_senha" class="invalid-feedback">
                    A Senha é obrigatória e deve ter **exatamente 8 caracteres alfabéticos**.
                </div>
            </div>

            <div class="col-md-4">
                <label for="campo_confirma_senha" class="form-label">Confirmar Senha</label>
                <input type="password" class="form-control" id="campo_confirma_senha" required>
                <div class="invalid-feedback" id="feedback_confirma_senha">
                    A confirmação de senha é obrigatória e deve ser igual à Senha principal.
                </div>
            </div>

            <div class="col-12 mt-4 d-flex justify-content-between">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-person-fill-add"></i> Cadastrar Usuário
                </button>
                <button class="btn btn-secondary" type="reset">
                    <i class="bi bi-x-circle"></i> Limpar Tela
                </button>
            </div>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- MASCARAS DOS CAMPOS DO FORMULÁRIO -->
    <script src="./assets/js/mascara-data-nascimento.js"></script>
    <script src="./assets/js/mascara-cpf.js"></script>
    <script src="./assets/js/mascara-celular.js"></script>
    <script src="./assets/js/mascara-fixo.js"></script>

    <!-- VALIDAÇÕES DOS CAMPOS DO FORMULÁRIO -->
    <script src="./assets/js/validacao-nome-completo.js"></script>
    <script src="./assets/js/validacao-data-nascimento.js"></script>
    <script src="./assets/js/validacao-sexo.js"></script>
    <script src="./assets/js/validacao-nome-materno.js"></script>
    <script src="./assets/js/validacao-cpf.js"></script>
    <script src="./assets/js/validacao-email.js"></script>
    <script src="./assets/js/validacao-celular.js"></script>
    <script src="./assets/js/validacao-fixo.js"></script>
    <script src="./assets/js/validacao-cep.js"></script>
    <script src="./assets/js/validacao-login.js"></script>
    <script src="./assets/js/validacao-senha.js"></script>

    <!-- SCRIPT PRINCIPAL DE VALIDAÇÃO DO FORMULÁRIO -->
    <script src="./assets/js/validacao-formulario.js"></script>

    <!-- DARK MODE SCRIPT -->
    <script src="assets/js/dark-mode.js"></script>
</body>

</html>