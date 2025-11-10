// MASCARA PARA TELEFONE FIXO

document.addEventListener('DOMContentLoaded', function () {
    const inputFixo = document.getElementById('campo_telefone_fixo');

    if (inputFixo) {
        inputFixo.addEventListener('input', function (e) {
            let value = e.target.value;
            // Remove tudo que não for dígito
            value = value.replace(/\D/g, '');

            // Limita o tamanho para 10 dígitos (DDD + XXXX-XXXX)
            value = value.substring(0, 10);

            // Aplica a máscara: (XX) XXXX-XXXX
            let mascara = '';
            if (value.length > 0) {
                mascara = '(' + value.substring(0, 2); // (XX
            }
            if (value.length > 2) {
                mascara += ') '; // (XX) 

                // Aplica o formato 4-4
                if (value.length > 6) {
                    // (XX) XXXX-XXXX
                    mascara += value.substring(2, 6) + '-' + value.substring(6);
                } else {
                    mascara += value.substring(2);
                }
            }

            e.target.value = mascara;
        });
    }
});