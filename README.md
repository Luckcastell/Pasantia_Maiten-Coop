# 📄 Proyecto: Página de Servicios – Maitén Cooperativa

Este proyecto implementa la página **Servicios** de Maitén Cooperativa, utilizando **Bootstrap 5** sin dependencias extra.  
Está diseñado para lograr **alta puntuación en Lighthouse** (≥90 en rendimiento y accesibilidad) y cumplir con buenas prácticas de **SEO** y **usabilidad**.

---

## 📂 Estructura de archivos

/maiten_servicios/
├── index.html

├── img/

│ ├── servicios-hero.webp

│ ├── galeria-1.webp

│ ├── galeria-2.webp

│ ├── galeria-3.webp

│ └── galeria-4.webp

└── docs/

├── plomeria.pdf

├── electricidad.pdf

├── cerrajeria.pdf

├── vidrieria.pdf

├── armado-muebles.pdf

├── asistencia-legal.pdf

├── asistencia-informatica.pdf

└── asistencia-mascotas.pdf

- **index.html** → Página principal, con todo el código inline (HTML, CSS y JS minificado).  
- **img/** → Imágenes en formato **WebP**, optimizadas con `loading="lazy"`.  
- **docs/** → Documentos PDF descargables relacionados a cada servicio.  

---

## 🧩 Estructura de la página

### 1. `<head>`
- Meta-descripción optimizada.  
- Títulos H1 y H2 correctamente jerarquizados.  
- JSON-LD con **Schema FAQ** para SEO.  
- Bootstrap 5 vía CDN.  
- CSS y JS inline minificados.  

---

### 2. **Header / Hero**
- Título principal (**H1**) con palabra clave.  
- Texto breve de introducción.  
- CTA (botón) visible y accesible.  
- Imagen principal en formato `.webp`.  

**Objetivo:** captar la atención y mostrar la propuesta de valor en segundos.

---

### 3. **Sección: Asistencia Hogar (contenedor)**
Dentro se agrupan los **8 servicios principales**, cada uno en **cards responsivas**:

- **Plomería**  
- **Electricidad**  
- **Cerrajería**  
- **Vidriería**  
- **Armado de muebles**  
- **Asistencia Legal**  
- **Asistencia Informática**  
- **Asistencia Mascotas**  

Cada servicio incluye:
- Descripción de ≤120 palabras.  
- FAQs en acordeón (2–3 preguntas frecuentes).  
- Botón para descargar un PDF con información extra (`docs/*.pdf`).  

---

### 4. **Badges de confianza**
Pequeños bloques con íconos y texto que refuerzan seguridad:  
- Atención 24/7  
- Profesionales matriculados  
- Cobertura en CABA y GBA  

---

### 5. **Testimonios + Contadores**
- **Testimonios reales** de clientes (prueba social).  
- **Contadores animados** (ejemplo: “+2000 hogares asistidos”).  

**Objetivo:** generar credibilidad.

---

### 6. **Galería**
- 4 imágenes `.webp` con `loading="lazy"`.  
- Diseño en cuadrícula para desktop y en carrusel para mobile.  

**Objetivo:** mostrar servicios en acción.

---

### 7. **Landing persuasiva**
Incluye:
- Beneficios claros y directos.  
- Badges de confianza y microcopys que reducen fricción.  
- Testimonios estratégicos.  
- Formulario accesible con campos básicos + **subida de documentos** (`<input type="file">`).  

**Objetivo:** convertir visitantes en clientes.  

---

### 8. **Sticky CTA**
Barra inferior con un **botón fijo** (“Solicitar servicio”) para que la acción esté siempre visible.  

---

### 9. **Footer**
- Enlaces legales y de privacidad.  
- Copyright dinámico (año automático con JS).  

---

### 10. **Scripts**
- Bootstrap bundle (incluye Popper).  
- Animación de contadores.  
- Código inline minificado para performance.  

---

## ⚙️ Requisitos técnicos cumplidos
- ✅ **Bootstrap 5** sin dependencias externas.  
- ✅ **Imágenes WebP** con lazy-loading.  
- ✅ **Schema FAQ en JSON-LD** para SEO.  
- ✅ **Meta-descripción optimizada**.  
- ✅ **Contraste y etiquetas ARIA** para accesibilidad.  
- ✅ **Lighthouse ≥90** en rendimiento y accesibilidad (con imágenes optimizadas).  

---

## 🚀 Próximos pasos
1. Reemplazar PDFs de `/docs/` por material con contenido real.    
2. Implementar **backend** del formulario (PHP) para recibir envíos y guardar documentos.
