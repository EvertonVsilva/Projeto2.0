function validarSenha(inputs, aplicarErro, removerErro) {
    const senha = inputs.senha.value.trim();
    const confirma = inputs.confirmaSenha.value.trim();
    const len = 8;
    let valido = true;

    if (!senha) {
        aplicarErro(inputs.senha, "A Senha é obrigatória.");
        valido = false;
    } else if (senha.length !== len) {
        aplicarErro(inputs.senha, `A Senha deve ter exatamente ${len} caracteres.`);
        valido = false;
    } else if (!/^[a-zA-Z]+$/.test(senha)) {
        aplicarErro(inputs.senha, "A Senha deve conter apenas letras.");
        valido = false;
    } else {
        removerErro(inputs.senha);
    }

    if (!confirma) {
        aplicarErro(inputs.confirmaSenha, "A confirmação de senha é obrigatória.");
        valido = false;
    } else if (confirma !== senha) {
        aplicarErro(inputs.confirmaSenha, "As senhas não coincidem.");
        valido = false;
    } else {
        removerErro(inputs.confirmaSenha);
    }

    return valido;
}
