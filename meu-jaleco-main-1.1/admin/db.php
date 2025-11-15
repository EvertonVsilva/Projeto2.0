<?php
// Arquivo de conexão com o banco de dados
// Ajuste as credenciais abaixo conforme o seu ambiente (XAMPP padrão geralmente usa user 'root' e senha vazia)
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'meu_jaleco'; // Altere para o nome do seu banco

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    // Não exibir credenciais em produção
    die("Falha ao conectar ao banco de dados: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

// Forçar uso de UTF-8
$mysqli->set_charset('utf8mb4');

return $mysqli;

?>
