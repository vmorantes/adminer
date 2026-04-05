<?php

require_once 'autoload.php';

use PiecesPHP\Core\Database\Export\Enums\DataStyle;
use PiecesPHP\Core\Database\Export\Enums\TableStyle;
use PiecesPHP\Core\Database\Export\Exporter;
use PiecesPHP\Core\Database\Export\Plugins\Bz2FileOutput;
use PiecesPHP\Core\Database\Export\Plugins\CsvFormat;
use PiecesPHP\Core\Database\Export\Plugins\FileOutput;
use PiecesPHP\Core\Database\Export\Plugins\GzipFileOutput;
use PiecesPHP\Core\Database\Export\Plugins\JsonFormat;
use PiecesPHP\Core\Database\Export\Plugins\PhpFormat;
use PiecesPHP\Core\Database\Export\Plugins\SqlFormat;
use PiecesPHP\Core\Database\Export\Plugins\XmlFormat;
use PiecesPHP\Core\Database\Export\Plugins\ZipFileOutput;

// Configuración
$database = 'piecesphp';
$username = "admin";
$password = '';
$host = '127.0.0.1';

try {
    // 1. Preparar PDO (Principio de Responsabilidad Única)
    $dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Instanciar el Exporter (Cerebro)
    $exporter = new Exporter($pdo, $database);

    // 3. Configuracion de casos
    $baseOptions = [
        'table_style' => TableStyle::DROP_CREATE,
        'data_style' => DataStyle::TRUNCATE_INSERT,
        'auto_increment' => false,
        'triggers' => true,
        'routines' => true,
        'drop_if_exists_on_functions' => true,
        'create_if_not_exists' => true,
    ];
    $formatCases = [
        [
            'format' => new SqlFormat(),
            'options' => array_merge($baseOptions, [
                'filename' => "{$database}.sql",
            ]),
        ],
        [
            'format' => new JsonFormat(),
            'options' => array_merge($baseOptions, [
                'filename' => "{$database}.json",
            ]),
        ],
        [
            'format' => new PhpFormat(),
            'options' => array_merge($baseOptions, [
                'filename' => "{$database}.php",
            ]),
        ],
        [
            'format' => new XmlFormat(),
            'options' => array_merge($baseOptions, [
                'filename' => "{$database}.xml",
            ]),
        ],
        [
            'format' => new CsvFormat(),
            'options' => array_merge($baseOptions, [
                'filename' => "{$database}.csv",
            ]),
        ],
    ];
    $outputCases = [
        new FileOutput(),
        new GzipFileOutput(),
        new Bz2FileOutput(),
        new ZipFileOutput(),
    ];

    // 4. Ejecutar Exportación
    $tables = $exporter->getTables();
    $outputDir = __DIR__ . '/output/';
    $mask = umask(0);
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0777, true);
    }
    umask($mask);

    foreach ($formatCases as $formatCase) {
        $filename = $formatCase['options']['filename'];
        $formatCase['options']['filename'] = $outputDir . $filename;
        $formatCase['options']['tables'] = $tables;
        $exporter->setFormatPlugin($formatCase['format']);
        foreach ($outputCases as $output) {
            $exporter->setOutputPlugin($output);
            $exporter->export($formatCase['options']);
            echo "Archivo generado: " . $output->getFilename() . "\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
