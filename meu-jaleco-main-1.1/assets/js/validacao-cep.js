// ARQUIVO: assets/js/validacao-cep.js

document.addEventListener('DOMContentLoaded', () => {
    const inputCep = document.getElementById('campo_cep');
    if (!inputCep) return;

    const inputs = {
        cep: inputCep,
        logradouro: document.getElementById('campo_logradouro'),
        bairro: document.getElementById('campo_bairro'),
        cidade: document.getElementById('campo_cidade'),
        estado: document.getElementById('campo_estado'),
        numero: document.getElementById('campo_numero')
    };

    // Máscara de CEP
    inputCep.addEventListener('input', e => {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 5) value = value.slice(0, 5) + '-' + value.slice(5, 8);
        e.target.value = value;
    });

    // Consulta automática ao sair do campo
    let ultimoCep = "";
    inputCep.addEventListener('blur', e => {
        const cep = e.target.value.replace(/\D/g, '');
        if (cep.length === 8 && cep !== ultimoCep) {
            ultimoCep = cep;
            consultarViaCep(cep);
        } else if (cep.length > 0 && cep.length !== 8) {
            window.aplicarErro?.(inputCep, "O CEP deve ter 8 dígitos numéricos.");
        }
    });

    // Consulta ao ViaCEP
    window.consultarViaCep = async function (cep) {
        const aplicarErro = window.aplicarErro;
        const removerErro = window.removerErro;
        if (!aplicarErro || !removerErro) return;

        setCamposEndereco("... buscando ...", "", "", "", true);
        toggleValidacao(inputs.cep, false);

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();

            setCamposEndereco("", "", "", "", false);

            if (data.erro) {
                limparCamposEndereco();
                aplicarErro(inputs.cep, "CEP não encontrado. Digite o endereço manualmente.");
                inputs.logradouro.focus();
                return;
            }

            preencherCamposEndereco(data);
            removerErro(inputs.cep);
            inputs.numero.focus();

        } catch {
            setCamposEndereco("", "", "", "", false);
            limparCamposEndereco();
            aplicarErro(inputs.cep, "Falha ao buscar CEP. Tente novamente.");
        }
    };

    function setCamposEndereco(logradouro, bairro, cidade, estado, disabled) {
        inputs.logradouro.value = logradouro;
        inputs.bairro.value = bairro;
        inputs.cidade.value = cidade;
        inputs.estado.value = estado;
        inputs.logradouro.disabled = disabled;
        inputs.bairro.disabled = disabled;
        inputs.cidade.disabled = disabled;
        inputs.estado.disabled = disabled;
    }

    function limparCamposEndereco() {
        setCamposEndereco("", "", "", "", false);
    }

    function preencherCamposEndereco(data) {
        setCamposEndereco(data.logradouro, data.bairro, data.localidade, data.uf, false);
    }

    function toggleValidacao(input, isValid) {
        input.classList.remove('is-valid', 'is-invalid');
        if (isValid) input.classList.add('is-valid');
    }
});

// Validação final do CEP (chamada no submit)
function validarCEP(inputElement, aplicarErro, removerErro) {
    const cep = inputElement.value.replace(/\D/g, '');

    if (!cep) {
        aplicarErro(inputElement, "O CEP é obrigatório.");
        return false;
    }

    if (cep.length !== 8) {
        aplicarErro(inputElement, "O CEP deve ter exatamente 8 dígitos numéricos.");
        return false;
    }

    window.consultarViaCep(cep);
    removerErro(inputElement);
    return true;
}
