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
