


function validarCelular(inputElement, aplicarErro, removerErro) {
    // Remove tudo que não for dígito para validação
    const celular = inputElement.value.replace(/\D/g, '');

    // Regra 1: Obrigatório
    if (celular === "") {
        aplicarErro(inputElement, "O Telefone Celular é obrigatório.");
        return false;
    }

    // Regra 2: Deve ter exatamente 12 dígitos (55 + DDD + 9xxxx-xxxx) no formato (+55)XX-XXXXXXXX
    if (celular.length !== 12) {
        aplicarErro(inputElement, "Celular inválido. Deve ter o formato (+55)XX-XXXXXXXX com 12 dígitos.");
        return false;
    }

    // Verifica se começa com 55 (código do Brasil)
    if (!celular.startsWith('55')) {
        aplicarErro(inputElement, "Celular inválido. Deve começar com o código do Brasil (+55).");
        return false;
    }

    // Se as regras forem cumpridas
    removerErro(inputElement);
    return true;
}