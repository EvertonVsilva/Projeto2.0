/**
 * Sistema de Controle de Tamanho de Fonte para Acessibilidade
 * 
 * Permite que usuários ajustem o tamanho do texto da página para melhor legibilidade.
 * 
 * Níveis Disponíveis: 8 tamanhos diferentes
 * - 85%, 90%, 95%, 100% (padrão), 105%, 110%, 115%, 120%
 * 
 * Funcionamento:
 * 1. Carrega o tamanho salvo do localStorage (ou usa 100% como padrão)
 * 2. Aplica o tamanho no elemento <html> via propriedade fontSize
 * 3. Botões de +/- navegam pelo array de tamanhos
 * 4. Limites: não ultrapassa o menor (85%) nem o maior (120%)
 * 
 * Persistência:
 * - Preferência salva no localStorage
 * - Mantém o tamanho escolhido entre sessões
 * 
 * Impacto:
 * - Afeta TODO o conteúdo da página (herança CSS)
 * - Mantém proporções originais (usa porcentagem)
 * - Responsivo: funciona em conjunto com media queries
 */
document.addEventListener("DOMContentLoaded", () => {
    const root = document.documentElement;
    const botaoDiminuirDesktop = document.getElementById("botao-diminuir-fonte");
    const botaoAumentarDesktop = document.getElementById("botao-aumentar-fonte");
    const botaoDiminuirMobile = document.getElementById("botao-diminuir-fonte-mobile");
    const botaoAumentarMobile = document.getElementById("botao-aumentar-fonte-mobile");

    // Tamanhos de fonte disponíveis (em porcentagem)
    // Array com 8 níveis de 85% a 120%
    const tamanhosFonte = [85, 90, 95, 100, 105, 110, 115, 120];
    const tamanhoDefault = 100; // Tamanho padrão (index 3 no array)
    
    // Inicializa o tamanho da fonte do localStorage ou usa o padrão
    let tamanhoAtual = parseInt(localStorage.getItem("tamanho-fonte")) || tamanhoDefault;
    aplicarTamanhoFonte(tamanhoAtual);

    // Adiciona listeners aos botões desktop
    if (botaoDiminuirDesktop) botaoDiminuirDesktop.addEventListener("click", diminuirFonte);
    if (botaoAumentarDesktop) botaoAumentarDesktop.addEventListener("click", aumentarFonte);
    
    // Adiciona listeners aos botões mobile
    if (botaoDiminuirMobile) botaoDiminuirMobile.addEventListener("click", diminuirFonte);
    if (botaoAumentarMobile) botaoAumentarMobile.addEventListener("click", aumentarFonte);

    /**
     * Diminui o tamanho da fonte (se não estiver no mínimo)
     * 
     * Lógica:
     * 1. Encontra a posição atual no array
     * 2. Se não for o primeiro elemento (index > 0), volta um nível
     * 3. Aplica o novo tamanho
     */
    function diminuirFonte() {
        const indiceAtual = tamanhosFonte.indexOf(tamanhoAtual);
        if (indiceAtual > 0) {
            tamanhoAtual = tamanhosFonte[indiceAtual - 1];
            aplicarTamanhoFonte(tamanhoAtual);
        }
    }

    /**
     * Aumenta o tamanho da fonte (se não estiver no máximo)
     * 
     * Lógica:
     * 1. Encontra a posição atual no array
     * 2. Se não for o último elemento, avança um nível
     * 3. Aplica o novo tamanho
     */
    function aumentarFonte() {
        const indiceAtual = tamanhosFonte.indexOf(tamanhoAtual);
        if (indiceAtual < tamanhosFonte.length - 1) {
            tamanhoAtual = tamanhosFonte[indiceAtual + 1];
            aplicarTamanhoFonte(tamanhoAtual);
        }
    }

    /**
     * Aplica o tamanho de fonte no elemento raiz e salva a preferência
     * 
     * @param {number} tamanho - Valor em porcentagem (85 a 120)
     * 
     * Processo:
     * 1. Altera a propriedade fontSize do <html>
     * 2. Salva no localStorage
     * 3. Atualiza a variável global tamanhoAtual
     * 
     * CSS Resultante: html { font-size: 85%; } (exemplo)
     */
    function aplicarTamanhoFonte(tamanho) {
        root.style.fontSize = tamanho + "%";
        localStorage.setItem("tamanho-fonte", tamanho);
        tamanhoAtual = tamanho;
    }
});
