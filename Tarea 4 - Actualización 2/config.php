<?php
declare(strict_types=1);
/**
 * Configuración de base de datos — editar según tu entorno.
 */
$DB_HOST = '127.0.0.1';
$DB_NAME = 'servicios_asociados';
$DB_USER = 'root';
$DB_PASS = '';

$DSN = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4";

date_default_timezone_set('America/Argentina/Buenos_Aires');

/* * --- NUEVA GESTIÓN DE URLs (Punto 1) --- 
 * Define aquí las rutas. Si alguna se deja vacía '', el sistema pondrá '#' automáticamente.
 */
$CONF_URLS = [
    'home'      => 'index.html',
    'productos' => 'productos.html',
    'servicios' => 'servicios.php',
    'quienes'   => 'quienes-somos.html',
    'contacto'  => 'contacto.html'
];

// --- CONFIGURACIÓN reCAPTCHA DESDE ARCHIVO .ENV (Punto 5) ---
// Se espera un archivo .env en la raíz del proyecto con, al menos:
// RECAPTCHA_SITE_KEY="tu_clave_de_sitio"
// RECAPTCHA_SECRET_KEY="tu_clave_secreta"
$ENV = [];
$envFile = __DIR__ . '/.env';
if (is_readable($envFile)) {
    $parsed = parse_ini_file($envFile, false, INI_SCANNER_TYPED);
    if (is_array($parsed)) {
        $ENV = $parsed;
    }
}
$RECAPTCHA_SITE_KEY   = $ENV['RECAPTCHA_SITE_KEY']   ?? '';
$RECAPTCHA_SECRET_KEY = $ENV['RECAPTCHA_SECRET_KEY'] ?? '';


// Función auxiliar para obtener el link o '#' si está vacío
function getLink($key) {
    global $CONF_URLS;
    return !empty($CONF_URLS[$key]) ? $CONF_URLS[$key] : '#';
}
?>