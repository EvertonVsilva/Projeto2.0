function validarNome(inputElement, aplicarErro, removerErro) {
    const nome = inputElement.value.trim();
    const minLength = 8;
    const maxLength = 60;

    // Consulta se o campo está vazio
    if (nome === "") {
        aplicarErro(inputElement, "Nome Completo é obrigatório.");
        return false;
    }

    // Consulta tamanho minimo e máximo do nome
    if (nome.length < minLength || nome.length > maxLength) {
        aplicarErro(inputElement, `O nome deve ter entre ${minLength} e ${maxLength} caracteres.`);
        return false;
    }

    // Consulta se contém apenas letras e espaços
    if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(nome)) {
        aplicarErro(inputElement, "O nome deve conter apenas caracteres alfabéticos (letras e espaços).");
        return false;
    }

    // Se todas as regras foram atendidas
    removerErro(inputElement);
    return true;
}