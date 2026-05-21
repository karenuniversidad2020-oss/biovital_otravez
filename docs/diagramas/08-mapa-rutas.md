# Diagrama 8 — Mapa Completo de Rutas y Su Estado

Las **53 rutas** definidas en `config/routes.php`, clasificadas por estado y controlador.

```mermaid
graph LR
    subgraph Publicas["🌐 Rutas Públicas (10)"]
        P1["/  •  /home"]:::ok
        P2["/login/{rol}  ×4"]:::ok
        P3["/registro/{rol}  ×4"]:::ok
        P4["/api/csrf/token"]:::ok
    end

    subgraph Auth["🔐 Autenticación (2)"]
        A1["POST /login"]:::ok
        A2["/logout"]:::ok
    end

    subgraph RegAPI["📝 Registro API (4)"]
        RA1["/api/registro/paciente"]:::ok
        RA2["/api/registro/medico"]:::ok
        RA3["/api/registro/asistente"]:::ok
        RA4["/api/registro/administrador"]:::ok
    end

    subgraph Paneles["🏠 Paneles (4)"]
        PA1["/panel/paciente"]:::ok
        PA2["/panel/medico"]:::ok
        PA3["/panel/asistente"]:::ok
        PA4["/panel/administrador"]:::ok
    end

    subgraph Perfil["👤 Perfil (5)"]
        PF1["/perfil"]:::ok
        PF2["/perfil/editar"]:::ok
        PF3["/perfil/cambiar-foto"]:::ok
        PF4["/perfil/cambiar-password"]:::ok
        PF5["/api/perfil/datos"]:::ok
    end

    subgraph Ubic["📍 Ubicación (5)"]
        U1["estados"]:::ok
        U2["ciudades"]:::ok
        U3["municipios"]:::ok
        U4["parroquias"]:::ok
        U5["especialidades"]:::ok
    end

    subgraph MedAPI["🩺 Médico API (8)"]
        MA1["/medico/pacientes"]:::ok
        MA2["buscar / capturar / editar"]:::ok
        MA3["cambiar-foto / pass"]:::ok
        MA4["mis-estadisticas"]:::ok
        MA5["listar-pacientes"]:::ok
    end

    subgraph PacAPI["🧑 Paciente API (7)"]
        PC1["buscar / capturar / editar"]:::ok
        PC2["cambiar-foto / pass"]:::ok
        PC3["mis-estadisticas"]:::ok
        PC4["/paciente/recetas (vista)"]:::ok
    end

    subgraph AdmAPI["🛡️ Administrador API (6)"]
        AD1["buscar / capturar / editar"]:::ok
        AD2["cambiar-foto / pass"]:::ok
        AD3["/administrador/usuarios"]:::warn
    end

    subgraph ConsAPI["🏥 Consultorios (15)"]
        C1["index / crear / editar / detalle / horarios"]:::ok
        C2["listar / crear / editar / eliminar"]:::ok
        C3["asignar-medico / remover-medico"]:::ok
        C4["guardar-horario / obtener-horarios"]:::ok
        C5["obtener-detalle / estadisticas"]:::ok
        C6["listar-medicos disponibles"]:::ok
    end

    subgraph AsiAPI["👩‍⚕️ Asistente API (5)"]
        AS1["buscar"]:::bad
        AS2["capturar-datos"]:::bad
        AS3["editar"]:::bad
        AS4["cambiar-foto"]:::bad
        AS5["cambiar-password"]:::bad
    end

    subgraph RecAPI["💊 Recetas (8)"]
        R1["/recetas (vista)"]:::bad
        R2["listar"]:::bad
        R3["crear / editar / borrar"]:::bad
        R4["obtener"]:::bad
        R5["buscar-pacientes"]:::bad
        R6["mis-recetas"]:::bad
    end

    classDef ok fill:#c8f7c5,stroke:#1b5e20,color:#1b5e20
    classDef warn fill:#fff3cd,stroke:#856404,color:#856404
    classDef bad fill:#ffcccc,stroke:#c62828,color:#7f0000
```

## Conteo

| Estado | Rutas | % |
|--------|-------|---|
| ✅ Operativas (verde) | 40 | **75 %** |
| ⚠️ Placeholder / parcial | 1 | 2 % |
| ❌ Devuelven HTTP 500 | 13 | **23 %** |
| **Total** | **54** | 100 % |

> El módulo de recetas y el de asistente concentran el 100 % de las rutas rotas. Cerrar esos dos controladores eleva la operatividad al **98 %** de inmediato.
