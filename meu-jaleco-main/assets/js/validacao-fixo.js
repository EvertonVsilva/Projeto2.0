function validarFixo(inputElement, aplicarErro, removerErro) {
    // Remove tudo que não for dígito para validação
    const fixo = inputElement.value.replace(/\D/g, '');

    // Consulta se o campo está vazio
    if (fixo === "") {
        aplicarErro(inputElement, "O Telefone Fixo é obrigatório.");
        return false;
    }

    // Regra: Deve ter exatamente 10 dígitos (DDD + XXXX-XXXX)
    if (fixo.length !== 10) {
        aplicarErro(inputElement, "Telefone Fixo inválido. Deve ter exatamente 10 dígitos (DDD + XXXX-XXXX).");
        return false;
    }

    // Se as regras forem cumpridas
    removerErro(inputElement);
    return true;
}