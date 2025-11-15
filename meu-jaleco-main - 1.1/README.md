# 🩺 Meu Jaleco - Sistema de Gerenciamento de Usuários

> Sistema web completo de cadastro e gerenciamento de usuários desenvolvido com PHP, MySQL, Bootstrap e JavaScript.

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.3-7952B3?style=flat-square&logo=bootstrap)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=flat-square&logo=javascript)

---

## 📋 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Funcionalidades](#funcionalidades)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Estrutura do Banco de Dados](#estrutura-do-banco-de-dados)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Recursos de Segurança](#recursos-de-segurança)
- [Recursos de Acessibilidade](#recursos-de-acessibilidade)
- [Capturas de Tela](#capturas-de-tela)
- [Credenciais Padrão](#credenciais-padrão)
- [Autor](#autor)

---

## 🎯 Sobre o Projeto

**Meu Jaleco** é um sistema web completo de gerenciamento de usuários com recursos avançados de segurança, validação e interface moderna. O projeto foi desenvolvido como trabalho acadêmico, implementando boas práticas de desenvolvimento web e segurança da informação.

### Diferenciais:
- ✅ Interface moderna e responsiva com dark mode
- ✅ Sistema de autenticação com 3 níveis de acesso
- ✅ Validações robustas no frontend e backend
- ✅ Proteção contra SQL Injection, XSS e CSRF
- ✅ Recursos de acessibilidade (ajuste de fonte)
- ✅ Sistema completo de logs de auditoria
- ✅ Exportação de dados em PDF

---

## ⚡ Funcionalidades

### 👤 Área Pública
- **Cadastro de Usuários** com validações em tempo real
- **Login Seguro** com criptografia de senha
- **Validação de CPF** com algoritmo de dígito verificador
- **Integração com API ViaCEP** para preenchimento automático de endereço
- **Dark Mode** com persistência de preferência
- **Controle de Acessibilidade** (tamanho de fonte ajustável)

### 🔐 Área do Usuário
- **Perfil Completo** com todas as informações cadastradas
- **Alteração de Senha** segura com validações
- **Dropdown de Perfil** com opções de navegação rápida

### 👨‍💼 Painel Admin
- **Gerenciamento de Usuários** (listar, editar, excluir)
- **Sistema de Logs** com 8 tipos de eventos rastreados
- **Inserção de Usuários Teste** para desenvolvimento
- **Exportação de Lista de Usuários em PDF**
- **Proteção CSRF** em todas as ações administrativas

### 🎛️ Dashboard Master
- **Estatísticas Gerais** do sistema
- **Usuários por Perfil** com contagem
- **Últimos Logs** de atividades
- **Visão Geral** do sistema

---

## 🛠️ Tecnologias Utilizadas

### Backend
- **PHP 7.4+** - Linguagem server-side
- **MySQL 8.0+** - Banco de dados relacional
- **MySQLi** - Interface de banco de dados com prepared statements

### Frontend
- **HTML5** - Estrutura semântica
- **CSS3** - Estilização customizada
- **Bootstrap 5.3.3** - Framework CSS responsivo
- **JavaScript ES6+** - Interatividade e validações
- **Bootstrap Icons** - Biblioteca de ícones

### Segurança
- **Password Hashing** (bcrypt via `password_hash()`)
- **Prepared Statements** (proteção contra SQL Injection)
- **CSRF Tokens** (proteção contra Cross-Site Request Forgery)
- **htmlspecialchars()** (proteção contra XSS)
- **Session Security** (controle de autenticação)

### APIs & Integrações
- **ViaCEP API** - Busca automática de endereço por CEP

---

## 📦 Requisitos

### Software Necessário
- **XAMPP** (ou similar com PHP + MySQL)
  - PHP 7.4 ou superior
  - MySQL 8.0 ou superior
  - Apache 2.4
- **Navegador Web Moderno** (Chrome, Firefox, Edge, Safari)

### Extensões PHP Requeridas
- `mysqli` - Conexão com MySQL
- `json` - Manipulação de JSON
- `session` - Gerenciamento de sessões

---

## 🚀 Instalação

### Passo 1: Clonar o Repositório
```bash
cd c:\xampp\htdocs
git clone [URL-DO-SEU-REPOSITORIO] meu-jaleco-main
```

### Passo 2: Configurar o Banco de Dados
1. Abra o **phpMyAdmin** (http://localhost/phpmyadmin)
2. Importe o arquivo `meu_jaleco.sql`
3. O banco será criado automaticamente com:
   - Tabelas: `usuario`, `perfil`, `endereco`, `log`
   - Usuário Master padrão (veja credenciais abaixo)

### Passo 3: Configurar Conexão (Opcional)
Se precisar alterar as credenciais do banco, edite o arquivo:
```php
// admin/db.php
$DB_HOST = '127.0.0.1';  // Host do MySQL
$DB_USER = 'root';       // Usuário do MySQL
$DB_PASS = '';           // Senha do MySQL (vazia no XAMPP)
$DB_NAME = 'meu_jaleco'; // Nome do banco
```

### Passo 4: Iniciar o Servidor
1. Abra o **XAMPP Control Panel**
2. Inicie os módulos:
   - ✅ Apache
   - ✅ MySQL

### Passo 5: Acessar o Sistema
Abra seu navegador e acesse:
```
http://localhost/meu-jaleco-main/
```

---

## 🗄️ Estrutura do Banco de Dados

### Tabela: `usuario`
Armazena os dados dos usuários cadastrados.
```sql
- id (INT, PK, AUTO_INCREMENT)
- id_perfil (INT, FK → perfil.id)
- id_endereco (INT, FK → endereco.id)
- nome_completo (VARCHAR 60)
- data_nascimento (DATE)
- sexo (CHAR 1)
- nome_materno (VARCHAR 60)
- cpf (CHAR 11, UNIQUE)
- email (VARCHAR 100, UNIQUE)
- celular (CHAR 20)
- telefone (CHAR 20)
- login (CHAR 6, UNIQUE)
- senha (VARCHAR 255, HASHED)
```

### Tabela: `perfil`
Define os níveis de acesso ao sistema.
```sql
- id (INT, PK, AUTO_INCREMENT)
- nome_perfil (VARCHAR 20, UNIQUE)

Perfis disponíveis:
1 = Master (acesso total)
2 = Comum (acesso limitado)
```

### Tabela: `endereco`
Armazena endereços dos usuários.
```sql
- id (INT, PK, AUTO_INCREMENT)
- logradouro (VARCHAR 100)
- numero (VARCHAR 10)
- complemento (VARCHAR 50, NULLABLE)
- bairro (VARCHAR 50)
- cidade (VARCHAR 50)
- estado (CHAR 2)
- cep (CHAR 9)
```

### Tabela: `log`
Registra todas as ações importantes do sistema.
```sql
- id (INT, PK, AUTO_INCREMENT)
- id_usuario (INT, FK → usuario.id)
- data_hora (DATETIME)
- status_autenticacao (VARCHAR 20)

Tipos de Log:
- LOGIN_OK
- LOGOUT
- CADASTRO_OK
- SENHA_ALTERADA
- USUARIO_EDITADO
- USUARIO_TESTE_CRIADO
- USUARIO_DELETADO
- LOG_DELETADO
```

### Diagrama ER
```
┌─────────┐       ┌──────────┐
│ perfil  │──1:N──│ usuario  │
└─────────┘       └──────────┘
                       │
                       │ 1:1
                       │
                  ┌──────────┐
                  │ endereco │
                  └──────────┘
                       
┌─────────┐       ┌──────────┐
│   log   │──N:1──│ usuario  │
└─────────┘       └──────────┘
```

---

## 📁 Estrutura do Projeto

```
meu-jaleco-main/
│
├── admin/                      # Área administrativa
│   ├── actions.php            # Processamento de ações admin (CRUD)
│   ├── csrf.php               # Geração e validação de tokens CSRF
│   ├── dashboard-master.php   # Dashboard com estatísticas
│   ├── db.php                 # Conexão com banco de dados
│   ├── editar_usuario.php     # Formulário de edição de usuários
│   ├── exportar_usuarios_pdf.php  # Geração de PDF com lista
│   ├── logs-administracao.php # Visualização detalhada de logs
│   └── painel.php             # Painel principal de gerenciamento
│
├── assets/                     # Recursos estáticos
│   ├── css/                   # Folhas de estilo
│   │   ├── cadastro.css       # Estilos da página de cadastro
│   │   ├── index.css          # Estilos da página inicial
│   │   ├── login.css          # Estilos da página de login
│   │   ├── sobre.css          # Estilos da página sobre
│   │   ├── styles.css         # Estilos globais e dark mode
│   │   └── telaadmin.css      # Estilos da área admin
│   │
│   ├── icon/                  # Ícones do sistema
│   │   └── logo.png           # Logo principal
│   │
│   ├── image/                 # Imagens
│   │   └── produtos/          # Imagens de produtos
│   │
│   ├── includes/              # Componentes reutilizáveis
│   │   ├── footer.php         # Rodapé padrão
│   │   └── header.php         # Cabeçalho com navegação
│   │
│   └── js/                    # Scripts JavaScript
│       ├── acessibilidade-fonte.js     # Controle tamanho fonte
│       ├── dark-mode.js                # Alternância dark/light mode
│       ├── mascara-celular.js          # Máscara telefone celular
│       ├── mascara-cpf.js              # Máscara CPF
│       ├── mascara-data-nascimento.js  # Máscara data
│       ├── mascara-fixo.js             # Máscara telefone fixo
│       ├── validacao-celular.js        # Validação celular
│       ├── validacao-cep.js            # Validação e busca CEP
│       ├── validacao-cpf.js            # Validação CPF
│       ├── validacao-data-nascimento.js # Validação data
│       ├── validacao-email.js          # Validação email
│       ├── validacao-fixo.js           # Validação fixo
│       ├── validacao-formulario.js     # Orquestrador validações
│       ├── validacao-nome-completo.js  # Validação nome
│       ├── validacao-nome-materno.js   # Validação nome materno
│       ├── validacao-senha.js          # Validação senha
│       └── validacao-sexo.js           # Validação sexo
│
├── alterar_senha.php          # Processamento de troca de senha
├── cadastro.php               # Formulário de cadastro
├── cadastro_usuario_submit.php # Processamento do cadastro
├── catalogo.php               # Catálogo de produtos
├── index.php                  # Página inicial
├── login.php                  # Página de login
├── logout.php                 # Processamento de logout
├── perfil.php                 # Perfil do usuário
├── sobre.php                  # Página sobre nós
├── validacao-login.php        # Processamento de login
│
├── meu_jaleco.sql             # Script SQL do banco
├── DER.png                    # Diagrama Entidade-Relacionamento
└── README.md                  # Este arquivo
```

---

## 🔒 Recursos de Segurança

### 1. Autenticação e Autorização
- ✅ **Sistema de Sessões** com verificações em todas as páginas protegidas
- ✅ **3 Níveis de Acesso**: Master, Admin e Comum
- ✅ **Redirecionamento Inteligente** baseado no perfil do usuário

### 2. Proteção de Dados
- ✅ **Prepared Statements**: Todas as queries usam `mysqli->prepare()`
- ✅ **Password Hashing**: Senhas criptografadas com `password_hash()` (bcrypt)
- ✅ **Sanitização de Saída**: `htmlspecialchars()` em todas as exibições
- ✅ **Validação Dupla**: Frontend (JavaScript) + Backend (PHP)

### 3. Proteção contra Ataques
- ✅ **SQL Injection**: Prepared statements em 100% das queries
- ✅ **XSS (Cross-Site Scripting)**: Escape de HTML em outputs
- ✅ **CSRF (Cross-Site Request Forgery)**: Tokens em formulários admin
- ✅ **Clickjacking**: Estrutura preparada para headers de segurança

### 4. Validações Implementadas
- ✅ **CPF**: Validação de dígito verificador
- ✅ **E-mail**: Regex de validação
- ✅ **Telefones**: Formato (+55)XX-XXXXXXXX
- ✅ **Senha**: 8 caracteres alfanuméricos
- ✅ **Login**: Exatamente 6 caracteres
- ✅ **CEP**: 8 dígitos com busca automática

### 5. Auditoria
- ✅ **Sistema de Logs**: 8 tipos de eventos registrados
- ✅ **Rastreamento de Ações**: Todas ações críticas são logadas
- ✅ **Histórico**: Data, hora, usuário e tipo de ação

---

## ♿ Recursos de Acessibilidade

### Controle de Fonte
- **Botões +/-** no header para ajustar tamanho
- **8 níveis**: 85%, 90%, 95%, 100%, 105%, 110%, 115%, 120%
- **Persistência**: Preferência salva no localStorage

### Dark Mode
- **Alternância**: Botão de lua/sol no header
- **Transições Suaves**: Efeito visual ao alternar
- **Persistência**: Preferência salva no localStorage
- **Cobertura Total**: Todos os elementos estilizados

### Interface Responsiva
- **Mobile First**: Design otimizado para dispositivos móveis
- **Bootstrap Grid**: Layout adaptativo
- **Navegação Mobile**: Menu hambúrguer com todos recursos

---

## 📸 Capturas de Tela

### Página Inicial
Interface moderna com informações sobre o sistema.

### Cadastro de Usuário
Formulário completo com validações em tempo real e integração com ViaCEP.

### Login
Tela de autenticação simples e intuitiva.

### Perfil do Usuário
Visualização completa dos dados cadastrados com opção de alterar senha.

### Painel Admin
Gerenciamento de usuários com tabelas, ações e sistema de logs.

### Dark Mode
Todos os elementos com tema escuro profissional.

---

## 🔑 Credenciais Padrão

### Usuário Master (Acesso Total)
```
Login: admin
Senha: adminadm
E-mail: admin@faculdade.com.br
```

### Usuários de Teste
Para criar usuários de teste rapidamente, use o botão "Inserir Usuário Teste" no painel admin.

**Credenciais dos usuários teste:**
```
Login: user01, user02, user03...
Senha: teste123
```

---

## 📚 Regras de Validação

### Cadastro de Usuário
1. ✅ **Nome**: 8-60 caracteres alfabéticos
2. ✅ **CPF**: Validação de dígito verificador
3. ✅ **E-mail**: Formato válido
4. ✅ **Celular**: Formato (+55)XX-XXXXXXXX (12 dígitos)
5. ✅ **Fixo**: Formato (+55)XX-XXXXXXXX (12 dígitos)
6. ✅ **CEP**: 8 dígitos com busca automática
7. ✅ **Login**: Exatamente 6 caracteres
8. ✅ **Senha**: 8 caracteres alfanuméricos
9. ✅ **Confirmação**: Senha e confirmação devem ser iguais

---

## 🚧 Melhorias Futuras

- [ ] Implementar variáveis de ambiente (.env)
- [ ] Adicionar paginação nas tabelas admin
- [ ] Sistema de recuperação de senha via e-mail
- [ ] Upload de foto de perfil
- [ ] Filtros e busca avançada de usuários
- [ ] Gráficos no dashboard com Chart.js
- [ ] Exportação para Excel/CSV
- [ ] Sistema de notificações
- [ ] API RESTful para integração
- [ ] Testes automatizados (PHPUnit)

---

## 👨‍💻 Autor

Desenvolvido como projeto acadêmico.

### Tecnologias e Conceitos Aplicados:
- Desenvolvimento Web Full Stack
- Banco de Dados Relacional
- Segurança da Informação
- UX/UI Design
- Programação Orientada a Eventos
- Versionamento com Git

---

## 📄 Licença

Este projeto foi desenvolvido para fins educacionais.

---

## 🙏 Agradecimentos

- **Bootstrap Team** - Framework CSS
- **ViaCEP** - API de busca de CEP
- **Bootstrap Icons** - Biblioteca de ícones
- **XAMPP Team** - Ambiente de desenvolvimento

---

## 📞 Suporte

Para dúvidas ou problemas:
1. Verifique se o XAMPP está rodando (Apache + MySQL)
2. Certifique-se de que o banco foi importado corretamente
3. Verifique as credenciais em `admin/db.php`
4. Limpe o cache do navegador (Ctrl + F5)

---

**Desenvolvido com ❤️ e ☕**

*Última atualização: Novembro 2025*
