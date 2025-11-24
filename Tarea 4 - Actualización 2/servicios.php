<?php require_once 'config.php'; ?>
<!doctype html>
<html lang="es-AR" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Servicios de Maitén Cooperativa | Asistencia y Beneficios</title>
    <meta name="description" content="Conocé los servicios de Maitén Cooperativa: Asistencia Hogar (plomería, electricidad, cerrajería, vidriería, armado de muebles), Asistencia Legal, Informática y Mascotas. Beneficios, requisitos y formulario para enviar consultas.">
    <meta name="color-scheme" content="light dark">
    
    <link rel="icon" type="image/png" href="favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="favicon/favicon.svg" />
    <link rel="shortcut icon" href="favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png" />
    <link rel="manifest" href="favicon/site.webmanifest" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    
    <style>
        :root{
            --bs-body-font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, "Helvetica Neue", Arial, "Apple Color Emoji","Segoe UI Emoji"; 
            --error: #dc3545; 
            --blanco: #ffffff; 
            --blanco2: #eef5ff;
            --azul: #122183;
            --azul-oscuro: #0b1760;
            --link: #007bff; 
            --hover: #3597ff;     
            --gris:#2c2c2c;
            --bs-success: var(--link);  
            --bs-success-rgb: 0,152,85;
            --bs-body-color: var(--gris);
            --bs-primary: var(--azul);
            --bs-primary-rgb: 18,33,131;
            --bs-link-color: var(--link);
            --bs-link-hover-color: var(--hover);
        }
        body {color: var(--gris);}
        .hero{background:var(--azul) ; color: var(--blanco);}
        .hero .lead{max-width: 60ch}
        .icon-32{width:2rem;height:2rem}
        .icon-48{width:3rem;height:3rem}
        .trusted-badge{border:1px solid rgba(0,0,0,.08); border-radius: .75rem; padding:.75rem 1rem; background: var(--blanco)}
        .faq-accordion .accordion-button:not(.collapsed){background-color: var(--blanco2)}
        .service-card{border-radius:1rem}
        .sticky-cta{position:sticky; bottom:0; z-index:1030}
        .visually-strong{font-weight: 700}
        .counter{font-variant-numeric: tabular-nums}
        .required::after{content:" *"; color: var(--error);}
        figcaption{padding-top: 20px;}
        @media (prefers-reduced-motion: reduce){ .animate{transition:none!important} }
        
        /* utilidades nav */
        .icon-22 { width: 22px; height: 22px; }
        .nav-link{ font-family: inherit; font-weight: inherit; transition: color 0.3s; }
        .nav-link:hover { color: var(--hover); }
        .icono-social { color: var(--azul); text-decoration: none; }
        .icono-social:hover { opacity: 0.8; }

        /* estilos footer */
        .footer { background-color: var(--azul); color: var(--blanco); }
        .footer a { text-decoration: none; }
        .link-verde { color: var(--link); }
        .link-verde:hover { color: var(--hover); }
        .redes-wrapper{ gap: .75rem; }
        .red-social{
        display:inline-flex; align-items:center; justify-content:center;
        width: 35px; height:35px; border-radius:50%;
        background-color: var(--blanco);
        color: var(--azul);
        transition: transform .2s ease, box-shadow .2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,.12);
        }
        .red-social:hover{ transform: translateY(-1px); box-shadow: 0 4px 10px rgba(0,0,0,.18); }
        .red-social svg{ width:20px; height:20px; }
        .footer-bottom{ background-color: var(--azul-oscuro); color: var(--blanco); }

        /* Estilos para animaciones de contador */
        .contador-numero {
            font-size: 3rem;
            font-weight: 700;
            color: var(--azul);
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo urlencode($RECAPTCHA_SITE_KEY ?? ''); ?>" async defer></script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity":
        [
            {
                "@type": "Question",
                "name": "¿Qué incluye la asistencia de Plomería?",
                "acceptedAnswer":
                {
                    "@type": "Answer",
                    "text": "Cubre fallas por rotura de cañerías, llaves u otras instalaciones fijas de agua en el interior de la vivienda que requieran urgente solución por generar una pérdida. Se excluyen obstrucciones y trabajos de mantenimiento."
                }
            },
            {
                "@type": "Question",
                "name": "¿Qué documentación puedo adjuntar en mi consulta?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "El formulario permite adjuntar hasta 5 archivos en formato PDF, JPG y PNG. Esto es útil para enviar documentación, presupuestos o informes relacionados con tu consulta."
                }
            }
        ]
    }
    </script>
</head>
<body>

    <header>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top" aria-label="Barra de navegación principal">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo getLink('home'); ?>"><picture><source srcset="img/logo-azul.webp" type="image/webp"/><img src="img/logo-azul.png" alt="Logo Maitén" width="150" height="40" class="img-fluid"></picture></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPrincipal" aria-controls="navPrincipal" aria-expanded="false" aria-label="Alternar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navPrincipal">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="<?php echo getLink('home'); ?>">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo getLink('productos'); ?>">Productos</a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?php echo getLink('servicios'); ?>">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo getLink('quienes'); ?>">Quiénes somos</a></li>
                    <li class="nav-item me-lg-2"><a class="nav-link" href="<?php echo getLink('contacto'); ?>">Contacto</a></li>

                    <li class="nav-item d-flex gap-2 mt-2 mt-lg-0">
                        <a href="https://www.instagram.com/maiten.cooperativa/" target="_blank" rel="noopener noreferrer"
                        aria-label="Instagram de Maitén Cooperativa" data-bs-toggle="tooltip" data-bs-title="Instagram"
                        class="icono-social me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="icon-22" aria-hidden="true" focusable="false">
                            <path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                        </svg>
                        <span class="visually-hidden">Instagram</span>
                        </a>
                        <a href="https://www.facebook.com/maiten.cooperativa.ltda" target="_blank" rel="noopener noreferrer"
                        aria-label="Facebook de Maitén Cooperativa" data-bs-toggle="tooltip" data-bs-title="Facebook"
                        class="icono-social">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icon-22" aria-hidden="true" focusable="false">
                            <path fill="currentColor" d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/>
                        </svg>
                        <span class="visually-hidden">Facebook</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <a class="visually-hidden-focusable position-absolute top-0 start-0 p-2 bg-white text-primary rounded-end" href="#contenido">Saltar al contenido</a>

    <header class="hero py-5 mb-4">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold mb-3">Servicios de Maitén Cooperativa</h1>
                <p class="lead mb-4">Soluciones prácticas para tu hogar, tu tecnología, tus trámites legales y el cuidado de tus mascotas. Información clara, descargas útiles y una landing para enviar documentos y recibir asesoramiento.</p>
                <div class="d-flex gap-2 flex-wrap">
                    <a class="btn btn-light btn-lg text-primary fw-semibold" href="#servicios-hogar">Ver servicios</a>
                    <a class="btn btn-outline-light btn-lg" href="<?php echo getLink('productos'); ?>">Conocé nuestros Productos</a>
                </div>
            </div>
            <div class="col-lg-5 text-center">
            <picture>
                <source type="image/webp" srcset="img/logo-blanco.webp" />
                <source type="image/png" srcset="img/logo-blanco.png" />
                <img src="img/logo-blanco.png" loading="lazy" decoding="async" alt="Ilustración de asistencia y servicios" width="480" height="320" class="img-fluid rounded shadow-sm"/>
            </picture>
            </div>
        </div>
    </div>
    </header>
</header>
    <main id="contenido">
        <section class="encabezado-servicios py-5 bg-light">
            <div class="container text-center">
                <h1 class="display-4 fw-bold text-azul mb-3">Servicios Sociales Maitén</h1>
                <p class="lead text-gris">Trabajamos cada día para sumarte beneficios a través de **RUA ASISTENCIA**. Conocé el detalle de la cobertura de Hogar, Legal, Informática y Mascotas.</p>
                <div class="mt-4">
                    <a href="#formulario-consulta" class="btn btn-primary btn-lg shadow-sm" style="background-color: var(--link); border-color: var(--link);">Consultar Ahora <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </section>
        
        <section id="galeria-confianza" class="py-5 bg-blanco2">
            <div class="container">
                <h2 class="text-center mb-5 fw-bold text-azul">Maitén: Confianza y Respaldo</h2>
                <div class="row justify-content-center g-4 text-center">

                    <div class="col-6 col-md-3">
                        <div class="card h-100 p-3 shadow-sm border-0">
                            <i class="bi bi-patch-check-fill display-5" style="color: var(--link);"></i>
                            <h3 class="fs-5 mt-2 fw-semibold">Cooperativa Registrada</h3>
                            <p class="card-text text-muted small">Matrícula INAES N° 29.971.</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="card h-100 p-3 shadow-sm border-0">
                            <i class="bi bi-clock-history display-5" style="color: var(--link);"></i>
                            <h3 class="fs-5 mt-2 fw-semibold">Atención Rápida y Programada</h3>
                            <p class="card-text text-muted small">Te asistimos en emergencias o coordinamos el servicio que necesites.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="py-4 bg-white">
            <h2 class="display-5 fw-bold text-center mb-5 text-azul">Asistencia Hogar 24 Horas</h2>
            <div class="container">
                <div class="row g-3">
                <div class="col-6 col-md-3"><picture><source type="image/webp" srcset="img/galeria-1.webp" /><img class="img-fluid rounded" src="img/galeria-1.webp" loading="lazy" decoding="async" width="320" height="200" alt="Técnico realizando una reparación"/></picture></div>
                <div class="col-6 col-md-3"><picture><source type="image/webp" srcset="img/galeria-2.webp" /><img class="img-fluid rounded" src="img/galeria-2.webp" loading="lazy" decoding="async" width="320" height="200" alt="Asesoría legal por teléfono"/></picture></div>
                <div class="col-6 col-md-3"><picture><source type="image/webp" srcset="img/galeria-3.webp" /><img class="img-fluid rounded" src="img/galeria-3.webp" loading="lazy" decoding="async" width="320" height="200" alt="Soporte informático a distancia"/></picture></div>
                <div class="col-6 col-md-3"><picture><source type="image/webp" srcset="img/galeria-4.webp" /><img class="img-fluid rounded" src="img/galeria-4.webp" loading="lazy" decoding="async" width="320" height="200" alt="Atención veterinaria para mascotas"/></picture></div>
                </div>
            </div>
        </section>
        
        <section id="servicios-hogar" class="py-5">
            <div class="container">
                <h2 class="text-center display-5 fw-bold text-azul mb-5">Detalle de Asistencia y Servicios</h2>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    
                    <div class="col">
                        <div class="card service-card p-4 h-100 shadow-sm d-flex flex-column">
                            <i class="bi bi-droplet-fill display-5 text-primary mb-3"></i>
                            <h3 class="card-title fw-bold">Plomería</h3>
                            <p class="card-text flex-grow-1">Se consideran fallas por rotura de cañerías, llaves u otras instalaciones fijas de agua en el interior de la vivienda que requieran urgente solución por generar una pérdida. RUA ASISTENCIA enviará un técnico para realizar la reparación de urgencia.</p>
                            
                            <div class="mt-3 pt-3 border-top" style="font-size: 0.85rem;">
                                <h4 class="fw-bold mb-2 fs-6">Exclusiones principales:</h4>
                                <ul class="list-unstyled mb-0 text-muted">
                                    <li>Reparación de daños por filtración o humedad.</li>
                                    <li>Aparatos sanitarios, calderas, calentadores o electrodomésticos.</li>
                                    <li>Obstrucciones de cañerías y trabajos de mantenimiento.</li>
                                    <li>Repuestos no básicos (cañerías, cerraduras, etc.).</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card service-card p-4 h-100 shadow-sm bg-blanco2 d-flex flex-column">
                            <i class="bi bi-lightning-fill display-5 text-primary mb-3"></i>
                            <h3 class="card-title fw-bold">Electricidad</h3>
                            <p class="card-text flex-grow-1">Cubre la falta de suministro eléctrico, total o parcial en la vivienda, producido como consecuencia de una falla o avería de las instalaciones eléctricas internas. No incluye trabajos de envergadura, como la renovación de tendidos eléctricos.</p>
                            
                            <div class="mt-3 pt-3 border-top" style="font-size: 0.85rem;">
                                <h4 class="fw-bold mb-2 fs-6">Exclusiones principales:</h4>
                                <ul class="list-unstyled mb-0 text-muted">
                                    <li>Reparación de elementos de iluminación (lámparas, bombillas).</li>
                                    <li>Reparación de averías de aparatos de calefacción o electrodomésticos.</li>
                                    <li>Trabajos de mantenimiento o de mejora de las instalaciones existentes.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card service-card p-4 h-100 shadow-sm d-flex flex-column">
                            <i class="bi bi-key-fill display-5 text-primary mb-3"></i>
                            <h3 class="card-title fw-bold">Cerrajería</h3>
                            <p class="card-text flex-grow-1">Cubre la imposibilidad de acceso o salida de la vivienda por extravío, robo de llaves o inutilización de cerraduras. La asistencia se otorga en caso de siniestro por urgencia (ej: queda alguien encerrado) o por evento cubierto.</p>
                            
                            <div class="mt-3 pt-3 border-top" style="font-size: 0.85rem;">
                                <h4 class="fw-bold mb-2 fs-6">Exclusiones principales:</h4>
                                <ul class="list-unstyled mb-0 text-muted">
                                    <li>Rotura de cristales o vidrios.</li>
                                    <li>Cerraduras de muebles, gabinetes o vehículos.</li>
                                    <li>Instalación de cerraduras o dispositivos de seguridad.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card service-card p-4 h-100 shadow-sm bg-blanco2 d-flex flex-column">
                            <i class="bi bi-window-split display-5 text-primary mb-3"></i>
                            <h3 class="card-title fw-bold">Vidriería</h3>
                            <p class="card-text flex-grow-1">Rotura de vidrios, cristales o espejos de puertas y ventanas que formen parte del cerramiento de la vivienda por accidente, impacto o intento de robo. El servicio incluye el reemplazo por un vidrio similar.</p>
                            
                            <div class="mt-3 pt-3 border-top" style="font-size: 0.85rem;">
                                <h4 class="fw-bold mb-2 fs-6">Exclusiones principales:</h4>
                                <ul class="list-unstyled mb-0 text-muted">
                                    <li>Marcos, herrajes, o carpintería.</li>
                                    <li>Reemplazo de vitrales, vidrios curvos o decorativos.</li>
                                    <li>Ruptura causada por terremotos o fenómenos naturales.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card service-card p-4 h-100 shadow-sm d-flex flex-column">
                            <i class="bi bi-tools display-5 text-primary mb-3"></i>
                            <h3 class="card-title fw-bold">Armado de Muebles</h3>
                            <p class="card-text flex-grow-1">Servicio de coordinación para el armado o desarme de muebles nuevos y/o existentes. Se agenda en horarios programados y no constituye una emergencia.</p>
                            
                            <div class="mt-3 pt-3 border-top" style="font-size: 0.85rem;">
                                <h4 class="fw-bold mb-2 fs-6">Exclusiones principales:</h4>
                                <ul class="list-unstyled mb-0 text-muted">
                                    <li>Muebles empotrados o de obra.</li>
                                    <li>Muebles con modificaciones estructurales previas.</li>
                                    <li>Materiales de reparación (se proveen solo herramientas).</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card service-card p-4 h-100 shadow-sm bg-blanco2 d-flex flex-column">
                            <i class="bi bi-briefcase display-5 text-primary mb-3"></i>
                            <h3 class="card-title fw-bold">Asistencia Legal</h3>
                            <p class="card-text flex-grow-1">Orientación telefónica con abogado especializado para consultas sobre Derecho laboral, civil, familiar y mercantil. Incluye asesoramiento en procesos como robos, accidentes y orientación en la revisión de documentos legales (contratos, denuncias, etc.).</p>
                            
                            <div class="mt-3 pt-3 border-top" style="font-size: 0.85rem;">
                                <h4 class="fw-bold mb-2 fs-6">Exclusiones principales:</h4>
                                <ul class="list-unstyled mb-0 text-muted">
                                    <li>La redacción de documentos y el asesoramiento legal in situ o durante procesos judiciales será a cargo del Beneficiario.</li>
                                    <li>Casos que requieran representación o asistencia en audiencias.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card service-card p-4 h-100 shadow-sm d-flex flex-column">
                            <i class="bi bi-pc-display-horizontal display-5 text-primary mb-3"></i>
                            <h3 class="card-title fw-bold">Asistencia Informática</h3>
                            <p class="card-text flex-grow-1">Atención telefónica y remota 24/7 para consultas tecnológicas, configuración de periféricos, instalación de anti-spyware y asesoramiento sobre software o hardware. Contempla 5 eventos anuales para configuración y soporte.</p>
                            
                            <div class="mt-3 pt-3 border-top" style="font-size: 0.85rem;">
                                <h4 class="fw-bold mb-2 fs-6">Exclusiones principales:</h4>
                                <ul class="list-unstyled mb-0 text-muted">
                                    <li>Reparación o reemplazo de hardware.</li>
                                    <li>El costo del servicio de técnico a domicilio (se coordina a costo preferencial a cargo del beneficiario).</li>
                                    <li>Problemas relacionados con piratería o uso ilegal.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="card service-card p-4 h-100 shadow-sm bg-blanco2 d-flex flex-column">
                            <i class="bi bi-heart-fill display-5 text-primary mb-3"></i>
                            <h3 class="card-title fw-bold">Asistencia Mascotas</h3>
                            <p class="card-text flex-grow-1">Servicio de chequeos generales (2 eventos anuales), coordinación de urgencias 24 hs (2 eventos anuales) y orientación veterinaria telefónica sin límites. Incluye orientación legal por demandas a terceros causadas por la mascota.</p>
                            
                            <div class="mt-3 pt-3 border-top" style="font-size: 0.85rem;">
                                <h4 class="fw-bold mb-2 fs-6">Exclusiones principales:</h4>
                                <ul class="list-unstyled mb-0 text-muted">
                                    <li>Costos de medicamentos, vacunas, cirugías, internaciones o estética.</li>
                                    <li>Atención a animales exóticos o de granja.</li>
                                    <li>Costos de servicios que excedan el tope de cobertura establecido.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="landing" class="py-5 bg-light">
            <div class="container">
                <h2 class="display-4 fw-bold text-center text-azul mb-4" id="formulario-consulta">Asesoramiento y Contacto</h2>
                <div class="row justify-content-center g-4">
                    
                    <div class="col-lg-6">
                        <div class="p-4 p-md-5 h-100 d-flex flex-column justify-content-start">
                            <h3 class="fw-bold display-6 mb-3">Tu consulta en 3 simples pasos</h3>
                            <p class="lead">Para brindarte una atención más eficiente y coordinada, te pedimos que completes todos los campos obligatorios del formulario.</p>

                            <ul class="list-unstyled lead mb-4">
                                <li><i class="bi bi-1-circle-fill text-primary me-2"></i> Elegí el **motivo de tu consulta**.</li>
                                <li><i class="bi bi-2-circle-fill text-primary me-2"></i> Adjuntá **documentación relevante** (opcional).</li>
                                <li><i class="bi bi-3-circle-fill text-primary me-2"></i> Esperá nuestra **respuesta a la brevedad**.</li>
                            </ul>
                            <p class="mt-4"><a href="<?php echo getLink('productos'); ?>" class="btn btn-outline-primary btn-sm">Ver todos nuestros Productos</a></p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card card-body shadow-lg p-4 p-md-5">
                            <h3 class="card-title fw-bold mb-4">Envianos tu documentación</h3>
                            <form id="form-consulta" action="/api/consulta" method="POST" enctype="multipart/form-data" novalidate>
                                
                                <div class="form-group mb-3 d-none">
                                    <label for="nombre_invisible" class="visually-hidden">Nombre (dejar vacío)</label>
                                    <input type="text" id="nombre_invisible" name="nombre_invisible" class="form-control" tabindex="-1" autocomplete="off">
                                </div>

                                <div class="mb-3">
                                    <label for="nombre" class="form-label required">Nombre y Apellido</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required aria-required="true" maxlength="100">
                                    <div class="invalid-feedback">Por favor, ingresá tu nombre y apellido.</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label required">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" required aria-required="true" maxlength="100">
                                    <div class="invalid-feedback">Por favor, ingresá un correo electrónico válido.</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="telefono" class="form-label required">Teléfono (WhatsApp)</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" required aria-required="true" maxlength="20">
                                    <div class="invalid-feedback">Por favor, ingresá un número de teléfono.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="motivo_consulta" class="form-label required">Motivo de la consulta</label>
                                    <select class="form-select" id="motivo_consulta" name="motivo_consulta" required aria-required="true" data-search="true">
        <option value="" disabled selected>Seleccioná el motivo</option>
        <option value="reclamo">Reclamo</option>
        <option value="consulta">Consulta</option>
        <option value="adquisicion">Adquisición</option>
    </select>
                                    <div class="invalid-feedback">Por favor, seleccioná el motivo de tu consulta.</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="mensaje" class="form-label required">Detalle de la Consulta</label>
                                    <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required aria-required="true" maxlength="500"></textarea>
                                    <div class="invalid-feedback">Por favor, detallá tu consulta.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="adjuntos" class="form-label">Adjuntar Documentación (Máx. 5 archivos)</label>
                                    <input class="form-control" type="file" id="adjuntos" name="adjuntos[]" multiple accept=".pdf, .jpg, .jpeg, .png" data-max-files="5">
                                    <div class="form-text">Formatos permitidos: PDF, JPG, PNG.</div>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="acepto_tyc" name="acepto_tyc" required aria-required="true">
                                        <label class="form-check-label required small text-muted" for="acepto_tyc">
                                            Acepto los <a href="#" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#terminosModal">términos y condiciones</a> y la política de privacidad.
                                        </label>
                                        <div class="invalid-feedback">Debes aceptar los términos y condiciones.</div>
                                    </div>
                                </div>

                                <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                                
                                <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold" id="btn-submit">Enviar Consulta</button>
                                
                                <div id="resultado" class="mt-3 text-center" aria-live="polite"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="py-5">
            <h2 class="display-5 fw-bold text-center mb-5 text-azul">Preguntas Frecuentes (FAQ)</h2>
            <div class="container">
                <div class="accordion accordion-flush faq-accordion" id="accordionFlushExample">
                    
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                ¿Qué documentación necesito para acceder a los servicios?
                            </button>
                        </h3>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Para la mayoría de los servicios de asistencia, solo necesitás tus datos de asociado y la dirección del servicio. Para consultas legales o que requieran análisis (ej. armado de muebles o siniestros de vidriería), es útil adjuntar fotos o documentación relevante en el formulario.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                ¿Los servicios de hogar tienen un límite de uso?
                            </button>
                        </h3>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Sí, cada servicio de emergencia (Plomería, Electricidad, Cerrajería, Vidriería) tiene un límite de eventos por año y límites en los montos de materiales y mano de obra. Recomendamos consultar las bases y condiciones completas que se pueden descargar desde la sección de Productos.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                ¿La Asistencia Legal cubre juicios o representación?
                            </button>
                        </h3>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                La Asistencia Legal es un servicio de orientación telefónica y consulta primaria. No incluye la representación en juicios, la realización de trámites presenciales, ni el pago de honorarios de abogados para procesos de litigio. Su objetivo es brindarte el asesoramiento inicial.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="flush-headingFour">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                ¿Qué tipo de problemas informáticos se resuelven?
                            </button>
                        </h3>
                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                Se resuelven problemas de software, virus, configuración de internet, correo electrónico, y ayuda con el uso de programas básicos. La asistencia es remota o telefónica, por lo que no se cubren fallas físicas de hardware (ej. pantalla rota, disco duro dañado).
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        
        <div class="w-100" style="overflow: hidden; line-height: 0; background-color: #fff;">
            <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 60px; width: 100%;">
                <path d="M0.00,49.98 C150.00,150.00 349.20,-49.98 500.00,49.98 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #122183;"></path>
            </svg>
        </div>

    </main>

    <footer class="footer mt-auto text-white">
        <div class="container py-3">
        <div class="row gy-4 align-items-start">
            <div class="col-lg-4">
            <img src="img/logo-blanco.webp" alt="Maitén Cooperativa de Crédito" class="mb-3" style="max-width:220px;">
            </div>

            <div class="col-lg-5">
            <address class="mb-3">
                <div>Viamonte 1336 6to, 38</div>
                <div>(C1053ACB) Ciudad Autonoma de Buenos Aires, Argentina</div>
                <div>Av. Colón 352</div>
                <div>(X5000 EPQ) Córdoba, Provincia de Córdoba, Argentina</div>
            </address>

            <p class="mb-1">Tel: <a href="tel:+5491171016617" class="link-verde">+54 9 11 7101-6617</a></p>
            <p class="fw-bold mb-1"><a href="mailto:comercial@maitencoop.com.ar" class="link-verde">comercial@maitencoop.com.ar</a></p>
            <p class="fw-bold mb-3"><a href="mailto:comunicacion@maitencoop.com.ar" class="link-verde">comunicacion@maitencoop.com.ar</a></p>

            <p class="fw-bold mb-1">Matrícula INAES Nº 29.971</p>
            <p class="small mb-2">Resolución 113.665/2005</p>
            <p class="small mb-0">Entidad Nº 257 autorizada por la Caja de Jubilaciones y Pensiones de la Provincia de Córdoba</p>
            </div>
            
            <div class="col-lg-3 d-flex justify-content-lg-end">
            <div class="d-flex redes-wrapper">
                <a class="red-social" href="https://www.facebook.com/maiten.cooperativa.ltda" target="_blank" rel="noopener noreferrer" aria-label="Facebook de Maitén">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" aria-hidden="true" focusable="false">
                    <path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91V127.9c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S271.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.2V288z"/>
                </svg>
                </a>
                <a class="red-social" href="https://www.instagram.com/maiten.cooperativa/" target="_blank" rel="noopener noreferrer" aria-label="Instagram de Maitén">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" aria-hidden="true" focusable="false">
                    <path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                </svg>
                </a>
                <a class="red-social" href="https://wa.link/s8ukfe" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp de Maitén">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" aria-hidden="true" focusable="false">
                    <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path>
                </svg>
                </a>
            </div>
            </div>
        </div>
        </div>

        <div class="footer-bottom py-3">
        <div class="container text-center small">
            © <span id="current-year"></span> Maitén Cooperativa de Crédito
        </div>
        </div>
    </footer>

    <div class="modal fade" id="terminosModal" tabindex="-1" aria-labelledby="terminosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="terminosModalLabel">Términos y Condiciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Aceptación</h6>
                    <p>Al utilizar este formulario, usted acepta que sus datos serán procesados para gestionar su solicitud.</p>
                    <h6>2. Privacidad</h6>
                    <p>Sus datos personales son confidenciales y no serán compartidos con terceros ajenos a la prestación del servicio.</p>
                    <h6>3. Documentación</h6>
                    <p>Los archivos adjuntos deben ser legítimos y estar relacionados con la consulta.</p>
                    <p>...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="document.getElementById('acepto_tyc').checked = true;">Aceptar Términos</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
    (
        function () {
            document.getElementById('current-year').textContent = new Date().getFullYear();

            // Constante para reCAPTCHA (Debe ser reemplazada por una clave real)
            const CLAVE_SITIO_RECAPTCHA = '<?php echo htmlspecialchars($RECAPTCHA_SITE_KEY ?? '', ENT_QUOTES, 'UTF-8'); ?>'; 
            
            const form_html = document.getElementById('form-consulta');
            const resultado_div = document.getElementById('resultado');
            const boton_submit = document.getElementById('btn-submit');
            
            // Reemplazo de variables de nombres del script original por nombres más claros (form, out)
            const form = form_html;
            const out = resultado_div;

            if (!form) return; 

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Validación nativa de HTML5
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                form.classList.remove('was-validated');
                boton_submit.disabled = true;
                
                out.innerHTML = '<span class="text-primary">Enviando consulta...</span>';

                // --- INICIO: LÓGICA reCAPTCHA v3 ---
                grecaptcha.ready(function() {
                    // La función grecaptcha.execute es ASÍNCRONA y genera el token.
                    grecaptcha.execute(CLAVE_SITIO_RECAPTCHA, {action: 'consulta'}).then(async function(token) {
                        // 1. Asignar el token al campo oculto.
                        document.getElementById('recaptcha_token').value = token;
                        
                        // 2. Crear y enviar el formulario (que ahora incluye el token y el honeypot).
                        const formData = new FormData(form);
                        
                        try {
                            const respuesta = await fetch(form.action, { method: 'POST', body: formData });
                            
                            // Verificamos si la respuesta fue un éxito HTTP (código 200-299)
                            if (!respuesta.ok) {
                                throw new Error(`Error de servidor: ${respuesta.status}`);
                            }
                            
                            const datos_respuesta = await respuesta.json();
                            
                            // Verificamos el 'ok' en la respuesta JSON (validación del servidor)
                            if (datos_respuesta.ok) {
                                out.innerHTML = '<span class=\"text-success fw-bold\"> Consulta recibida. Te respondemos a la brevedad.</span>';
                                form.reset();
                            } else {
                                // Manejo de errores de validación, reCAPTCHA, o honeypot en el backend
                                const errores = datos_respuesta.errors ? datos_respuesta.errors.join(' | ') : 'Error inesperado al guardar la consulta.';
                                out.innerHTML = `<span class=\"text-danger fw-bold\"> ${errores}</span>`;
                            }
                        } catch (error_peticion) {
                            // Manejo de errores de red o errores lanzados
                            out.innerHTML = '<span class=\"text-danger fw-bold\"> Error de conexión o respuesta inválida del servidor.</span>';
                        } finally {
                            // Siempre habilitamos el botón al finalizar.
                            boton_submit.disabled = false;
                        }
                    });
                });
                // --- FIN: LÓGICA reCAPTCHA ---
            }, { passive: false });
        }
    )();
    </script>

</body>
</html>