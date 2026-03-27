-- Schema completo para Sistema Multiservicios Project
-- MySQL 8+ / InnoDB / UTF8MB4
-- Crear BD primero: CREATE DATABASE multiservicios_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE multiservicios_db;

-- Tabla Roles
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) UNIQUE NOT NULL,
    permisos JSON,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    activo TINYINT(1) DEFAULT 1,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Clientes
CREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    contacto VARCHAR(100),
    telefono VARCHAR(20),
    email VARCHAR(100),
    observaciones TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Proyectos
CREATE TABLE proyectos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    cliente_id INT,
    empresa VARCHAR(200),
    valor DECIMAL(12,2) DEFAULT 0,
    fecha_inicio DATE,
    fecha_fin DATE,
    estado ENUM('Oferta', 'Asignacion', 'Ejecucion', 'Portal', 'Liquidacion', 'Finalizacion') DEFAULT 'Oferta',
    responsable_id INT,
    descripcion TEXT,
    prioridad ENUM('Baja', 'Media', 'Alta', 'Urgente') DEFAULT 'Media',
    observaciones TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE SET NULL,
    FOREIGN KEY (responsable_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    INDEX idx_estado (estado),
    INDEX idx_responsable (responsable_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Etapas (master)
CREATE TABLE etapas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    porcentaje_default INT DEFAULT 0,
    descripcion VARCHAR(255),
    orden INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Proyecto_Etapas (muchas-por-muchas + datos)
CREATE TABLE proyecto_etapas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    proyecto_id INT NOT NULL,
    etapa_id INT NOT NULL,
    responsable_id INT,
    porcentaje INT NOT NULL DEFAULT 0 CHECK (porcentaje >= 0 AND porcentaje <= 100),
    fecha_inicio DATE,
    fecha_estimada DATE,
    fecha_final DATE,
    estado ENUM('Pendiente', 'En_proceso', 'Atrasado', 'Finalizado', 'Cancelado') DEFAULT 'Pendiente',
    avance INT DEFAULT 0 CHECK (avance >= 0 AND avance <= 100),
    comentarios TEXT,
    observaciones TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (etapa_id) REFERENCES etapas(id),
    FOREIGN KEY (responsable_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    UNIQUE KEY unique_proyecto_etapa (proyecto_id, etapa_id),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Actividades (seguimiento)
CREATE TABLE actividades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    proyecto_id INT NOT NULL,
    item VARCHAR(50),
    actividad VARCHAR(500) NOT NULL,
    responsable_id INT,
    asignacion DATE,
    fecha_propuesta DATE,
    finalizado DATE NULL,
    responsable_cliente VARCHAR(100),
    comentarios TEXT,
    sin_respuesta TINYINT(1) DEFAULT 0,
    ultima_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    sin_actualizar TINYINT(1) DEFAULT 0,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (responsable_id) REFERENCES usuarios(id),
    INDEX idx_proyecto (proyecto_id),
    INDEX idx_responsable (responsable_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Actas
CREATE TABLE actas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    proyecto_id INT NOT NULL,
    fecha_reunion DATE NOT NULL,
    titulo VARCHAR(255),
    contenido TEXT,
    creada_por INT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (creada_por) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Compromisos (de actas)
CREATE TABLE compromisos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    acta_id INT NOT NULL,
    descripcion VARCHAR(500),
    responsable_id INT,
    fecha_limite DATE,
    cumplido TINYINT(1) DEFAULT 0,
    comentarios TEXT,
    FOREIGN KEY (acta_id) REFERENCES actas(id) ON DELETE CASCADE,
    FOREIGN KEY (responsable_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Archivos/Adjuntos
CREATE TABLE archivos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    proyecto_id INT,
    etapa_id INT,
    tipo ENUM('etapa', 'actividad', 'acta', 'portal', 'liquidacion'),
    nombre_original VARCHAR(255),
    nombre_archivo VARCHAR(255),
    ruta VARCHAR(500),
    tamano INT,
    subido_por INT,
    subido_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (etapa_id) REFERENCES proyecto_etapas(id) ON DELETE CASCADE,
    FOREIGN KEY (subido_por) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Portal/Entregables
CREATE TABLE portal_entregables (
    id INT PRIMARY KEY AUTO_INCREMENT,
    proyecto_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    estado ENUM('Pendiente_cliente', 'Pendiente_empresa', 'Aprobado', 'Rechazado') DEFAULT 'Pendiente_cliente',
    archivo_id INT,
    fecha_subida DATE,
    comentarios TEXT,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (archivo_id) REFERENCES archivos(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Liquidaciones
CREATE TABLE liquidaciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    proyecto_id INT NOT NULL,
    monto DECIMAL(12,2),
    estado ENUM('Pendiente', 'Parcial', 'Completa') DEFAULT 'Pendiente',
    fecha_pago DATE,
    soportes TEXT, -- JSON archivos
    observaciones TEXT,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Historial (cambios)
CREATE TABLE historial (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tabla VARCHAR(50),
    registro_id INT,
    campo VARCHAR(100),
    valor_anterior TEXT,
    valor_nuevo TEXT,
    usuario_id INT,
    fecha_cambio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla Comentarios (general)
CREATE TABLE comentarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    proyecto_id INT,
    etapa_id INT,
    actividad_id INT,
    usuario_id INT,
    comentario TEXT NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (etapa_id) REFERENCES proyecto_etapas(id) ON DELETE CASCADE,
    FOREIGN KEY (actividad_id) REFERENCES actividades(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos Iniciales: Roles
INSERT INTO roles (nombre, permisos) VALUES
('Administrador', '{"*":true}'),
('Supervisor', '{"proyectos":["read","write"],"dashboard":true}'),
('Coordinador', '{"proyectos":"read","etapas":"write"}'),
('Operativo', '{"etapas":"write","actividades":"write"}'),
('Consulta', '{"proyectos":"read"}');

-- Usuario Admin default
INSERT INTO usuarios (username, email, password_hash, rol_id) VALUES
('admin', 'admin@multiservicios.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1); -- password: password

-- Etapas Default
INSERT INTO etapas (nombre, porcentaje_default, orden) VALUES
('Oferta', 10, 1),
('Asignación', 10, 2),
('Ejecución', 40, 3),
('Portal', 10, 4),
('Liquidación', 20, 5),
('Finalización', 10, 6);

-- Indexes adicionales
CREATE INDEX idx_usuarios_rol ON usuarios(rol_id);
CREATE INDEX idx_proyectos_cliente ON proyectos(cliente_id);
CREATE INDEX idx_actividades_fecha ON actividades(fecha_propuesta);
CREATE FULLTEXT INDEX ft_actividades ON actividades(actividad, comentarios);

-- Trigger ejemplo: Validar suma % etapas por proyecto
DELIMITER //
CREATE TRIGGER validar_porcentaje_total BEFORE INSERT ON proyecto_etapas
FOR EACH ROW
BEGIN
    DECLARE total_actual INT DEFAULT 0;
    SELECT COALESCE(SUM(porcentaje), 0) INTO total_actual
    FROM proyecto_etapas WHERE proyecto_id = NEW.proyecto_id;
    IF total_actual + NEW.porcentaje > 100 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Suma de porcentajes excede 100%';
    END IF;
END//
DELIMITER ;

