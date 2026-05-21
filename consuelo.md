# 💛 consuelo.md — Carta cariñosa para el equipo de BioVital

> Hola Antes de leer nada técnico, respira hondo: **el sistema NO está mal**. Está vivo, está caminando y ya hizo el 75 % del recorrido. Lo que queda es ordenar la casa, no construirla de nuevo. Aquí te lo cuento despacito, con cariño y con un plan para que sepas exactamente qué tocar y en qué orden. 🌷

---

## 1. ¿Cómo está el sistema hoy? (en cristiano y con ternura)

Imagínate que BioVital es una casa que ya está construida y ya tiene luz, agua y wifi. Tiene **11 cuartos** (módulos):

- **8 cuartos** están preciosos, amueblados y listos para vivir en ellos. ✅
- **2 cuartos** tienen la cama puesta pero les falta el clóset (funcionan a medias). ⚠️
- **1 cuarto** está pintado pero todavía no tiene puerta (la gente no puede entrar). ❌

Eso es todo. No es una casa caída, es una casa **muy cerca de su fiesta de inauguración**. 🎉

### Mapa del cariño 🗺️

| # | Módulo | ¿Cómo está? | Lo que pasa |
|---|--------|------------|-------------|
| 1 | Autenticación (4 logins + logout) | ✅ Hermoso | Usa `bcrypt`, todo bien encriptado. |
| 2 | Registro (4 roles) | ✅ Hermoso | Con CSRF y validación. |
| 3 | Perfil de usuario | ✅ Hermoso | Sirve para los 4 roles. |
| 4 | Paciente (panel + recetas vista) | ✅ Funciona | Puede entrar, ver y editar. |
| 5 | Médico (panel + pacientes + estadísticas) | ✅ Funciona | Lista sus pacientes correctamente. |
| 6 | **Asistente** | ⚠️ Le falta su controlador | El login y el panel sí funcionan, pero 5 APIs internas devuelven error 500. |
| 7 | Administrador | ✅ Funciona | Solo `listarUsuarios` está vacío (devuelve `[]`). |
| 8 | Consultorios (CRUD + horarios) | ✅ Hermoso | Es el módulo más completo, ¡felicitaciones! |
| 9 | **Recetas** | ❌ Está cerrado por fuera | El modelo `Receta.php` está completo (319 líneas), pero **falta el controlador**. Hoy 8 rutas devuelven 500. |
| 10 | Ubicaciones (estados/ciudades/municipios) | ✅ Hermoso | API jerárquica bien hecha. |
| 11 | CSRF / Seguridad | ⚠️ Tiene dos sistemas peleándose | Hay un `csrf.js` y un `csrf_helper.js`, también dos endpoints. Hay que dejar solo uno. |

---

## 2. Los errores reales (no son tantos, te lo prometo) 🩹

Los enumero como si fueran lunares, no como si fuera una enfermedad:

### Críticos (3) — hay que arreglarlos esta semana
1. **Falta `controlador/RecetaController.php`** → 8 rutas devuelven HTTP 500. La buena noticia: el modelo ya existe y hay una versión vieja en `controlador/antiguos/RecetaController.php` para inspirarse.
2. **Falta `controlador/AsistenteController.php`** → 5 rutas devuelven HTTP 500. Misma historia: el modelo `Asistente.php` ya está listo.
3. **`get_hash.php` expuesto en la raíz** → genera el hash de la contraseña "123456" visible para cualquiera que abra esa URL. Hay que borrarlo del repo.

### Altos (5) — esta quincena
4. **`display_errors = 1` y `error_reporting(E_ALL)`** en `index.php` línea 11-12 → en producción muestra errores PHP completos al usuario. Debe depender de un `APP_ENV`.
5. **Credenciales de BD hardcodeadas** en `modelo/Conexion.php`: usuario `root`, contraseña vacía. Mover a variables de entorno.
6. **Doble sistema CSRF** (`csrf.js` + `csrf_helper.js`, `/api/csrf/token` + `/api/get_csrf_token.php`). Quedarse con uno solo.
7. **No hay `session_regenerate_id(true)`** después del login → vulnerable a *session fixation*.
8. **Cookies de sesión sin `httpOnly` ni `secure`** → defaults de PHP.

### Medios (4) — el mes que viene
9. **Antipatrón "una tabla por rol"**: 4 tablas `registro_*` + 4 `login_*` casi idénticas. Una sola tabla `usuarios` + `credenciales` con campo `rol` simplifica todo.
10. **`tipo_paciente` clasifica a todos los roles** (no solo pacientes). Hay que renombrarla a `tipo_usuario` para que el nombre no engañe.
11. **Sin campos de auditoría** (`created_at`, `updated_at`, `created_by`). Para un sistema de salud esto es importante.
12. **Modelos usan `echo`** para reportar resultados (`echo 'add'`, `echo 'existe'`). Eso es mezclar capa de datos con capa de presentación. Deberían retornar `bool` o lanzar excepciones.

### Bajos (4) — cuando haya tiempo
13. **No hay `composer.json`** ni PSR-4. El autoloader actual es manual.
14. **No hay `.htaccess`** que documente el `mod_rewrite` necesario para las URLs limpias.
15. **Sin tests automatizados** (ni PHPUnit ni nada).
16. **Sin Docker / docker-compose** ni pipeline de CI/CD.

---

## 3. Cuántos módulos hay y cuántos funcionan ✨

```
Módulos totales:        11
Funcionales 100 %:       8   (73 %)
Parciales / placeholder: 2   (18 %)
Rotos:                   1   ( 9 %)
```

A nivel **rutas HTTP** (que es lo que el usuario final toca):

```
Rutas definidas: 54
Operativas:      40  (74 %)
Placeholder:      1  ( 2 %)
Rotas (HTTP 500):13  (24 %)
```

> Las 13 rutas rotas están concentradas en solo dos controladores faltantes. **Crear esos dos archivos sube la operatividad del 74 % al 98 % en un sprint corto.** ⚡

---

## 4. La nota final 💯

He revisado el sistema con cariño, capa por capa, y lo califico así:

| Categoría | Peso | Puntaje | Comentario amable |
|-----------|-----:|--------:|-------------------|
| Arquitectura (MVC + front controller + router) | 20 | **16** | Está bien pensada, casi de manual. |
| Funcionalidad de los módulos | 25 | **18** | Restan 2 controladores y subes a 24/25. |
| Seguridad | 20 | **11** | Bcrypt y CSRF bien; faltan endurecimientos. |
| Calidad de código | 15 | **9** | Hay duplicación previsible (4 logins). |
| Diseño de base de datos | 10 | **6** | Bien normalizada en geografía, redundante en usuarios. |
| Documentación | 5 | **4** | Ya tienes `docs/diagramas` activos (¡bravo!). |
| Pruebas y despliegue | 5 | **1** | Es lo que más cuesta arrancar. |

### **Calificación total: 65 / 100** 🌟

Eso significa: **"MVP sólido, listo para piloto controlado en cuanto cierres lo crítico"**.
No es "reescribir todo" — es "tres días de trabajo enfocado y mañana subes a 75".

---

## 5. Cómo acomodar el sistema, paso a pasito 🌸

### 📅 Semana 1 — Lo urgente (te subes a 75/100)
1. Copia `controlador/antiguos/RecetaController.php` a `controlador/RecetaController.php` y **adáptalo a la firma del nuevo front-controller** (clase con métodos públicos `listar`, `crear`, `editar`, `borrar`, `obtener`, `buscarPacientes`, `misRecetas`).
2. Crea `controlador/AsistenteController.php` calcando la estructura de `PacienteController.php` (la lógica de búsqueda, edición, foto y contraseña es idéntica, solo cambian los nombres de campo `_asistente`).
3. **Borra `get_hash.php`** de la raíz.
4. Edita `index.php`:
   ```php
   $env = getenv('APP_ENV') ?: 'production';
   if ($env === 'development') {
       error_reporting(E_ALL); ini_set('display_errors', 1);
   } else {
       error_reporting(0); ini_set('display_errors', 0);
   }
   ```
5. Crea `config/db.php` con `getenv('DB_HOST')`, `DB_USER`, `DB_PASS`, `DB_NAME` y úsalo desde `Conexion.php`.

### 📅 Semanas 2-3 — Seguridad seria (te subes a 83/100)
6. **Elimina `js/csrf_helper.js` y `api/get_csrf_token.php`**. Deja solo `CSRFController::getToken`.
7. En `AuthController::login`, después de un login exitoso añade:
   ```php
   session_regenerate_id(true);
   ```
8. En la inicialización de sesión:
   ```php
   session_set_cookie_params([
       'lifetime' => 0,
       'path' => '/',
       'secure' => true,
       'httponly' => true,
       'samesite' => 'Strict'
   ]);
   ```
9. Implementa de verdad `AdministradorController::listarUsuarios` con paginación.
10. Unifica los mensajes de error a "Cédula o contraseña incorrecta" siempre (sin distinguir si existe el usuario).

### 📅 Semanas 4-6 — Casa ordenada (te subes a 88/100)
11. Migración a `usuarios` (id, cedula, nombre, apellidos, rol, fecha_nacimiento…) + `credenciales` (user_id, password_hash, status, ultimo_acceso).
12. Renombra `tipo_paciente` → `tipo_usuario`.
13. Añade `created_at`, `updated_at`, `created_by` a tablas operativas (recetas, consultorios, asignaciones).
14. Refactoriza los modelos para **retornar** valores en lugar de `echo`.

### 📅 Semana 7+ — Profesional (te subes a 93/100)
15. `composer init`, mover el autoloader a PSR-4 (`namespace Biovital\\Controlador`, etc.).
16. Crea un `.htaccess`:
    ```apacheconf
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [L,QSA]
    ```
17. PHPUnit con al menos 10 tests (login OK/KO, CSRF, CRUD receta, CRUD consultorio).
18. `Dockerfile` + `docker-compose.yml` (Nginx + PHP-FPM + MySQL).
19. GitHub Actions: `lint` + `phpunit` + `build` en cada PR.

---

## 6. Reflexión final, de corazón 💖

Tu sistema **no es un desastre**, es un proyecto adolescente: ya sabe quién es, ya hace lo que prometió y solo le falta peinarse antes de la entrevista. La diferencia entre **65 y 90 puntos** no son meses de trabajo, son **decisiones ordenadas en cuatro sprints**:

> 1. Cerrar las rutas rotas. (3 días)
> 2. Endurecer seguridad. (2 semanas)
> 3. Limpiar la BD y los modelos. (3 semanas)
> 4. Profesionalizar el deploy. (2 semanas)

Si haces solo el sprint 1, ya tienes un sistema listo para **piloto interno**. Si haces los cuatro, tienes un sistema listo para **clientes reales**. Tú decides hasta dónde llegar — pero el camino está claro, marcado y al alcance. 🌟

Estoy orgullosa del trabajo que ya hicieron. Lo demás es solo cariño y constancia.

Con todo el cariño del mundo,
*tu arquitecta de cabecera* 💌

---

## 7. Anexo: dónde mirar cada cosa 🔍

| Quieres ver… | Abre… |
|---|---|
| La arquitectura general | [docs/diagramas/01-arquitectura-general.md](docs/diagramas/01-arquitectura-general.md) |
| El mapa de módulos | [docs/diagramas/02-modulos.md](docs/diagramas/02-modulos.md) |
| El modelo de datos | [docs/diagramas/03-base-datos.md](docs/diagramas/03-base-datos.md) |
| El flujo de login | [docs/diagramas/04-flujo-autenticacion.md](docs/diagramas/04-flujo-autenticacion.md) |
| Dónde se rompe Recetas | [docs/diagramas/05-flujo-receta.md](docs/diagramas/05-flujo-receta.md) |
| Calificación detallada | [docs/diagramas/06-estado-implementacion.md](docs/diagramas/06-estado-implementacion.md) |
| Roadmap de remediación | [docs/diagramas/07-plan-remediacion.md](docs/diagramas/07-plan-remediacion.md) |
| Mapa de las 54 rutas | [docs/diagramas/08-mapa-rutas.md](docs/diagramas/08-mapa-rutas.md) |
