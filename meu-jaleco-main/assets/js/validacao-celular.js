

function validarCelular(inputElement, aplicarErro, removerErro) {
    // Remove tudo que não for dígito para validação
    const celular = inputElement.value.replace(/\D/g, '');

    // Regra 1: Obrigatório
    if (celular === "") {
        aplicarErro(inputElement, "O Telefone Celular é obrigatório.");
        return false;
    }

    // Regra 2: Deve ter exatamente 11 dígitos (DDD + 9xxxx-xxxx)
    if (celular.length !== 11) {
        aplicarErro(inputElement, "Celular inválido. Deve ter exatamente 11 dígitos (DDD + 9XXXX-XXXX).");
        return false;
    }

    // Se as regras forem cumpridas
    removerErro(inputElement);
    return true;
}