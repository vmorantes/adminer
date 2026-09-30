# Adminer

Instalación de [Adminer](https://www.adminer.org) 5.4.2 con plugins: volcados en varios
formatos, nombres de claves foráneas, importación desde carpeta, columnas PHP serializadas y
un asistente SQL con Google Gemini.

## Instalación

1. Clonar en una carpeta servida por PHP 8.1 o superior.
2. Para el asistente SQL: copiar `.env.example` a `.env` y poner `GEMINI_API_KEY`. El
   asistente envía a Google la estructura de la base (no los datos).
3. Abrir `index.php`.

Los plugins activos se configuran en `adminer-plugins.php`. Este repositorio se genera desde
otro; los cambios hechos aquí a mano se pierden en la siguiente publicación.
