# Adminer

Instalación de [Adminer](https://www.adminer.org) 5.4.2 con plugins: volcados en varios
formatos, nombres de claves foráneas, importación desde carpeta, columnas PHP serializadas y
un asistente SQL con Google Gemini.

## Instalación

1. Clonar en una carpeta servida por PHP 8.1 o superior.
2. Copiar `.env.example` a `.env`. `DEV_MODE` va en `false` en un servidor. Para el asistente
   SQL, `GEMINI_API_KEY`; el asistente envía a Google la estructura de la base (no los datos).
3. Abrir `index.php`.

Pensado para Apache: el `.htaccess` solo deja servir `index.php` y `adminer.css` (requiere
`AllowOverride` con `AuthConfig`, `Options`, `FileInfo` e `Indexes`). Con otro servidor, hay que
configurar lo mismo en él.

Los plugins activos se configuran en `adminer-plugins.php`. Este repositorio se genera desde
otro; los cambios hechos aquí a mano se pierden en la siguiente publicación.
