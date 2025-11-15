/**
 * Orquestrador Central de Validações do Formulário de Cadastro
 * 
 * Este arquivo coordena todas as validações individuais e gerencia o envio do formulário.
 * 
 * Arquitetura:
 * - Cada tipo de campo tem seu próprio arquivo de validação (validacao-cpf.js, validacao-email.js, etc.)
 * - Este arquivo importa as funções globais e coordena a validação final no submit
 * 
 * Funções Globais Expostas:
 * - window.aplicarErro(): Adiciona classe 'is-invalid' e exibe mensagem de erro
 * - window.removerErro(): Remove erro e adiciona classe 'is-valid'
 * 
 * Processo de Validação no Submit:
 * 1. Valida campos obrigatórios (required)
 * 2. Valida regras específicas de cada campo
 * 3. Se tudo válido: permite envio
 * 4. Se houver erros: previne envio e foca no primeiro campo inválido
 * 
 * UX:
 * - Feedback visual com classes Bootstrap (is-valid, is-invalid)
 * - Scroll automático para o primeiro erro
 * - Mensagens específicas para cada tipo de validação
 */
document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const form = document.getElementById('form_cadastro');
    if (!form) return;

    /**
     * Aplica feedback visual de erro em um campo
     * 
     * @param {HTMLInputElement} inputElement - Campo do formulário
     * @param {string} mensagem - Mensagem de erro a exibir
     * @returns {boolean} false (para facilitar uso em condicionais)
     * 
     * Classes Bootstrap usadas:
     * - is-invalid: Borda vermelha e estilo de erro
     * - invalid-feedback: Container da mensagem de erro
     */
    window.aplicarErro = (inputElement, mensagem) => {
        inputElement.classList.remove('is-valid');
        inputElement.classList.add('is-invalid');

        const feedback = inputElement.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.textContent = mensagem;
        }
        return false;
    };

    /**
     * Remove feedback de erro e aplica feedback de sucesso
     * 
     * @param {HTMLInputElement} inputElement - Campo do formulário
     * @returns {boolean} true (para facilitar uso em condicionais)
     * 
     * Classes Bootstrap usadas:
     * - is-valid: Borda verde e estilo de sucesso
     */
    window.removerErro = (inputElement) => {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        return true;
    };

    // Mapeamento de campos do formulário
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

    /**
     * Validação básica de campo obrigatório
     * 
     * @param {HTMLInputElement} campo - Campo a validar
     * @param {string} mensagem - Mensagem customizada (opcional)
     * @returns {boolean} true se válido, false se inválido
     */
    function validarCampoObrigatorio(campo, mensagem) {
        if (!campo.value.trim()) {
            return aplicarErro(campo, mensagem || 'Este campo é obrigatório');
        }
        return removerErro(campo);
    }

    /**
     * Validação Completa do Formulário
     * 
     * Executa todas as validações antes de permitir o envio:
     * 1. Campos obrigatórios (via atributo required)
     * 2. Login: exatamente 6 caracteres
     * 3. Senha: exatamente 8 caracteres
     * 4. Confirmação de senha: deve ser igual à senha
     * 5. Estado: exatamente 2 caracteres (sigla UF)
     * 
     * Nota: As validações específicas (CPF, email, telefones, etc.) são
     * executadas pelos respectivos arquivos individuais via listeners blur.
     * 
     * @returns {boolean} true se todos os campos forem válidos
     */
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

    /**
     * Event Listener do Submit
     * 
     * Previne envio do formulário se houver erros de validação.
     * Se houver erro, faz scroll automático até o primeiro campo inválido
     * para facilitar a correção pelo usuário.
     */
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
