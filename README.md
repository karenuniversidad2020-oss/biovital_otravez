<div align="center">

# BioVital

**Sistema de Gestión Clínica Multi-Rol**

*Plataforma web para la administración integral de pacientes, médicos, asistentes, consultorios y recetas médicas.*

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![PHP](https://img.shields.io/badge/PHP-%3E=7.4-777BB4.svg?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1.svg?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Status](https://img.shields.io/badge/status-MVP%20avanzado-orange.svg)](#estado-del-proyecto)
[![Free Software](https://img.shields.io/badge/Free%20Software-GNU%20Compliant-A42E2B.svg)](https://www.gnu.org/philosophy/free-sw.html)

</div>

---

## Tabla de contenidos

1. [Acerca del proyecto](#1-acerca-del-proyecto)
2. [Stack tecnológico](#2-stack-tecnológico)
3. [Arquitectura](#3-arquitectura)
4. [Estructura del repositorio](#4-estructura-del-repositorio)
5. [Roles y módulos funcionales](#5-roles-y-módulos-funcionales)
6. [Protocolos y estándares](#6-protocolos-y-estándares)
7. [Requisitos del entorno](#7-requisitos-del-entorno)
8. [Instalación y despliegue](#8-instalación-y-despliegue)
9. [Seguridad](#9-seguridad)
10. [API y enrutamiento](#10-api-y-enrutamiento)
11. [Estado del proyecto](#11-estado-del-proyecto)
12. [Documentación interna](#12-documentación-interna)
13. [Contribuciones](#13-contribuciones)
14. [Colaboradores](#14-colaboradores)
15. [Aviso de software libre y licencia](#15-aviso-de-software-libre-y-licencia)
16. [Exclusión de garantía](#16-exclusión-de-garantía)
17. [Contacto](#17-contacto)

---

## 1. Acerca del proyecto

**BioVital** es un sistema web orientado a la gestión clínica de pequeña y mediana escala, diseñado bajo el patrón **MVC** con un **Front Controller** y un mapa centralizado de rutas. Provee autenticación segmentada por rol, gestión de consultorios y horarios, emisión y consulta de recetas, gestión jerárquica de ubicaciones geográficas y administración de usuarios.

El proyecto sigue la filosofía del **software libre** definida por la Free Software Foundation: cualquier persona puede ejecutar, estudiar, modificar y redistribuir el código bajo los términos de la licencia [GPLv3](#15-aviso-de-software-libre-y-licencia).

### Objetivos

- Ofrecer una base mantenible y auditable para sistemas clínicos comunitarios.
- Servir como referencia educativa de arquitectura MVC en PHP sin frameworks pesados.
- Respetar los principios del software libre (libertades 0, 1, 2 y 3 de la GNU).

---

## 2. Stack tecnológico

### Lenguajes

| Lenguaje | Versión recomendada | Uso |
|---|---|---|
| **PHP** | ≥ 7.4 (probado en 8.x) | Lógica de aplicación, controladores, modelos. |
| **SQL (MySQL dialect)** | MySQL 5.7+ / 8.x | Persistencia de datos vía PDO. |
| **JavaScript (ES6+)** | — | Interactividad, validación de formularios, AJAX. |
| **HTML5** | — | Capa de presentación. |
| **CSS3** | — | Estilos y temas. |
| **Apache Config** | `.htaccess` | Reescritura de URLs (`mod_rewrite`). |

### Bibliotecas y dependencias frontend

| Biblioteca | Versión | Origen | Propósito |
|---|---|---|---|
| Bootstrap | 4.5.2 | CDN (jsdelivr / bootstrapcdn) | Sistema de rejilla y componentes UI. |
| jQuery | 3.x | Local (`js/jquery.min.js`) | Manipulación del DOM y AJAX. |
| AdminLTE | 3.x | Local (`js/adminlte.min.js`) | Plantilla de panel administrativo. |
| Font Awesome | 6.4.0 | CDN cloudflare | Iconografía vectorial. |
| Google Fonts | — | CDN googleapis | Tipografías Inter, Plus Jakarta Sans, Source Sans Pro. |

### Bibliotecas backend

| Componente | Implementación |
|---|---|
| Acceso a datos | **PDO** (extensión nativa de PHP) con sentencias preparadas. |
| Hash de contraseñas | **bcrypt** vía `password_hash()` / `password_verify()`. |
| Tokens CSRF | `random_bytes(32)` + `hash_equals()` en `modelo/Security.php`. |
| Autoloader | `spl_autoload_register` mapeado en `index.php`. |

---

## 3. Arquitectura

BioVital adopta una arquitectura **Modelo–Vista–Controlador (MVC)** clásica con un **Front Controller** único (`index.php`) que delega en una tabla centralizada de rutas (`config/routes.php`).

```
                    ┌─────────────────────────────┐
                    │   Navegador / Cliente HTTP  │
                    └──────────────┬──────────────┘
                                   │ HTTP(S) / AJAX-JSON
                                   ▼
                    ┌─────────────────────────────┐
                    │   Apache + mod_rewrite       │
                    │   .htaccess → index.php      │
                    └──────────────┬──────────────┘
                                   ▼
                    ┌─────────────────────────────┐
                    │   Front Controller (PHP)     │
                    │   - Autoloader               │
                    │   - Router                   │
                    │   - Middleware (auth/rol)    │
                    └──┬──────────┬───────────┬───┘
                       ▼          ▼           ▼
                  Controladores  Modelos   Vistas (PHP)
                                   │
                                   ▼
                              PDO → MySQL
```

Diagrama detallado en [`docs/diagramas/01-arquitectura-general.md`](docs/diagramas/01-arquitectura-general.md).

---

## 4. Estructura del repositorio

```
biovital_otravez/
├── api/                    # Endpoints auxiliares (CSRF token)
├── config/
│   ├── app.php             # Constantes globales (APP_NAME, APP_URL, etc.)
│   └── routes.php          # Tabla centralizada de rutas
├── controlador/            # Capa de controladores (MVC)
│   └── antiguos/           # Versiones obsoletas conservadas como referencia
├── modelo/                 # Capa de modelos + Conexion PDO + Security
├── vista/                  # Plantillas PHP segmentadas por rol
│   ├── layouts/            # base / header / footer / nav
│   ├── paciente/
│   ├── medico/
│   ├── asistente/
│   ├── administrador/
│   └── errors/
├── css/                    # Hojas de estilo locales + AdminLTE
├── js/                     # Scripts cliente (jQuery, AdminLTE, módulos)
├── img/                    # Recursos gráficos y avatares
├── docs/diagramas/         # Diagramas Mermaid de arquitectura
├── consuelo.md             # Informe técnico de estado
├── diagramas.md            # Índice general de diagramas
├── index.php               # Front Controller
└── README.md               # (este archivo)
```

---

## 5. Roles y módulos funcionales

El sistema reconoce **cuatro roles** con vistas y permisos diferenciados:

| Rol | Capacidades principales |
|---|---|
| **Paciente** | Registro, login, gestión de perfil, consulta de recetas propias y estadísticas. |
| **Médico** | Registro, login, listado de pacientes, emisión/edición/borrado de recetas, estadísticas. |
| **Asistente** | Apoyo operativo, búsqueda de pacientes, soporte a recetas. |
| **Administrador** | Gestión de usuarios, consultorios, horarios y asignación de médicos. |

### Módulos

| Módulo | Estado | Descripción |
|---|---|---|
| Autenticación | Operativo | Login por rol, logout, sesiones PHP. |
| Registro | Operativo | Alta de los 4 tipos de usuario con CSRF. |
| Perfil | Operativo | Edición de datos comunes, foto y contraseña. |
| Consultorios | Operativo | CRUD, asignación de médicos, horarios y estadísticas. |
| Ubicaciones | Operativo | API jerárquica: estados → ciudades → municipios → parroquias. |
| Recetas | Parcial | Modelo presente; controlador en implementación. |
| Asistente (endpoints) | Parcial | Vistas operativas; endpoints internos en implementación. |
| CSRF | En consolidación | Coexisten dos rutas equivalentes (ver [§9](#9-seguridad)). |

> Para detalle cuantitativo (porcentajes de rutas operativas, hallazgos críticos y plan de remediación) consultar [`consuelo.md`](consuelo.md).

---

## 6. Protocolos y estándares

| Categoría | Protocolo / estándar |
|---|---|
| Transporte | **HTTP/1.1**, **HTTPS** (TLS recomendado en producción). |
| Comunicación asíncrona | **AJAX** (cabecera `X-Requested-With: XMLHttpRequest`). |
| Formato de intercambio | **JSON** (`application/json`) para respuestas de API. |
| Sesión | Cookies de sesión PHP (`PHPSESSID`). |
| Autorización | Middleware por rol en `index.php` (`auth` / `rol` en `routes.php`). |
| Seguridad | **CSRF tokens**, **bcrypt** (RFC nativo PHP), **PDO prepared statements** (anti-SQLi). |
| Codificación | **UTF-8** extremo a extremo. |
| Persistencia | **SQL ANSI** sobre **MySQL** (driver `pdo_mysql`). |
| Convenciones | **MVC**, **PSR-12** (en proceso), **Front Controller**, **REST-like** routing. |

---

## 7. Requisitos del entorno

### Software

- **PHP ≥ 7.4** con extensiones: `pdo_mysql`, `mbstring`, `json`, `session`, `openssl`.
- **MySQL 5.7+** o **MariaDB 10.4+**.
- **Apache 2.4+** con `mod_rewrite` habilitado (o Nginx con reglas equivalentes).
- Navegador moderno con soporte para ES6 (Chrome ≥ 90, Firefox ≥ 88, Edge ≥ 90).

### Recursos mínimos sugeridos

| Recurso | Mínimo | Recomendado |
|---|---|---|
| CPU | 1 vCPU | 2 vCPU |
| RAM | 1 GB | 2 GB |
| Disco | 500 MB | 2 GB |

---

## 8. Instalación y despliegue

### 8.1 Clonar el repositorio

```bash
git clone <url-del-repositorio> biovital
cd biovital/biovital_otravez
```

### 8.2 Importar la base de datos

```bash
mysql -u root -p -e "CREATE DATABASE biovital CHARACTER SET utf8 COLLATE utf8_general_ci;"
mysql -u root -p biovital < ruta/al/dump.sql
```

### 8.3 Configurar la conexión

Editar [`modelo/Conexion.php`](modelo/Conexion.php) con las credenciales locales. **Para producción**, externalizar las credenciales mediante variables de entorno (ver [§9](#9-seguridad)).

### 8.4 Servir la aplicación

Con el servidor embebido de PHP (solo desarrollo):

```bash
php -S localhost:8080
```

Con Apache, asegúrese de que el `DocumentRoot` apunte a `biovital_otravez/` y que `.htaccess` contenga:

```apacheconf
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [L,QSA]
```

### 8.5 Acceder

Abrir en el navegador:

```
http://localhost:8080/
```

---

## 9. Seguridad

### Mecanismos implementados

- **Hash de contraseñas con bcrypt** (`password_hash` con cost adaptativo).
- **Tokens CSRF** generados con `random_bytes(32)` y verificados con `hash_equals` (comparación en tiempo constante).
- **Sentencias preparadas** mediante PDO en todos los modelos para prevenir **SQL injection**.
- **Verificación de rol** centralizada en el Front Controller mediante el campo `rol` de la tabla de rutas.
- **Distinción explícita entre rutas autenticadas y públicas** (`auth: true|false`).

### Endurecimiento pendiente para producción

> Los siguientes ajustes son **obligatorios** antes de exponer el sistema a Internet:

1. Desactivar `display_errors` y reducir `error_reporting` según `APP_ENV`.
2. Externalizar credenciales de base de datos a variables de entorno (no en repositorio).
3. Eliminar `get_hash.php` del *document root*.
4. Aplicar `session_regenerate_id(true)` tras login exitoso.
5. Configurar cookies de sesión con `Secure`, `HttpOnly` y `SameSite=Strict`.
6. Consolidar la implementación CSRF en un único endpoint (`/api/csrf/token`).
7. Forzar HTTPS mediante redirección 301 + cabecera HSTS.

Análisis detallado en [`consuelo.md` §5](consuelo.md).

---

## 10. API y enrutamiento

Todas las rutas se declaran en [`config/routes.php`](config/routes.php). Ejemplo de definición:

```php
'api/recetas/listar' => [
    'controller' => 'RecetaController',
    'action'     => 'listar',
    'method'     => 'POST',
    'rol'        => ['medico', 'asistente'],
],
```

### Convenciones

- Las rutas que comienzan con `api/` devuelven **JSON**.
- Las rutas restantes renderizan **vistas PHP**.
- El método HTTP se valida explícitamente (`405 Method Not Allowed` si no coincide).
- El acceso se restringe vía `auth: true` y/o `rol: '<rol>'`.

Mapa completo de rutas: [`docs/diagramas/08-mapa-rutas.md`](docs/diagramas/08-mapa-rutas.md).

---

## 11. Estado del proyecto

**Versión actual:** `1.0.0` (MVP avanzado).

| Indicador | Valor |
|---|---|
| Módulos totales | 11 |
| Módulos operativos | 8 (≈ 73 %) |
| Rutas HTTP definidas | 54 |
| Rutas operativas | ≈ 74 % |
| Calificación técnica interna | **65 / 100** |

Lectura recomendada: [`consuelo.md`](consuelo.md) y [`docs/diagramas/06-estado-implementacion.md`](docs/diagramas/06-estado-implementacion.md).

---

## 12. Documentación interna

| Documento | Propósito |
|---|---|
| [`docs/diagramas/01-arquitectura-general.md`](docs/diagramas/01-arquitectura-general.md) | Vista de alto nivel del sistema. |
| [`docs/diagramas/02-modulos.md`](docs/diagramas/02-modulos.md) | Mapa funcional de módulos. |
| [`docs/diagramas/03-base-datos.md`](docs/diagramas/03-base-datos.md) | Modelo entidad-relación. |
| [`docs/diagramas/04-flujo-autenticacion.md`](docs/diagramas/04-flujo-autenticacion.md) | Flujo de autenticación. |
| [`docs/diagramas/05-flujo-receta.md`](docs/diagramas/05-flujo-receta.md) | Flujo del módulo de recetas. |
| [`docs/diagramas/06-estado-implementacion.md`](docs/diagramas/06-estado-implementacion.md) | Estado de implementación. |
| [`docs/diagramas/07-plan-remediacion.md`](docs/diagramas/07-plan-remediacion.md) | Roadmap de remediación. |
| [`docs/diagramas/08-mapa-rutas.md`](docs/diagramas/08-mapa-rutas.md) | Mapa completo de rutas. |
| [`consuelo.md`](consuelo.md) | Informe técnico ejecutivo. |

---

## 13. Contribuciones

Las contribuciones son bienvenidas bajo los términos del software libre. Antes de abrir un *pull request*, por favor:

1. Abrir un **issue** describiendo el cambio propuesto.
2. Mantener el estilo del código existente (indentación de 4 espacios, nombres en español coherentes con el dominio).
3. No introducir credenciales, claves ni datos personales reales.
4. Acompañar cambios funcionales con su correspondiente actualización de documentación.
5. Firmar los *commits* con su nombre real y correo válido (`git commit -s`).

Al contribuir, usted acepta que su aporte se distribuya bajo la misma licencia del proyecto (**GPLv3**).

---

## 14. Colaboradores

Personas que han contribuido al desarrollo de BioVital:

| Nombre | Rol | Contacto |
|---|---|---|
| **Karen** | Desarrollo inicial y diseño funcional | karenuniversidad2020@gmail.com |
| **Oswaldo José Anzola Gutiérrez** | Arquitectura, diagramas y documentación técnica | rapanuti@gmail.com |

> La lista se mantiene sincronizada con el historial de `git log`. Para aparecer aquí, basta con realizar un *commit* aceptado en la rama principal.

---

## 15. Aviso de software libre y licencia

```
BioVital — Sistema de Gestión Clínica Multi-Rol
Copyright (C) 2025-2026  Karen y Oswaldo José Anzola Gutiérrez

Este programa es software libre: usted puede redistribuirlo y/o
modificarlo bajo los términos de la Licencia Pública General GNU
publicada por la Free Software Foundation, ya sea la versión 3 de
la Licencia, o (a su elección) cualquier versión posterior.

Este programa se distribuye con la esperanza de que sea útil,
pero SIN NINGUNA GARANTÍA; ni siquiera la garantía implícita de
COMERCIABILIDAD o IDONEIDAD PARA UN PROPÓSITO PARTICULAR.
Consulte la Licencia Pública General GNU para más detalles.

Usted debería haber recibido una copia de la Licencia Pública
General GNU junto con este programa. Si no es así, vea
<https://www.gnu.org/licenses/>.
```

**Licencia:** [GNU General Public License v3.0 o posterior (GPL-3.0-or-later)](https://www.gnu.org/licenses/gpl-3.0.html).

Este programa respeta y promueve las cuatro libertades esenciales del software libre:

- **Libertad 0:** ejecutar el programa para cualquier propósito.
- **Libertad 1:** estudiar cómo funciona el programa y modificarlo.
- **Libertad 2:** redistribuir copias.
- **Libertad 3:** distribuir copias de sus versiones modificadas.

> Se recomienda incluir el archivo `LICENSE` con el texto completo de la GPLv3 en la raíz del repositorio. Puede obtenerse desde: <https://www.gnu.org/licenses/gpl-3.0.txt>.

### Bibliotecas de terceros

| Biblioteca | Licencia |
|---|---|
| Bootstrap 4.5.2 | MIT |
| jQuery | MIT |
| AdminLTE 3 | MIT |
| Font Awesome 6 (Free) | CC BY 4.0 / SIL OFL 1.1 / MIT |

Todas las licencias mencionadas son compatibles con la redistribución bajo GPLv3.

---

## 16. Exclusión de garantía

> **AVISO IMPORTANTE.** BioVital se entrega **"TAL CUAL"**, sin garantía de ningún tipo, expresa o implícita, incluyendo —pero no limitándose a— garantías de comerciabilidad, idoneidad para un propósito particular y no infracción. En ningún caso los autores o titulares del *copyright* serán responsables por reclamación, daño u otra responsabilidad, ya sea en una acción contractual, agravio o de otro tipo, derivada de, fuera de, o en conexión con el software o el uso u otros tratos en el software.
>
> Este sistema **no debe ser utilizado como única fuente para decisiones clínicas críticas** sin la supervisión de personal médico calificado. El usuario asume toda responsabilidad por su despliegue en entornos productivos.

---

## 17. Contacto

Para reportes de errores, propuestas de mejora o preguntas técnicas:

- **Issues:** abrir un *issue* en el repositorio.
- **Correo principal:** rapanuti@gmail.com
- **Correo secundario:** karenuniversidad2020@gmail.com

---

<div align="center">

*Hecho con software libre, para software libre.*

**`GPLv3 · 2025-2026`**

</div>
