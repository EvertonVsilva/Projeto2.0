document.addEventListener("DOMContentLoaded", () => {
    const root = document.documentElement;
    const botaoDiminuirDesktop = document.getElementById("botao-diminuir-fonte");
    const botaoAumentarDesktop = document.getElementById("botao-aumentar-fonte");
    const botaoDiminuirMobile = document.getElementById("botao-diminuir-fonte-mobile");
    const botaoAumentarMobile = document.getElementById("botao-aumentar-fonte-mobile");

    // Tamanhos de fonte disponíveis (em porcentagem)
    const tamanhosFonte = [85, 90, 95, 100, 105, 110, 115, 120];
    const tamanhoDefault = 100;
    
    // Inicializa o tamanho da fonte do localStorage ou usa o padrão
    let tamanhoAtual = parseInt(localStorage.getItem("tamanho-fonte")) || tamanhoDefault;
    aplicarTamanhoFonte(tamanhoAtual);

    // Adiciona listeners aos botões desktop
    if (botaoDiminuirDesktop) botaoDiminuirDesktop.addEventListener("click", diminuirFonte);
    if (botaoAumentarDesktop) botaoAumentarDesktop.addEventListener("click", aumentarFonte);
    
    // Adiciona listeners aos botões mobile
    if (botaoDiminuirMobile) botaoDiminuirMobile.addEventListener("click", diminuirFonte);
    if (botaoAumentarMobile) botaoAumentarMobile.addEventListener("click", aumentarFonte);

    function diminuirFonte() {
        const indiceAtual = tamanhosFonte.indexOf(tamanhoAtual);
        if (indiceAtual > 0) {
            tamanhoAtual = tamanhosFonte[indiceAtual - 1];
            aplicarTamanhoFonte(tamanhoAtual);
        }
    }

    function aumentarFonte() {
        const indiceAtual = tamanhosFonte.indexOf(tamanhoAtual);
        if (indiceAtual < tamanhosFonte.length - 1) {
            tamanhoAtual = tamanhosFonte[indiceAtual + 1];
            aplicarTamanhoFonte(tamanhoAtual);
        }
    }

    function aplicarTamanhoFonte(tamanho) {
        root.style.fontSize = tamanho + "%";
        localStorage.setItem("tamanho-fonte", tamanho);
        tamanhoAtual = tamanho;
    }
});
