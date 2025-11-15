<?php
// CSRF simples: gerar e verificar tokens na sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function generate_csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token(?string $token): bool {
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    // Token válido por 2 horas
    $max_age = 60 * 60 * 2;
    if (isset($_SESSION['csrf_token_time']) && (time() - $_SESSION['csrf_token_time']) > $max_age) {
        unset($_SESSION['csrf_token']);
        unset($_SESSION['csrf_token_time']);
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

function csrf_input_field(): string {
    $t = generate_csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($t) . '">';
}

?>
