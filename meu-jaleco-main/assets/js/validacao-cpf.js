function validarCPF(inputElement, aplicarErro, removerErro) {
    // Remove pontuação e traços para obter apenas os 11 dígitos
    const cpf = inputElement.value.replace(/[^\d]/g, '');

    // Regra 1: Obrigatório e 11 dígitos
    if (cpf.length !== 11) {
        aplicarErro(inputElement, "O CPF é obrigatório e deve ter 11 dígitos.");
        return false;
    }

    // Evita CPFs inválidos conhecidos (ex: 111.111.111-11)
    if (/^(\d)\1{10}$/.test(cpf)) {
        aplicarErro(inputElement, "CPF inválido. Sequências de dígitos repetidos não são permitidas.");
        return false;
    }

    let sum = 0;
    let rem;

    // 1. Validação do Primeiro Dígito Verificador (DV1)
    for (let i = 1; i <= 9; i++) {
        sum += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }
    rem = (sum * 10) % 11;

    if ((rem === 10) || (rem === 11)) rem = 0;
    if (rem !== parseInt(cpf.substring(9, 10))) {
        aplicarErro(inputElement, "CPF inválido. Dígito verificador incorreto.");
        return false;
    }

    sum = 0;

    // 2. Validação do Segundo Dígito Verificador (DV2)
    for (let i = 1; i <= 10; i++) {
        sum += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }
    rem = (sum * 10) % 11;

    if ((rem === 10) || (rem === 11)) rem = 0;
    if (rem !== parseInt(cpf.substring(10, 11))) {
        aplicarErro(inputElement, "CPF inválido. Dígito verificador incorreto.");
        return false;
    }

    // Se as regras de DV forem cumpridas
    removerErro(inputElement);
    return true;
}