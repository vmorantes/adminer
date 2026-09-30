# Changelog

Cambios de esta instalación de Adminer, por versión de Adminer. Formato basado en
[Keep a Changelog](https://keepachangelog.com/es-ES/1.1.0/). Lo que hoy difiere de Adminer
oficial está en `documentacion/mantenimiento/parches.md`.

## [Sin publicar]

### Añadido

- Procedimiento estándar para subir de versión Adminer y lista de parches locales con marcas
  `PARCHE-LOCAL` en el código.
- Modelo de trabajo arquitecto-coder y documentación de evolución y mantenimiento.
- Publicación en el repositorio de distribución `adminer-dist` con `scripts/publicar-dist.sh`.
- `.htaccess` en `adminer-dist`: solo se sirven `index.php` y `adminer.css`.
- `scripts/descargar-adminer.sh`: descarga una versión de Adminer con sus externals y sustituye
  `core/adminer/`, avisando de los parches locales que hay que reaplicar.

### Cambiado

- El modo desarrollo se activa con `DEV_MODE=true` en `.env`, no editando `index.php`.

### Eliminado

- `core/CORE_CHANELOG.md`: su contenido pasa a `parches.md` y a este archivo.

## [5.4.2] - 2026-04-15

### Añadido

- Plugin `AdminerSqlGemini`: consultas SQL generadas con Google Gemini; clave en `.env`.
- Registro de parches al core.

### Cambiado

- Adminer 5.4.2, sin parches nuevos al core; ajustes menores en `AdminerDumpDate`,
  `AdminerLoginPasswordLess` y `AdminerSqlGemini`.

### Corregido

- `AdminerDisplayForeignKeyName`: `join` con array en PHP 8 (P-04, 2026-06-27).

## [5.3.0] - 2025-05-28

### Añadido

- Fuente de Adminer en `core/adminer/`; `adminer.php` pasa a ser su compilado.
- Parches P-01 (`permanentLogin`), P-02 (`_DEV_MODE_`) y P-03 (salida de compilación).
- `adminer-plugins.php` y plugins `DotJs`, `DumpDate`, `ForeignSystem`, `ImportFromFolder`,
  `LoginPasswordLess`, `PHPSerializedColumn`, `FillLoginForm`, entre otros.

### Cambiado

- `plugins/` pasa a `adminer-plugins/` por la API de plugins de Adminer 5.
- `LoginPasswordLess` no permite entrar sin contraseña fuera de `_DEV_MODE_` (2025-08-22).

## [4.8.1] - 2021-06-30

### Cambiado

- Adminer 4.8.1. Después: errores visibles y compatibilidad con PHP 8.0 retocando el compilado
  (2024-12-03) y edición solo en inglés (2025-01-20).

## [Inicial] - 2020-09-16

- Adminer compilado con plugins de volcado y `DisplayForeignKeyName`.
