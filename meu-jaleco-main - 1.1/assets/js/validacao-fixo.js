function validarFixo(inputElement, aplicarErro, removerErro) {
    // Remove tudo que não for dígito para validação
    const fixo = inputElement.value.replace(/\D/g, '');

    // Consulta se o campo está vazio
    if (fixo === "") {
        aplicarErro(inputElement, "O Telefone Fixo é obrigatório.");
        return false;
    }

    // Regra: Deve ter exatamente 12 dígitos (55 + DDD + XXXX-XXXX) no formato (+55)XX-XXXXXXXX
    if (fixo.length !== 12) {
        aplicarErro(inputElement, "Telefone Fixo inválido. Deve ter o formato (+55)XX-XXXXXXXX com 12 dígitos.");
        return false;
    }

    // Verifica se começa com 55 (código do Brasil)
    if (!fixo.startsWith('55')) {
        aplicarErro(inputElement, "Telefone Fixo inválido. Deve começar com o código do Brasil (+55).");
        return false;
    }

    // Se as regras forem cumpridas
    removerErro(inputElement);
    return true;
}