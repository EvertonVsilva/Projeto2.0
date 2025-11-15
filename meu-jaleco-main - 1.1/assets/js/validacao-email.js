function validarEmail(inputElement, aplicarErro, removerErro) {
    const email = inputElement.value.trim();

    // Regra 1: Obrigatório
    if (email === "") {
        aplicarErro(inputElement, "O E-mail é obrigatório.");
        return false;
    }

    // Regra 2: Formato de e-mail válido (Regex simples e comum)
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!regexEmail.test(email)) {
        aplicarErro(inputElement, "E-mail inválido. Utilize o formato: nome@dominio.com.");
        return false;
    }

    // Se as regras foram atendidas
    removerErro(inputElement);
    return true;
}