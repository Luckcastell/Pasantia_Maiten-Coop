<?php
declare(strict_types=1);
require __DIR__ . '/config.php';

function json_out(int $code, array $payload) {
  http_response_code($code);
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  exit;
}

function field(string $name, $default = '') {
  return isset($_POST[$name]) ? trim((string)$_POST[$name]) : $default;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  json_out(405, ['ok' => false, 'errors' => ['Método no permitido (usa POST).']]);
}

// Mantener los name del HTML original:
$nombre_apellido = field('nombre_apellido');
if ($nombre_apellido === '') {
  $nombre_apellido = field('nombre');
}
$email           = field('email');
$telefono        = field('telefono');
$servicio        = field('servicio_interes');
if ($servicio === '') {
  $servicio = field('servicio');
}
$mensaje         = field('mensaje');
$acepto_priv = 0;
if (isset($_POST['acepto_privacidad'])) {
  $acepto_priv = ($_POST['acepto_privacidad'] === 'on' || $_POST['acepto_privacidad'] == '1') ? 1 : 0;
} elseif (isset($_POST['privacidad'])) {
  $acepto_priv = ($_POST['privacidad'] === 'on' || $_POST['privacidad'] == '1') ? 1 : 0;
} elseif (isset($_POST['acepto'])) { // por si algún template lo envía
  $acepto_priv = ($_POST['acepto'] === 'on' || $_POST['acepto'] == '1') ? 1 : 0;
}

// Validaciones básicas
$errors = [];
if ($nombre_apellido === '') $errors[] = 'El nombre y apellido es obligatorio.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
if ($servicio === '') $errors[] = 'El servicio de interés es obligatorio.';
if ($acepto_priv !== 1) $errors[] = 'Debes aceptar la política de privacidad.';

if ($errors) {
  json_out(400, ['ok' => false, 'errors' => $errors]);
}

// Conexión PDO
try {
  $pdo = new PDO($DSN, $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
} catch (Throwable $e) {
  json_out(500, ['ok' => false, 'errors' => ['Error de conexión a la base de datos.'], 'detail' => $e->getMessage()]);
}

// Config uploads
$maxFileSizeBytes = 25 * 1024 * 1024; // 25MB
$allowedExt = ['pdf','jpg','jpeg','png','webp','doc','docx','odt','xls','xlsx'];
$allowedMime = [
  'application/pdf',
  'image/jpeg','image/png','image/webp',
  'application/msword',
  'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
  'application/vnd.ms-excel',
  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
  'application/vnd.oasis.opendocument.text'
];

try {
  $pdo->beginTransaction();

  // Inserción principal en la tabla EXISTENTE consulta (sin tocar su estructura):
  $sql = "INSERT INTO consulta
            (nombre_apellido, email, telefono, servicio_interes, documento, mensaje, acepto_privacidad)
          VALUES
            (:nombre_apellido, :email, :telefono, :servicio_interes, NULL, :mensaje, :acepto_privacidad)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':nombre_apellido'   => $nombre_apellido,
    ':email'             => $email,
    ':telefono'          => $telefono,
    ':servicio_interes'  => $servicio,
    ':mensaje'           => $mensaje,
    ':acepto_privacidad' => $acepto_priv,
  ]);

  $idConsulta = (int)$pdo->lastInsertId();

  // Subida de archivos: preferimos 'documentos' (original). Soportamos 'archivos' o 'adjuntos' como fallback.
  $filesKey = null;
  if (isset($_FILES['documentos'])) $filesKey = 'documentos';
  elseif (isset($_FILES['archivos'])) $filesKey = 'archivos';
  elseif (isset($_FILES['adjuntos'])) $filesKey = 'adjuntos';

  $subidos = 0;
  $erroresArchivos = [];

  if ($filesKey && is_array($_FILES[$filesKey]['name'])) {

    $year = date('Y');
    $month = date('m');

    $baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR;
    if (!is_dir($baseDir)) {
      if (!mkdir($baseDir, 0775, true) && !is_dir($baseDir)) {
        throw new RuntimeException('No se pudo crear el directorio de subida.');
      }
    }

    $finfo = class_exists('finfo') ? new finfo(FILEINFO_MIME_TYPE) : null;

    for ($i = 0; $i < count($_FILES[$filesKey]['name']); $i++) {
      $err = $_FILES[$filesKey]['error'][$i];
      if ($err === UPLOAD_ERR_NO_FILE) continue;
      if ($err !== UPLOAD_ERR_OK) {
        $erroresArchivos[] = "Error al subir el archivo #{$i} (código {$err}).";
        continue;
      }

      $tmpPath   = $_FILES[$filesKey]['tmp_name'][$i];
      $origName  = (string)$_FILES[$filesKey]['name'][$i];
      $sizeBytes = (int)$_FILES[$filesKey]['size'][$i];

      if ($sizeBytes <= 0 || $sizeBytes > $maxFileSizeBytes) {
        $erroresArchivos[] = "El archivo '{$origName}' excede el tamaño permitido (máx. 25MB).";
        continue;
      }

      $ext  = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
      $mime = $finfo ? ($finfo->file($tmpPath) ?: 'application/octet-stream') : mime_content_type($tmpPath);

      if (!in_array($ext, $allowedExt, true)) {
        $erroresArchivos[] = "Extensión no permitida en '{$origName}'.";
        continue;
      }
      if (!in_array($mime, $allowedMime, true)) {
        $erroresArchivos[] = "Tipo MIME no permitido en '{$origName}' ({$mime}).";
        continue;
      }

      $rand = bin2hex(random_bytes(16));
      $safeName = $rand . ($ext ? ".{$ext}" : '');
      $destPath = $baseDir . $safeName;

      $sha256 = hash_file('sha256', $tmpPath);

      if (!move_uploaded_file($tmpPath, $destPath)) {
        $erroresArchivos[] = "No se pudo mover '{$origName}' al destino final.";
        continue;
      }

      $rutaRel = '/uploads/' . $year . '/' . $month . '/' . $safeName;

      try {
        $sqlA = "INSERT INTO consulta_archivo
                    (id_consulta, nombre_original, mime, tamano_bytes, sha256, ruta_storage, created_at)
                 VALUES
                    (:idc, :orig, :mime, :size, :sha, :ruta, NOW())";
        $stmtA = $pdo->prepare($sqlA);
        $stmtA->execute([
          ':idc'  => $idConsulta,
          ':orig' => $origName,
          ':mime' => $mime,
          ':size' => $sizeBytes,
          ':sha'  => $sha256,
          ':ruta' => $rutaRel,
        ]);
      } catch (Throwable $e) {
        $erroresArchivos[] = "Archivo guardado pero no registrado en 'consulta_archivo': " . $e->getMessage();
      }

      $subidos++;
    }
  }

  $pdo->commit();

  json_out(200, [
    'ok' => true,
    'id_consulta' => $idConsulta,
    'archivos_subidos' => $subidos,
    'errores_archivos' => $erroresArchivos
  ]);

} catch (Throwable $e) {
  if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) {
    $pdo->rollBack();
  }
  json_out(500, ['ok' => false, 'errors' => ['No se pudo procesar la consulta.'], 'detail' => $e->getMessage()]);
}
