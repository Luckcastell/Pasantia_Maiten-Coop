-- Tabla auxiliar para registrar archivos por consulta(BD no la tiene pero seria de utilidad)
CREATE TABLE consulta_archivo (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_consulta INT NOT NULL,
  nombre_original VARCHAR(255) NOT NULL,
  mime VARCHAR(100) NOT NULL,
  tamano_bytes INT UNSIGNED NOT NULL,
  sha256 CHAR(64) NOT NULL,
  ruta_storage VARCHAR(512) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (id_consulta),
  CONSTRAINT fk_consulta_archivo
    FOREIGN KEY (id_consulta) REFERENCES consulta(id_consulta)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
