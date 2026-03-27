# Sistema de Seguimiento de Proyectos - Multiservicios

## Instalación

1. **Clonar/Extraer** en `C:/Users/Usuario/Desktop/Multiservicios_project/`

2. **Base de Datos**:
   ```
   mysql -u root -p nombre_bd < sql/schema.sql
   ```

3. **Configurar DB**: Editar `config/database.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'multiservicios_db');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

4. **Dependencias** (opcional Composer):
   ```
   cd Multiservicios_project
   composer install
   ```

5. **Ejecutar**:
   ```
   cd public
   php -S localhost:8000
   ```
   O usar XAMPP/WAMP (htdocs/Multiservicios_project/public)

6. **Acceso**: http://localhost:8000
   - Admin default: user: admin | pass: admin123 (cambiar inmediatamente)

## Estructura
- MVC puro PHP
- Bootstrap 5 responsive
- Seguridad: Roles, CSRF, PDO prepared

## Módulos
- Usuarios/Roles
- Proyectos/Etapas
- Actividades/Actas
- Dashboard/Reportes

Ver TODO.md para progreso.
