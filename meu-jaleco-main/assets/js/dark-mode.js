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

    // Função principal: Alterna entre 'dark' e 'light'
    function alternarTema() {
        const temaAtual = root.getAttribute("data-bs-theme") || "light";
        const novoTema = temaAtual === "dark" ? "light" : "dark";

        // Atualiza atributo no <html> (root) para que Bootstrap e as rules CSS usem o tema
        root.setAttribute("data-bs-theme", novoTema);
        localStorage.setItem("tema", novoTema);
        atualizarIcones(novoTema);
    }

    // Função para atualizar os ícones dos botões (Sol/Lua)
    function atualizarIcones(tema) {
        const isDark = tema === "dark";
        // Altera entre o ícone do Sol (dark) e o da Lua (light)
        const novaClasse = isDark ? "bi bi-sun-fill" : "bi bi-moon-fill";

        if (iconeDesktop) iconeDesktop.className = novaClasse;
        if (iconeMobile) iconeMobile.className = novaClasse;
    }
});