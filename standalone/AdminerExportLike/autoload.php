<?php

/**
 * Autoloader manual para PiecesPHP\Core\Database\Export
 * Basado en la estructura de archivos src/.
 */

$base_path = __DIR__ . '/src/';

// Interfaces
require_once $base_path . 'Interfaces/ExporterInterface.php';
require_once $base_path . 'Interfaces/FormatPluginInterface.php';
require_once $base_path . 'Interfaces/OutputPluginInterface.php';

// Core
require_once $base_path . 'Exporter.php';

// Enums
require_once $base_path . 'Enums/TableStyle.php';
require_once $base_path . 'Enums/DataStyle.php';

// Plugins
require_once $base_path . 'Plugins/SqlFormat.php';
require_once $base_path . 'Plugins/JsonFormat.php';
require_once $base_path . 'Plugins/XmlFormat.php';
require_once $base_path . 'Plugins/PhpFormat.php';
require_once $base_path . 'Plugins/FileOutput.php';
require_once $base_path . 'Plugins/GzipFileOutput.php';
require_once $base_path . 'Plugins/Bz2FileOutput.php';
require_once $base_path . 'Plugins/ZipFileOutput.php';
require_once $base_path . 'Plugins/MemoryOutput.php';
