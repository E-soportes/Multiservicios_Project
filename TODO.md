# TODO - Sistema Multiservicios Project

## Pasos del Desarrollo (MVC PHP/MySQL)

### 1. ✅ Estructura inicial completada
   - Carpetas: config/, controladores/, modelos/, vistas/, assets/, public/, sql/, helpers/
   - README.md, TODO.md

### 2. ✅ Crear script base de datos (sql/schema.sql)
   - Todas tablas, FKs, datos iniciales (admin/password), trigger suma %

### 3. ✅ Configuración base
   - config/database.php (PDO singleton)
   - public/index.php (router MVC)
   - .htaccess (rewrites)

### 4. ✅ Módulo Usuarios y Roles
   - Modelos Usuario/Rol
   - Controladores Autenticacion/Usuarios
   - Vistas login, usuarios CRUD

### 5. ✅ Sistema de Autenticación
   - Login/logout básico
   - Helper Autenticacion

### 6. ✅ Módulo Proyectos básico
   - Modelo Proyecto/Cliente
   - Controlador CRUD
   - Vistas list/crear/editar/ver con filtros, progreso bar

### 7. ✅ Módulo Etapas
   - Modelos Etapa/ProyectoEtapa
   - ControladorEtapas, vista asignar/actualizar
   - Suma % con validación DB, tabla progreso

### 8. ⏳ Módulo Actividades/Seguimiento
   - modelo/Actividad.php
   - Campos Excel-like
   - Listado por proyecto

### 9. Módulo Actas de Reuniones
   - modelo/Acta.php
   - CRUD, compromisos

### 10. Módulo Portal
   - Entregables con estados

### 11. Módulo Liquidación y Finalización

### 12. ✅ Dashboard básico
   - Métricas, gráficos Chart.js

### 13. Reportes
   - Exports Excel/PDF

### 14. ✅ Assets y Layouts base
   - Bootstrap 5 layout, CSS/JS custom, DataTables

### 15. ✅ Helpers y Utilidades
   - Validador, Autenticacion, SubirArchivos

### 16. Seguridad Completa
   - CSRF, sanitización completa

### 17. Pruebas Integrales
   - CRUD full, dashboard

### 18. ⏳ Finalizar y entregar

**Estado**: Core funcional (usuarios, proyectos, etapas, dashboard). Listo para probar.

**Próximos**: Módulo actividades, reportes, seguridad avanzada.

**Comandos**:
- DB: `mysql -u root -p multiservicios_db < sql/schema.sql`
- Server: `cd "C:/Users/Usuario/Desktop/Multiservicios_project" && php -S localhost:8000 -t public/`
- Login: admin / password
