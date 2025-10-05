<?php
declare(strict_types=1);
require __DIR__ . '/config.php';

$servicio = isset($_GET['servicio']) ? trim((string)$_GET['servicio']) : '';
$q        = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$pagina   = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$porPagina = 20;
$offset    = ($pagina - 1) * $porPagina;

try {
  $pdo = new PDO($DSN, $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
} catch (Throwable $e) {
  http_response_code(500);
  echo "<h1>Error de conexión</h1><pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
  exit;
}

$where = [];
$params = [];

if ($servicio !== '') {
  $where[] = "servicio_interes = :servicio";
  $params[':servicio'] = $servicio;
}
if ($q !== '') {
  $where[] = "(nombre_apellido LIKE :q OR email LIKE :q OR telefono LIKE :q OR mensaje LIKE :q)";
  $params[':q'] = "%" . $q . "%";
}

$whereSql = $where ? ("WHERE " . implode(" AND ", $where)) : "";

$sqlCount = "SELECT COUNT(*) AS c FROM consulta {$whereSql}";
$stmtC = $pdo->prepare($sqlCount);
$stmtC->execute($params);
$total = (int)$stmtC->fetchColumn();
$paginas = (int)ceil($total / $porPagina);

$sql = "SELECT * FROM consulta {$whereSql} ORDER BY fecha_consulta DESC LIMIT :lim OFFSET :off";
$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) $stmt->bindValue($k, $v);
$stmt->bindValue(':lim', $porPagina, PDO::PARAM_INT);
$stmt->bindValue(':off', $offset, PDO::PARAM_INT);
$stmt->execute();
$consultas = $stmt->fetchAll();

$archivosPorConsulta = [];
if ($consultas) {
  $ids = array_column($consultas, 'id_consulta');
  if ($ids) {
    $in = implode(',', array_map('intval', $ids));
    try {
      $stmtA = $pdo->query("SELECT * FROM consulta_archivo WHERE id_consulta IN ($in) ORDER BY created_at DESC");
      foreach ($stmtA as $row) {
        $archivosPorConsulta[$row['id_consulta']][] = $row;
      }
    } catch (Throwable $e) {
      // Ignorar si no existe la tabla
    }
  }
}
?> 
<!doctype html>
<html lang="es">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Servicios de Maitén Cooperativa | Asistencia y Créditos</title>
  <meta name="description" content="Conocé los servicios de Maitén Cooperativa: Asistencia Hogar (plomería, electricidad, cerrajería, vidriería, armado de muebles, asistencia legal, informática y mascotas) y Créditos a jubilados. Beneficios, requisitos, descargas y una landing con formulario para enviar documentos.">
  <meta name="color-scheme" content="light dark">
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    :root{
      --bs-body-font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, "Helvetica Neue", Arial, "Apple Color Emoji","Segoe UI Emoji"; 
      --error: #dc3545;
      --blanco: #ffffff;
      --blanco2: #eef5ff;
      --azul: #122183;
      --azul-oscuro: #0b1760;
      --link: #009855;
      --hover: #0fad78;
      --gris: #2c2c2c;
      --bs-success: var(--link);
      --bs-success-rgb: 0,152,85;
      --bs-body-color: var(--gris);
      --bs-primary: var(--azul);
      --bs-primary-rgb: 18,33,131;
      --bs-link-color: var(--link);
      --bs-link-hover-color: var(--hover);
    }
    body {color: var(--gris);}
    .listado-wrap { padding-top: 3rem; padding-bottom: 4rem; }
    .filtros .form-control, .filtros .form-select { max-width: 100%; }
    .consulta-card { border-radius: 12px; border: 1px solid rgba(255,255,255,.08); background: var(--azul); color: var(--blanco); }
    .consulta-card .meta { font-size: .92rem; opacity: .85; }
    .pill { display:inline-block; padding:.25rem .6rem; border-radius:999px; background:rgba(255,255,255,.1); font-size:.85rem; }
    .adjuntos a { text-decoration: none; }
    .pagination { --bs-pagination-color: inherit; --bs-pagination-bg: transparent; --bs-pagination-border-color: rgba(255,255,255,.15); }
    @media (prefers-reduced-motion: reduce){ .animate{transition:none!important} }
  </style>

  <!-- FAQ Schema (JSON-LD). -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      {"@type":"Question","name":"Plomería: ¿Qué entra como urgencia?","acceptedAnswer":{"@type":"Answer","text":"Fugas o roturas que requieren solución inmediata en instalaciones internas y visibles. No se incluyen trabajos de mejora ni mantenimiento."}},
      {"@type":"Question","name":"Plomería: ¿Repuestos incluidos?","acceptedAnswer":{"@type":"Answer","text":"No. Repuestos (cañerías, griferías, etc.) a cargo del beneficiario; se incluye traslado y mano de obra inicial."}},

      {"@type":"Question","name":"Electricidad: ¿Qué cubre la intervención?","acceptedAnswer":{"@type":"Answer","text":"Reparación de urgencia en instalaciones internas para restablecer el suministro. Sin tendidos nuevos ni obras de envergadura."}},
      {"@type":"Question","name":"Electricidad: ¿Qué límites aplican?","acceptedAnswer":{"@type":"Answer","text":"Límite por evento y hasta 5 eventos anuales compartidos entre rubros, con tope económico por evento."}},

      {"@type":"Question","name":"Cerrajería: ¿Incluye llaves o nuevas cerraduras?","acceptedAnswer":{"@type":"Answer","text":"No. Repuestos y copias de llaves no están incluidos; la intervención se limita a apertura o reparación para restablecer el funcionamiento."}},
      {"@type":"Question","name":"Cerrajería: ¿Siempre envían técnico?","acceptedAnswer":{"@type":"Answer","text":"Si hay otra vía segura de ingreso/egreso se evalúa y puede presupuestarse. Aplica límite por evento y máximo anual."}},

      {"@type":"Question","name":"Vidriería: ¿El vidrio está incluido?","acceptedAnswer":{"@type":"Answer","text":"Sí. Se cubre el cristal, el desplazamiento y la mano de obra para reposición en puertas y ventanas verticales del domicilio registrado."}},
      {"@type":"Question","name":"Vidriería: ¿Qué exclusiones hay?","acceptedAnswer":{"@type":"Answer","text":"Cristales internos, horizontales (p. ej., claraboyas) o especiales/artísticos no están cubiertos."}},

      {"@type":"Question","name":"Armado de muebles: ¿Cómo se coordina?","acceptedAnswer":{"@type":"Answer","text":"Con 72 horas hábiles de anticipación, según disponibilidad del beneficiario y del proveedor."}},
      {"@type":"Question","name":"Armado de muebles: ¿Qué límites aplican?","acceptedAnswer":{"@type":"Answer","text":"Incluye hasta 60 minutos. Excedentes y materiales se coordinan a costo preferencial. Tope por evento y límites anuales compartidos."}},

      {"@type":"Question","name":"Asistencia Legal (Hogar): ¿Qué temas puedo consultar?","acceptedAnswer":{"@type":"Answer","text":"Laboral, civil, familia, mercantil; procesos como robos, denuncias o sucesiones; orientación en contratos y trámites tributarios."}},
      {"@type":"Question","name":"Asistencia Legal (Hogar): ¿Qué no incluye?","acceptedAnswer":{"@type":"Answer","text":"Redacción de documentos, atención presencial y patrocinio judicial son a cargo del beneficiario."}},

      {"@type":"Question","name":"Asistencia Informática (Hogar): ¿La atención es 24/7?","acceptedAnswer":{"@type":"Answer","text":"Sí, soporte telefónico permanente con límites de eventos según el tipo de consulta."}},
      {"@type":"Question","name":"Asistencia Informática (Hogar): ¿Envían técnico a domicilio?","acceptedAnswer":{"@type":"Answer","text":"Sí, se coordina a costo preferencial y a cargo del beneficiario."}},

      {"@type":"Question","name":"Mascotas (Hogar): ¿Qué cubre?","acceptedAnswer":{"@type":"Answer","text":"Chequeos preventivos y urgencias con topes; orientación veterinaria y legal telefónica sin límites."}},
      {"@type":"Question","name":"Mascotas (Hogar): ¿Cuáles son los topes?","acceptedAnswer":{"@type":"Answer","text":"2 chequeos y 2 urgencias al año; urgencias hasta $20.000 por evento."}},

      {"@type":"Question","name":"Créditos: ¿Quiénes pueden solicitarlos?","acceptedAnswer":{"@type":"Answer","text":"Jubilados/as de la Caja de Jubilaciones, Pensiones y Retiros de Córdoba. El cobro se realiza por recibo de haberes, con monto sujeto a evaluación y normativa vigente."}},
      {"@type":"Question","name":"Créditos: ¿Cuáles son las condiciones principales?","acceptedAnswer":{"@type":"Answer","text":"Monto, plazos y tasa se determinan conforme a capacidad de pago y autorización de la entidad previsional. Requiere documentación personal y previsional."}}
    ]
  }
  </script>

</head>
<body>

<main>
  <section class="listado-wrap">
    <div class="container">
      <div class="row mb-4 align-items-end">
        <div class="col-lg-8">
          <h1 class="display-6 fw-semibold">Listado de consultas</h1>
          <p class="text-muted mb-0">Revisá las consultas recibidas desde el formulario de servicios y accedé a sus adjuntos.</p>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
          <a href="listado.php" class="btn btn-primary">Recargar</a>
        </div>
      </div>

      <form class="row g-2 filtros mb-4" method="get" action="">
        <div class="col-md-4">
          <label class="form-label">Servicio</label>
          <select class="form-select" name="servicio">
            <option value="">Todos</option>
            <?php
              $servicios = ['Plomería','Electricidad','Cerrajería','Vidriería','Armado de muebles','Asistencia Legal','Asistencia Informática','Mascotas','Créditos a Jubilados'];
              foreach ($servicios as $_s) {
                $sel = ($servicio === $_s) ? 'selected' : '';
                echo '<option ' . $sel . '>' . htmlspecialchars($_s) . '</option>';
              }
            ?>
          </select>
        </div>
        <div class="col-md-5">
          <label class="form-label">Buscar</label>
          <input type="search" class="form-control" name="q" placeholder="Nombre, email, teléfono o texto del mensaje..." value="<?php echo htmlspecialchars($q); ?>">
        </div>
        <div class="col-md-3 d-grid">
          <label class="form-label">&nbsp;</label>
          <button class="btn btn-primary" type="submit">Filtrar</button>
        </div>
      </form>

      <?php if (!$consultas): ?>
        <div class="alert alert-warning">No hay consultas que coincidan con el filtro.</div>
      <?php endif; ?>

      <div class="row g-3">
        <?php foreach ($consultas as $c): ?>
          <div class="col-12">
            <div class="p-3 consulta-card">
              <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="pe-3">
                  <h5 class="mb-1">#<?php echo (int)$c['id_consulta']; ?> — <?php echo htmlspecialchars($c['nombre_apellido']); ?></h5>
                  <div class="meta">
                    <span class="me-3"><strong>Email:</strong> <?php echo htmlspecialchars($c['email']); ?></span>
                    <?php if (!empty($c['telefono'])): ?>
                      <span class="me-3"><strong>Tel:</strong> <?php echo htmlspecialchars((string)$c['telefono']); ?></span>
                    <?php endif; ?>
                    <span class="pill"><?php echo htmlspecialchars($c['servicio_interes']); ?></span>
                  </div>
                </div>
                <div class="text-muted mt-2 mt-sm-0">
                  <?php echo htmlspecialchars((string)$c['fecha_consulta']); ?>
                </div>
              </div>

              <?php if (!empty($c['mensaje'])): ?>
                <div class="mt-3"><?php echo nl2br(htmlspecialchars($c['mensaje'])); ?></div>
              <?php endif; ?>

              <?php if (!empty($archivosPorConsulta[$c['id_consulta']])): ?>
                <div class="mt-3 adjuntos">
                  <strong>Adjuntos:</strong>
                  <ul class="mb-0 mt-1">
                    <?php foreach ($archivosPorConsulta[$c['id_consulta']] as $a): ?>
                      <li>
                        <a href="<?php echo htmlspecialchars($a['ruta_storage']); ?>" target="_blank">
                          <?php echo htmlspecialchars($a['nombre_original']); ?>
                        </a>
                        <small class="text-muted">[<?php echo htmlspecialchars($a['mime']); ?> — <?php echo (int)$a['tamano_bytes']; ?> bytes]</small>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <?php if ($paginas > 1): ?>
        <nav class="mt-4">
          <ul class="pagination justify-content-center">
            <?php
              function linkPag($p, $servicio, $q) {
                $qs = [];
                if ($servicio !== '') $qs['servicio'] = $servicio;
                if ($q !== '') $qs['q'] = $q;
                $qs['pagina'] = $p;
                return '?' . http_build_query($qs);
              }

              $prevDisabled = ($pagina <= 1) ? 'disabled' : '';
              echo '<li class="page-item ' . $prevDisabled . '"><a class="page-link" href="' . ($pagina>1?linkPag($pagina-1,$servicio,$q):'#') . '">Anterior</a></li>';

              for ($p = 1; $p <= $paginas; $p++) {{
                $active = ($p === $pagina) ? 'active' : '';
                echo '<li class="page-item ' . $active . '"><a class="page-link" href="' . linkPag($p,$servicio,$q) . '">' . $p . '</a></li>';
              }}

              $nextDisabled = ($pagina >= $paginas) ? 'disabled' : '';
              echo '<li class="page-item ' . $nextDisabled . '"><a class="page-link" href="' . ($pagina<$paginas?linkPag($pagina+1,$servicio,$q):'#') . '">Siguiente</a></li>';
            ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  </section>
</main>

</body>
</html>
