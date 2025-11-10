function validarLogin(input, aplicarErro, removerErro) {
    const valor = input.value.trim();

    if (!valor) {
        aplicarErro(input, "O Login é obrigatório.");
        return false;
    }

    if (valor.length !== 6) {
        aplicarErro(input, "O Login deve ter exatamente 6 caracteres.");
        return false;
    }

    if (!/^[a-zA-Z]+$/.test(valor)) {
        aplicarErro(input, "O Login deve conter apenas letras.");
        return false;
    }

    removerErro(input);
    return true;
}
