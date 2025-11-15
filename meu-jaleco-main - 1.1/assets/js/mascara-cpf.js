//MASCARA PARA CPF NO FORMULÁRIO

document.addEventListener('DOMContentLoaded', function () {
    const inputCpf = document.getElementById('campo_cpf');

    if (inputCpf) {
        inputCpf.addEventListener('input', function (e) {
            let value = e.target.value;
            // Remove tudo que não for dígito
            value = value.replace(/\D/g, '');

            // Limita o tamanho para 11 dígitos (máscara 999.999.999-99)
            value = value.substring(0, 11);

            // Adiciona pontos e traço
            if (value.length > 3) {
                value = value.substring(0, 3) + '.' + value.substring(3);
            }
            if (value.length > 7) {
                value = value.substring(0, 7) + '.' + value.substring(7);
            }
            if (value.length > 11) {
                value = value.substring(0, 11) + '-' + value.substring(11);
            }

            e.target.value = value;
        });
    }
});