/**
 * Valida um CPF brasileiro usando o algoritmo de dígitos verificadores.
 * 
 * O CPF é composto por 11 dígitos: 9 dígitos base + 2 dígitos verificadores (DV1 e DV2).
 * 
 * Algoritmo de Validação:
 * 1. Verifica se tem exatamente 11 dígitos
 * 2. Rejeita sequências repetidas (ex: 111.111.111-11)
 * 3. Calcula o primeiro DV usando multiplicadores de 10 a 2
 * 4. Calcula o segundo DV usando multiplicadores de 11 a 2
 * 
 * Exemplo de cálculo para CPF: 123.456.789-09
 * DV1: (1*10 + 2*9 + 3*8 + 4*7 + 5*6 + 6*5 + 7*4 + 8*3 + 9*2) * 10 % 11 = 0
 * DV2: (1*11 + 2*10 + 3*9 + 4*8 + 5*7 + 6*6 + 7*5 + 8*4 + 9*3 + 0*2) * 10 % 11 = 9
 * 
 * @param {HTMLInputElement} inputElement - Campo de input contendo o CPF
 * @param {Function} aplicarErro - Função para exibir mensagem de erro
 * @param {Function} removerErro - Função para remover mensagem de erro
 * @returns {boolean} true se o CPF for válido, false caso contrário
 */
function validarCPF(inputElement, aplicarErro, removerErro) {
    // Remove pontuação e traços para obter apenas os 11 dígitos
    const cpf = inputElement.value.replace(/[^\d]/g, '');

    // Regra 1: Obrigatório e 11 dígitos
    if (cpf.length !== 11) {
        aplicarErro(inputElement, "O CPF é obrigatório e deve ter 11 dígitos.");
        return false;
    }

    // Evita CPFs inválidos conhecidos (ex: 111.111.111-11)
    // Regex verifica se todos os dígitos são iguais
    if (/^(\d)\1{10}$/.test(cpf)) {
        aplicarErro(inputElement, "CPF inválido. Sequências de dígitos repetidos não são permitidas.");
        return false;
    }

    let sum = 0;
    let rem;

    // 1. Validação do Primeiro Dígito Verificador (DV1)
    // Multiplica cada um dos 9 primeiros dígitos por valores decrescentes de 10 a 2
    // Exemplo: 1*10 + 2*9 + 3*8 + 4*7 + 5*6 + 6*5 + 7*4 + 8*3 + 9*2
    for (let i = 1; i <= 9; i++) {
        sum += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }
    
    // Multiplica a soma por 10 e pega o resto da divisão por 11
    rem = (sum * 10) % 11;

    // Se o resto for 10 ou 11, o DV é 0
    if ((rem === 10) || (rem === 11)) rem = 0;
    
    // Compara o DV calculado com o 10º dígito do CPF
    if (rem !== parseInt(cpf.substring(9, 10))) {
        aplicarErro(inputElement, "CPF inválido. Dígito verificador incorreto.");
        return false;
    }

    sum = 0;

    // 2. Validação do Segundo Dígito Verificador (DV2)
    // Multiplica cada um dos 10 primeiros dígitos (incluindo DV1) por valores decrescentes de 11 a 2
    // Exemplo: 1*11 + 2*10 + 3*9 + 4*8 + 5*7 + 6*6 + 7*5 + 8*4 + 9*3 + 0*2
    for (let i = 1; i <= 10; i++) {
        sum += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }
    
    // Multiplica a soma por 10 e pega o resto da divisão por 11
    rem = (sum * 10) % 11;

    // Se o resto for 10 ou 11, o DV é 0
    if ((rem === 10) || (rem === 11)) rem = 0;
    
    // Compara o DV calculado com o 11º dígito do CPF
    if (rem !== parseInt(cpf.substring(10, 11))) {
        aplicarErro(inputElement, "CPF inválido. Dígito verificador incorreto.");
        return false;
    }

    // Se passou em todas as validações, o CPF é válido
    removerErro(inputElement);
    return true;
}