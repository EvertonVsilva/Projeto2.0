// MÁSCARA PARA DATA DE NASCIMENTO DD/MM/AAAA

document.addEventListener('DOMContentLoaded', function () {
    const inputData = document.getElementById('campo_data_nascimento');

    inputData.addEventListener('input', function (e) {
        let value = e.target.value;
        // Remove tudo que não for dígito
        value = value.replace(/\D/g, '');

        // Adiciona a barra (/) no local correto
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        if (value.length > 5) {
            value = value.substring(0, 5) + '/' + value.substring(5, 9);
        }

        e.target.value = value;
    });
});