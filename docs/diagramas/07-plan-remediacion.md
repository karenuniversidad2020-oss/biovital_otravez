# Diagrama 7 — Plan de Remediación (Roadmap)

Camino sugerido para llevar el sistema de **65 / 100** a **90 / 100** sin reescribirlo.

```mermaid
gantt
    title Roadmap de remediación BioVital
    dateFormat  YYYY-MM-DD
    axisFormat  %d-%b

    section 🔴 Crítico (Semana 1)
    Crear RecetaController.php          :crit, r1, 2026-05-22, 3d
    Crear AsistenteController.php       :crit, r2, 2026-05-22, 2d
    Quitar get_hash.php                 :crit, r3, 2026-05-22, 1d
    Mover credenciales BD a .env        :crit, r4, 2026-05-23, 2d
    display_errors=0 en producción      :crit, r5, 2026-05-24, 1d

    section 🟠 Alto (Semanas 2-3)
    Unificar CSRF (eliminar duplicado)  :a1, after r5, 3d
    session_regenerate_id en login      :a2, after a1, 1d
    Implementar listarUsuarios real     :a3, after a2, 3d
    Cookies httpOnly + secure           :a4, after a3, 1d
    Mensajes de error genéricos         :a5, after a4, 1d

    section 🟡 Medio (Semanas 4-6)
    Tabla usuarios + credenciales unificada  :m1, after a5, 7d
    Renombrar tipo_paciente -> tipo_usuario  :m2, after m1, 2d
    Campos created_at / updated_at           :m3, after m2, 3d
    Quitar 'echo' de modelos                 :m4, after m3, 4d

    section 🟢 Bajo (Semana 7+)
    Composer + PSR-4 autoload   :b1, after m4, 3d
    .htaccess + URLs limpias    :b2, after b1, 2d
    Tests unitarios mínimos     :b3, after b2, 7d
    Dockerfile + docker-compose :b4, after b3, 3d
    CI/CD básico (GitHub Actions):b5, after b4, 3d
```

```mermaid
flowchart LR
    A[Estado actual<br/>65/100]:::now
    A --> B[Sprint 1<br/>Crítico cerrado<br/>+10 → 75/100]:::s1
    B --> C[Sprint 2<br/>Seguridad reforzada<br/>+8 → 83/100]:::s2
    C --> D[Sprint 3<br/>BD limpia + sin echo<br/>+5 → 88/100]:::s3
    D --> E[Sprint 4<br/>Tests + Deploy<br/>+5 → 93/100]:::ok

    classDef now fill:#fff3cd,stroke:#856404,color:#856404
    classDef s1 fill:#ffe0b2,stroke:#ef6c00,color:#ef6c00
    classDef s2 fill:#dcedc8,stroke:#558b2f,color:#558b2f
    classDef s3 fill:#c8e6c9,stroke:#2e7d32,color:#2e7d32
    classDef ok fill:#a5d6a7,stroke:#1b5e20,color:#1b5e20
```

## Definición de "listo" por sprint

### Sprint 1 — Crítico (objetivo: que **todas** las rutas devuelvan 200/3xx, no 500)
- [ ] Restaurar `RecetaController.php` (puede partirse de `/controlador/antiguos/RecetaController.php` y adaptarlo al nuevo front-controller).
- [ ] Restaurar `AsistenteController.php` (mismo patrón que `PacienteController`).
- [ ] Eliminar `get_hash.php` del repositorio.
- [ ] Crear `config/db.php` con lectura de variables de entorno.
- [ ] `error_reporting` y `display_errors` controlados por `APP_ENV`.

### Sprint 2 — Seguridad
- [ ] Borrar `js/csrf_helper.js` y `api/get_csrf_token.php`; dejar sólo `CSRFController`.
- [ ] En `AuthController::login` añadir `session_regenerate_id(true)` tras autenticar.
- [ ] `session_set_cookie_params(['httponly'=>true,'samesite'=>'Strict','secure'=>true])`.
- [ ] Implementar `AdministradorController::listarUsuarios` real con paginación.
- [ ] Unificar mensaje de credenciales inválidas.

### Sprint 3 — Limpieza de BD y modelos
- [ ] Migración a tabla única `usuarios` con FK a `roles`; mantener vistas SQL para no romper el front.
- [ ] Renombrar `tipo_paciente` → `tipo_usuario`.
- [ ] Añadir `created_at`, `updated_at`, `created_by`, `actor_id` a tablas operativas.
- [ ] Reemplazar `echo 'add'` / `echo 'existe'` por retornos `bool`/excepciones.

### Sprint 4 — Calidad y despliegue
- [ ] `composer.json` + PSR-4 + autoload real.
- [ ] `.htaccess` con `RewriteEngine` para URLs limpias.
- [ ] PHPUnit con al menos: login OK / login KO / CSRF inválido / CRUD receta.
- [ ] Dockerfile + docker-compose (PHP-FPM + MySQL + Nginx).
- [ ] Pipeline en GitHub Actions: lint + tests + build de imagen.
