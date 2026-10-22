# Changelog

Cambios de esta instalación de Adminer. Formato basado en
[Keep a Changelog](https://keepachangelog.com/es-ES/1.1.0/). Lo que hoy difiere de Adminer
oficial está en `documentacion/mantenimiento/parches.md`.

Desde 2026-10-01, cada sección es una publicación en `adminer-dist`: `[AAAA-MM-DD]` y la versión
de Adminer publicada. La cierra `scripts/publicar-dist.sh` (ADR 0007); las anteriores van por
versión de Adminer.

## [Sin publicar]

## [2026-10-22.2] - Adminer 6.1.1

### Corregido

- `.htaccess` de `adminer-dist`: ninguna ruta dentro de una subcarpeta se sirve, aunque tenga
  `index.php` (antes las subcarpetas daban 403 solo por no tener `index.php`).

## [2026-10-22] - Adminer 6.1.1

### Corregido

- `.htaccess` de `adminer-dist`: la URL de la carpeta sin barra final (`/adminer`) daba 403 en
  lugar de redirigir a `/adminer/`.

## [2026-10-01] - Adminer 6.1.1

### Añadido

- Procedimiento estándar para subir de versión Adminer y lista de parches locales con marcas
  `PARCHE-LOCAL` en el código.
- Modelo de trabajo arquitecto-coder y documentación de evolución y mantenimiento.
- Publicación en el repositorio de distribución `adminer-dist` con `scripts/publicar-dist.sh`.
- La guarda permite a los agentes consultar el remoto oficial de Adminer (solo lectura).
- `.htaccess` en `adminer-dist`: solo se sirven `index.php` y `adminer.css`.
- `scripts/descargar-adminer.sh`: descarga una versión de Adminer con sus externals y sustituye
  `core/adminer/`, avisando de los parches locales que hay que reaplicar.
- Plugin propio `AdminerDumpSinDefiner`: opción «Omitir DEFINER» en la exportación SQL, para
  vistas, rutinas y eventos de cualquier cuenta (Adminer solo lo quita si es la cuenta conectada).

### Cambiado

- Adminer 6.1.1 (desde 5.4.2), con los parches P-01 a P-03 reaplicados y los plugins oficiales
  copiados de nuevo.
- `AdminerSqlGemini` usa `Adminer\get_url()` (muestra los errores de la petición) y el modelo
  por defecto `gemini-3.1-flash-lite`, como el oficial.

- El modo desarrollo se activa con `DEV_MODE=true` en `.env`, no editando `index.php`.

### Corregido

- P-03: `compile.php` escribía en `core/adminer../../../adminer.php`, una ruta que no existe;
  ahora escribe `adminer.php` en la raíz.

### Eliminado

- `AdminerDisplayForeignKeyName` y su parche P-04: lo sustituye `AdminerSelectForeign`,
  el oficial `select-foreign` con el parche P-05, que conserva el `[valor] descripción` (P-05) con una
  consulta por columna. En 6.1.1 daba «Attempt to read property "num_rows" on bool».

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
