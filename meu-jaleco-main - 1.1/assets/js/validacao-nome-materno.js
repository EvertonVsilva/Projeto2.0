function validarNomeMaterno(inputElement, aplicarErro, removerErro) {
    const nomeMaterno = inputElement.value.trim();

    // Consulta se o campo está vazio
    if (nomeMaterno === "") {
        aplicarErro(inputElement, "O Nome Materno é obrigatório.");
        return false;
    }

    // Se a regra foi atendida
    removerErro(inputElement);
    return true;
}