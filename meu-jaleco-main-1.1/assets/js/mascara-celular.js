//MASCARA PARA CELULAR NO FORMULÁRIO (+55)XX-XXXXXXXX

document.addEventListener('DOMContentLoaded', function () {
    const inputCelular = document.getElementById('campo_telefone_celular');

    if (inputCelular) {
        inputCelular.addEventListener('input', function (e) {
            let value = e.target.value;
            // Remove tudo que não for dígito
            value = value.replace(/\D/g, '');

            // Limita o tamanho para 12 dígitos (55 + DDD + 9xxxx-xxxx)
            value = value.substring(0, 12);

            // Aplica a máscara: (+55)XX-XXXXXXXX
            let mascara = '';
            if (value.length > 0) {
                mascara = '(+55)'; // (+55)
            }
            if (value.length > 2) {
                mascara += value.substring(2, 4); // (+55)XX
            }
            if (value.length > 4) {
                mascara += '-' + value.substring(4); // (+55)XX-XXXXXXXX
            }

            e.target.value = mascara;
        });
    }
});