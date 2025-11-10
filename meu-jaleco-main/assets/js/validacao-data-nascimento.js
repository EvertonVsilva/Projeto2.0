function validarDataNascimento(inputElement, aplicarErro, removerErro) {
    const data = inputElement.value.trim();

    // Regra 1: Obrigatório
    if (data === "") {
        aplicarErro(inputElement, "A Data de Nascimento é obrigatória.");
        return false;
    }

    // Regra 2: Formato DD/MM/AAAA
    const regexData = /^(\d{2})\/(\d{2})\/(\d{4})$/;
    const match = data.match(regexData);

    if (!match) {
        aplicarErro(inputElement, "Data inválida. Use o formato DD/MM/AAAA.");
        return false;
    }

    const dia = parseInt(match[1], 10);
    const mes = parseInt(match[2], 10);
    const ano = parseInt(match[3], 10);

    const dataObj = new Date(ano, mes - 1, dia);

    // Regra 3a: Validação da Data (verifica se é uma data real, ex: 30/02)
    if (dataObj.getFullYear() !== ano || dataObj.getMonth() !== mes - 1 || dataObj.getDate() !== dia) {
        aplicarErro(inputElement, "Data inválida (Ex: 30 de fevereiro não existe).");
        return false;
    }

    // Regra 3b: Data não pode ser futura
    const hoje = new Date();
    hoje.setHours(0, 0, 0, 0);
    dataObj.setHours(0, 0, 0, 0);

    if (dataObj > hoje) {
        aplicarErro(inputElement, "A data de nascimento não pode ser uma data futura.");
        return false;
    }

    removerErro(inputElement);
    return true;
}