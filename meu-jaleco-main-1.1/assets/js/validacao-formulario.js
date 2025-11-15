document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const form = document.getElementById('form_cadastro');
    if (!form) return;

    // Feedback visual
    window.aplicarErro = (inputElement, mensagem) => {
        inputElement.classList.remove('is-valid');
        inputElement.classList.add('is-invalid');

        const feedback = inputElement.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.textContent = mensagem;
        }
        return false;
    };

    window.removerErro = (inputElement) => {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        return true;
    };

    // Mapeamento de campos
    const campos = {
        nome: document.getElementById('campo_nome_completo'),
        dataNascimento: document.getElementById('campo_data_nascimento'),
        sexo: document.getElementById('campo_sexo'),
        nomeMaterno: document.getElementById('campo_nome_materno'),
        cpf: document.getElementById('campo_cpf'),
        email: document.getElementById('campo_email'),
        celular: document.getElementById('campo_telefone_celular'),
        fixo: document.getElementById('campo_telefone_fixo'),
        cep: document.getElementById('campo_cep'),
        logradouro: document.getElementById('campo_logradouro'),
        numero: document.getElementById('campo_numero'),
        complemento: document.getElementById('campo_complemento'),
        bairro: document.getElementById('campo_bairro'),
        cidade: document.getElementById('campo_cidade'),
        estado: document.getElementById('campo_estado'),
        login: document.getElementById('campo_login'),
        senha: document.getElementById('campo_senha'),
        confirmaSenha: document.getElementById('campo_confirma_senha'),
    };

    // Validação básica de campo vazio
    function validarCampoObrigatorio(campo, mensagem) {
        if (!campo.value.trim()) {
            return aplicarErro(campo, mensagem || 'Este campo é obrigatório');
        }
        return removerErro(campo);
    }

    // Validação geral
    function validarTodosCampos() {
        let valido = true;

        // Validar todos os campos obrigatórios
        Object.entries(campos).forEach(([key, campo]) => {
            if (campo && campo.hasAttribute('required')) {
                if (!validarCampoObrigatorio(campo)) {
                    valido = false;
                }
            }
        });

        // Validações específicas
        if (campos.login && campos.login.value.length !== 6) {
            aplicarErro(campos.login, 'O login deve ter exatamente 6 caracteres');
            valido = false;
        }

        if (campos.senha && campos.senha.value.length !== 8) {
            aplicarErro(campos.senha, 'A senha deve ter exatamente 8 caracteres');
            valido = false;
        }

        if (campos.senha && campos.confirmaSenha && 
            campos.senha.value !== campos.confirmaSenha.value) {
            aplicarErro(campos.confirmaSenha, 'As senhas não conferem');
            valido = false;
        }

        if (campos.estado && campos.estado.value.length !== 2) {
            aplicarErro(campos.estado, 'Digite a sigla do estado com 2 letras');
            valido = false;
        }

        return valido;
    }

    // Controle de envio
    form.addEventListener('submit', (event) => {
        if (!validarTodosCampos()) {
            event.preventDefault();
            event.stopPropagation();
            
            // Scroll até o primeiro campo com erro
            const primeiroErro = form.querySelector('.is-invalid');
            if (primeiroErro) {
                primeiroErro.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});
