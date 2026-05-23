# Diagrama 5 — Flujo del Módulo de Recetas (estado actual: ROTO)

Recorrido completo de una receta desde la creación por el médico hasta la consulta por el paciente, **señalando dónde se rompe** hoy el flujo.

```mermaid
flowchart TD
    Start([Médico inicia sesión]) --> Panel[Panel Médico<br/>/panel/medico]
    Panel --> Menu{Acción}

    Menu -->|Ir a recetas| RouteR[/recetas/]
    RouteR --> Router{index.php<br/>resuelve ruta}
    Router -->|controller = RecetaController| LoadCtrl[Cargar<br/>controlador/RecetaController.php]

    LoadCtrl --> Check{¿Archivo<br/>existe?}
    Check -->|❌ NO existe en /controlador/| Error500[HTTP 500<br/>Archivo de controlador no encontrado]:::broken
    Check -.->|Sólo en /controlador/antiguos/| Note1[Versión obsoleta<br/>no es cargada por el router]

    Menu -->|Crear receta vía API| ApiCrear[POST /api/recetas/crear]
    ApiCrear --> Router2{index.php<br/>resuelve ruta}
    Router2 --> LoadCtrl2[Cargar RecetaController]
    LoadCtrl2 --> Check2{¿Existe?}
    Check2 -->|❌ NO| Error500b[HTTP 500]:::broken

    Note2[/Si se restaura el controlador:/]:::fix
    Note2 --> Model[modelo/Receta.php<br/>✅ existe y funcional]
    Model --> DB[(MySQL<br/>recetas)]
    DB --> Diag[Tablas relacionadas<br/>✅ diagnostico_rec<br/>✅ est_laboratorio]

    Paciente([Paciente inicia sesión]) --> PPanel[Panel Paciente]
    PPanel --> PRecetas[/paciente/recetas/]
    PRecetas --> PController[PacienteController::recetas]
    PController --> PView[Vista pac_recetas.php]
    PView --> PApi[POST /api/recetas/mis-recetas]
    PApi --> Router3{Router}
    Router3 --> CheckP{¿RecetaController<br/>existe?}
    CheckP -->|❌ NO| Error500c[HTTP 500<br/>Paciente nunca verá sus recetas]:::broken

    classDef broken fill:#ffcccc,stroke:#c62828,stroke-width:2px,color:#7f0000
    classDef fix fill:#cce5ff,stroke:#0d47a1,color:#0d47a1
```

## Endpoints afectados por la falta de `RecetaController.php`

| Ruta | Método | Rol | Estado |
|------|--------|-----|--------|
| `/recetas` | GET | médico, asistente | ❌ 500 |
| `/api/recetas/listar` | POST | médico, asistente | ❌ 500 |
| `/api/recetas/crear` | POST | médico | ❌ 500 |
| `/api/recetas/editar` | POST | médico | ❌ 500 |
| `/api/recetas/borrar` | POST | médico | ❌ 500 |
| `/api/recetas/obtener` | POST | autenticado | ❌ 500 |
| `/api/recetas/buscar-pacientes` | POST | médico, asistente | ❌ 500 |
| `/api/recetas/mis-recetas` | POST | paciente | ❌ 500 |

> 💡 El modelo `Receta.php` **sí existe y está completo**: tiene CRUD, búsqueda de pacientes, guardado de diagnóstico y estudios de laboratorio. Sólo falta el controlador que lo orqueste con las rutas.
