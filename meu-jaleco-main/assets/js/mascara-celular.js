//MASCARA PARA CELULAR NO FORMULÁRIO (XX) 9XXXX-XXXX

document.addEventListener('DOMContentLoaded', function () {
    const inputCelular = document.getElementById('campo_telefone_celular');

    if (inputCelular) {
        inputCelular.addEventListener('input', function (e) {
            let value = e.target.value;
            // Remove tudo que não for dígito
            value = value.replace(/\D/g, '');

            // Limita o tamanho para 11 dígitos (DDD + 9xxxx-xxxx)
            value = value.substring(0, 11);

            // Aplica a máscara: (XX) XXXXX-XXXX
            let mascara = '';
            if (value.length > 0) {
                mascara = '(' + value.substring(0, 2); // (XX
            }
            if (value.length > 2) {
                mascara += ') '; // (XX) 

                // Aplica o formato 5-4, que é o padrão de 11 dígitos (9XXXX-XXXX)
                if (value.length > 7) {
                    // (XX) XXXXX-XXXX
                    mascara += value.substring(2, 7) + '-' + value.substring(7);
                } else {
                    mascara += value.substring(2);
                }
            }

            e.target.value = mascara;
        });
    }
});