/**
 * Sistema de Dark Mode com Bootstrap 5.3+
 * 
 * Utiliza o atributo data-bs-theme do Bootstrap para alternar entre modos claro e escuro.
 * 
 * Funcionamento:
 * 1. Verifica o tema salvo no localStorage (ou usa 'light' como padrão)
 * 2. Aplica o tema no elemento <html> via atributo data-bs-theme
 * 3. Atualiza os ícones dos botões (Sol para dark, Lua para light)
 * 4. Ao clicar, alterna o tema e adiciona transição suave temporária
 * 
 * Persistência:
 * - O tema escolhido é salvo no localStorage
 * - Permanece mesmo após fechar o navegador
 * 
 * Transições:
 * - Classe 'theme-transition' é adicionada apenas ao clicar (não ao carregar página)
 * - Removida após 600ms para evitar efeito indesejado em futuras mudanças de página
 */
document.addEventListener("DOMContentLoaded", () => {
    // Use the root <html> element so Bootstrap's data-bs-theme variables apply consistently
    const root = document.documentElement;
    const botaoDesktop = document.getElementById("botao-modo-escuro-desktop");
    const botaoMobile = document.getElementById("botao-modo-escuro-mobile");
    const iconeDesktop = document.getElementById("icone-modo-escuro-desktop");
    const iconeMobile = document.getElementById("icone-modo-escuro-mobile");

    // Inicializa o tema a partir do localStorage ou define como 'light'
    let temaSalvo = localStorage.getItem("tema") || "light";
    localStorage.setItem("tema", temaSalvo);

    // Aplica o tema e atualiza ícones ao carregar (atributo no <html>)
    root.setAttribute("data-bs-theme", temaSalvo);
    atualizarIcones(temaSalvo);

    // Adiciona listeners aos botões
    if (botaoDesktop) botaoDesktop.addEventListener("click", alternarTema);
    if (botaoMobile) botaoMobile.addEventListener("click", alternarTema);

    /**
     * Alterna entre os modos 'dark' e 'light'
     * 
     * Processo:
     * 1. Detecta o tema atual do atributo data-bs-theme
     * 2. Define o novo tema (inverso do atual)
     * 3. Adiciona classe 'theme-transition' para transição suave
     * 4. Atualiza o atributo data-bs-theme no <html>
     * 5. Salva a preferência no localStorage
     * 6. Atualiza os ícones dos botões
     * 7. Remove a classe de transição após 600ms
     */
    function alternarTema() {
        const temaAtual = root.getAttribute("data-bs-theme") || "light";
        const novoTema = temaAtual === "dark" ? "light" : "dark";

        // Adiciona classe de transição temporariamente (apenas no clique, não no load)
        root.classList.add("theme-transition");

        // Atualiza atributo no <html> (root) para que Bootstrap e as rules CSS usem o tema
        root.setAttribute("data-bs-theme", novoTema);
        localStorage.setItem("tema", novoTema);
        atualizarIcones(novoTema);

        // Remove a classe de transição após a animação
        setTimeout(() => {
            root.classList.remove("theme-transition");
        }, 600);
    }

    /**
     * Atualiza os ícones dos botões de acordo com o tema atual
     * 
     * Lógica visual:
     * - Modo dark: Exibe ícone de Sol (bi-sun-fill) - clique para ir para light
     * - Modo light: Exibe ícone de Lua (bi-moon-fill) - clique para ir para dark
     * 
     * @param {string} tema - 'dark' ou 'light'
     */
    function atualizarIcones(tema) {
        const isDark = tema === "dark";
        // Altera entre o ícone do Sol (dark) e o da Lua (light)
        const novaClasse = isDark ? "bi bi-sun-fill" : "bi bi-moon-fill";

        if (iconeDesktop) iconeDesktop.className = novaClasse;
        if (iconeMobile) iconeMobile.className = novaClasse;
    }
});