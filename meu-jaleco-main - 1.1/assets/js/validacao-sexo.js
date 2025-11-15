function validarSexo(inputElement, aplicarErro, removerErro) {
    // O valor vazio ("") é o que corresponde à opção "Selecione..." no seu <select>

    // Consulta se o campo está vazio
    if (inputElement.value === "") {
        aplicarErro(inputElement, "O campo Sexo é obrigatório.");
        return false;
    }

    // Se a opção foi selecionada
    removerErro(inputElement);
    return true;
}