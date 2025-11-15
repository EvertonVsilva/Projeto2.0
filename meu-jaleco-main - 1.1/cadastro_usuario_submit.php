<?php
session_start();

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastro.php');
    exit;
}

// Validação dos campos obrigatórios
$campos_obrigatorios = [
    'nome_completo' => 'Nome Completo',
    'data_nascimento' => 'Data de Nascimento',
    'sexo' => 'Sexo',
    'nome_materno' => 'Nome Materno',
    'cpf' => 'CPF',
    'email' => 'E-mail',
    'telefone_celular' => 'Telefone Celular',
    'telefone_fixo' => 'Telefone Fixo',
    'cep' => 'CEP',
    'logradouro' => 'Logradouro',
    'numero' => 'Número',
    'bairro' => 'Bairro',
    'cidade' => 'Cidade',
    'estado' => 'Estado',
    'login' => 'Login',
    'senha' => 'Senha'
];

$erros = [];
foreach ($campos_obrigatorios as $campo => $nome) {
    if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
        $erros[] = $nome;
    }
}

if (!empty($erros)) {
    $_SESSION['erro_cadastro'] = "Os seguintes campos são obrigatórios: " . implode(", ", $erros);
    header('Location: cadastro.php');
    exit;
}

// Validações específicas
if (strlen($_POST['login']) !== 6) {
    $_SESSION['erro_cadastro'] = "O login deve ter exatamente 6 caracteres.";
    header('Location: cadastro.php');
    exit;
}

if (strlen($_POST['senha']) !== 8) {
    $_SESSION['erro_cadastro'] = "A senha deve ter exatamente 8 caracteres.";
    header('Location: cadastro.php');
    exit;
}

if (strlen($_POST['estado']) !== 2) {
    $_SESSION['erro_cadastro'] = "O estado deve ter exatamente 2 caracteres.";
    header('Location: cadastro.php');
    exit;
}

// Validação do CPF (removendo pontos e traços)
$cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);
if (strlen($cpf) !== 11) {
    $_SESSION['erro_cadastro'] = "CPF inválido. Digite um CPF válido com 11 dígitos.";
    header('Location: cadastro.php');
    exit;
}

// Verificar se todos os campos obrigatórios estão presentes
$campos_obrigatorios = [
    'logradouro', 'numero', 'bairro', 'cidade', 'estado', 'cep',
    'nome_completo', 'data_nascimento', 'sexo', 'nome_materno', 'cpf',
    'email', 'telefone_celular', 'telefone_fixo', 'login', 'senha'
];

$campos_faltando = [];
foreach ($campos_obrigatorios as $campo) {
    if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
        $campos_faltando[] = $campo;
    }
}

if (!empty($campos_faltando)) {
    $_SESSION['erro_cadastro'] = "Campos obrigatórios não preenchidos: " . implode(", ", $campos_faltando);
    header('Location: cadastro.php');
    exit;
}

$mysqli = require __DIR__ . '/admin/db.php';

try {
    // Formata e valida os dados do endereço
    $logradouro = trim($_POST['logradouro'] ?? '');
    $numero = trim($_POST['numero'] ?? '');
    $complemento = isset($_POST['complemento']) ? trim($_POST['complemento']) : null;
    $bairro = trim($_POST['bairro'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $estado = strtoupper(trim($_POST['estado'] ?? ''));
    $cep = preg_replace('/[^0-9-]/', '', $_POST['cep'] ?? '');

    // Formata os dados do usuário
    $nome_completo = substr(trim($_POST['nome_completo']), 0, 60);
    $nome_materno = substr(trim($_POST['nome_materno']), 0, 60);
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);
    $email = substr(trim($_POST['email']), 0, 100);
    $login = substr(trim($_POST['login']), 0, 6);
    
    // Formata telefones para o padrão (+55)XX-XXXXXXXX
    $celular = preg_replace('/[^0-9]/', '', $_POST['telefone_celular']);
    $celular = "(+55)" . substr($celular, 0, 2) . "-" . substr($celular, 2);
    
    $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone_fixo']);
    $telefone = "(+55)" . substr($telefone, 0, 2) . "-" . substr($telefone, 2);
    
    // Converte data do formato brasileiro (DD/MM/YYYY) para MySQL (YYYY-MM-DD)
    $data_array = explode('/', $_POST['data_nascimento']);
    $data_mysql = $data_array[2] . '-' . $data_array[1] . '-' . $data_array[0];

    // Criptografa a senha usando bcrypt (via PASSWORD_DEFAULT)
    $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    
    // ID do perfil padrão (2 = Comum)
    $id_perfil = 2;

    /**
     * Inicia Transação MySQL
     * 
     * Usamos transação para garantir integridade referencial.
     * Se qualquer INSERT falhar, todos são revertidos (rollback).
     * 
     * Ordem de Inserção:
     * 1. Endereço (para obter id_endereco)
     * 2. Usuário (usando id_endereco como FK)
     * 3. Log (usando id_usuario como FK)
     */
    $mysqli->begin_transaction();

    // 1. Primeiro insere o endereço
    $stmt = $mysqli->prepare("INSERT INTO endereco (logradouro, numero, complemento, bairro, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Erro ao preparar inserção de endereço");
    }

    $stmt->bind_param("sssssss", 
        $logradouro,
        $numero,
        $complemento,
        $bairro,
        $cidade,
        $estado,
        $cep
    );
    
    if (!$stmt->execute()) {
        throw new Exception("Erro ao inserir endereço");
    }
    
    // Captura o ID do endereço recém-inserido
    $id_endereco = $mysqli->insert_id;
    $stmt->close();

    // 2. Depois insere o usuário (com referência ao endereço)
    $stmt = $mysqli->prepare("INSERT INTO usuario (id_perfil, id_endereco, nome_completo, data_nascimento, sexo, nome_materno, cpf, email, celular, telefone, login, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Erro ao preparar inserção de usuário");
    }

    // Formata endereço
    $logradouro = substr(trim($_POST['logradouro']), 0, 100);
    $numero = substr(trim($_POST['numero']), 0, 10);
    $complemento = isset($_POST['complemento']) ? substr(trim($_POST['complemento']), 0, 50) : null;
    $bairro = substr(trim($_POST['bairro']), 0, 50);
    $cidade = substr(trim($_POST['cidade']), 0, 50);
    $estado = strtoupper(substr(trim($_POST['estado']), 0, 2));
    $cep = substr(preg_replace('/[^0-9-]/', '', $_POST['cep']), 0, 9);

    $stmt->bind_param("iissssssssss", 
        $id_perfil,
        $id_endereco,
        $nome_completo,
        $data_mysql,
        $_POST['sexo'],
        $nome_materno,
        $cpf,
        $email,
        $celular,
        $telefone,
        $login,
        $senha_hash
    );
    
    if (!$stmt->execute()) {
        throw new Exception("Erro ao inserir usuário");
    }
    
    // Captura o ID do usuário recém-inserido
    $id_usuario = $mysqli->insert_id;
    $stmt->close();

    // 3. Registra o log de cadastro
    $stmt = $mysqli->prepare("INSERT INTO log (id_usuario, data_hora, status_autenticacao) VALUES (?, NOW(), ?)");
    if (!$stmt) {
        throw new Exception("Erro ao preparar inserção de log");
    }

    $status = "CADASTRO_OK";  // Status de cadastro bem-sucedido
    $stmt->bind_param("is", $id_usuario, $status);
    
    if (!$stmt->execute()) {
        throw new Exception("Erro ao inserir log");
    }
    
    $stmt->close();

    // Commit da transação (confirma todas as inserções)
    $mysqli->commit();

    // Redireciona para o login com mensagem de sucesso
    $_SESSION['mensagem_sucesso'] = "Cadastro realizado com sucesso! Faça login para continuar.";
    header('Location: login.php');
    exit;

} catch (Exception $e) {
    /**
     * Tratamento de Erros com Rollback
     * 
     * Se qualquer etapa falhar, desfaz todas as inserções para manter
     * a integridade do banco (evita registros órfãos).
     */
    // Rollback em caso de erro
    $mysqli->rollback();
    
    $erro = $e->getMessage();
    
    // Traduz erros do MySQL para mensagens amigáveis
    if (strpos($erro, "Duplicate entry") !== false) {
        if (strpos($erro, "cpf") !== false) {
            $erro = "CPF já cadastrado no sistema.";
        } elseif (strpos($erro, "email") !== false) {
            $erro = "Email já cadastrado no sistema.";
        } elseif (strpos($erro, "login") !== false) {
            $erro = "Login já está em uso. Por favor, escolha outro.";
        } elseif (strpos($erro, "uk_endereco") !== false) {
            $erro = "Erro interno: Endereço já vinculado a outro usuário.";
        }
    } elseif (strpos($erro, "Data too long") !== false) {
        // Encontrar o nome do campo na mensagem de erro
        preg_match("/column '([^']+)'/i", $erro, $matches);
        $campo_erro = $matches[1] ?? '';
        
        $limites = [
            'login' => '6 caracteres',
            'celular' => '20 caracteres no formato (+55)XX-XXXXXXXXX',
            'telefone' => '20 caracteres no formato (+55)XX-XXXXXXXX',
            'nome_completo' => '60 caracteres',
            'nome_materno' => '60 caracteres',
            'cpf' => '11 números',
            'email' => '100 caracteres',
            'logradouro' => '100 caracteres',
            'numero' => '10 caracteres',
            'complemento' => '50 caracteres',
            'bairro' => '50 caracteres',
            'cidade' => '50 caracteres',
            'estado' => '2 caracteres',
            'cep' => '9 caracteres'
        ];

        if (isset($limites[$campo_erro])) {
            $erro = "O campo " . ucfirst(str_replace('_', ' ', $campo_erro)) . 
                   " não pode exceder " . $limites[$campo_erro] . ".";
        } else {
            $erro = "O campo " . ucfirst(str_replace('_', ' ', $campo_erro)) . 
                   " excede o tamanho máximo permitido.";
        }
    } elseif (strpos($erro, "Cannot add or update a child row") !== false) {
        $erro = "Erro de integridade do banco de dados. Verifique se todos os campos estão preenchidos corretamente.";
    }
    
    $_SESSION['erro_cadastro'] = "Erro ao realizar cadastro: " . $erro;
    header('Location: cadastro.php');
    exit;
}
?>