<?php

require_once 'autoload.php';

use PiecesPHP\Core\Database\Export\Exporter;
use PiecesPHP\Core\Database\Export\Plugins\SqlFormat;
use PiecesPHP\Core\Database\Export\Plugins\JsonFormat;
use PiecesPHP\Core\Database\Export\Plugins\CsvFormat;
use PiecesPHP\Core\Database\Export\Plugins\FileOutput;

// Configuración DB entorno
$database = 'pcs_databases';
$username = 'admin';
$password = '';
$host = '127.0.0.1';

try {
    $dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "--- Configurando datos de prueba ---\n";
    $pdo->exec("DROP TABLE IF EXISTS test_pro_features");
    $pdo->exec("CREATE TABLE test_pro_features (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50),
        email VARCHAR(100),
        bio TEXT,
        avatar_blob BLOB,
        secret_key VARCHAR(50)
    )");

    $binaryData = "\x89PNG\r\n\x1a\n\x00\x00\x00\rIHDR\x00\x00\x00\x01"; // Cabecera PNG 1x1
    $stmt = $pdo->prepare("INSERT INTO test_pro_features (username, email, bio, avatar_blob, secret_key) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['pedro', 'pedro@real.com', 'Hola mundo', $binaryData, 'S3CR3T_K3Y_1']);
    $stmt->execute(['juan', 'juan@hidden.com', 'Omitir esta fila', 'no_image', 'S3CR3T_K3Y_2']);

    echo "--- Ejecutando exportación PRO ---\n";
    $exporter = new Exporter($pdo, $database);
    
    $outputDir = __DIR__ . '/output/pro_test/';
    if (!is_dir($outputDir)) mkdir($outputDir, 0777, true);

    $options = [
        'tables' => ['test_pro_features'],
        'filename' => $outputDir . 'test.sql',
        'where' => [
            'test_pro_features' => 'username = "pedro"' // Solo pedro
        ],
        'transformations' => [
            'test_pro_features' => [
                'email' => function($val) { return "HIDDEN_EMAIL"; },
                'secret_key' => function($val) { return "********"; }
            ]
        ],
        'hex_blob' => true,
    ];

    // Prueba SQL
    $exporter->setFormatPlugin(new SqlFormat());
    $exporter->setOutputPlugin(new FileOutput());
    $exporter->export($options);
    echo "SQL generado: " . $outputDir . "test.sql\n";

    // Prueba JSON
    $options['filename'] = $outputDir . 'test.json';
    $exporter->setFormatPlugin(new JsonFormat());
    $exporter->export($options);
    echo "JSON generado: " . $outputDir . "test.json\n";

    // Prueba CSV
    $options['filename'] = $outputDir . 'test.csv';
    $exporter->setFormatPlugin(new CsvFormat());
    $exporter->export($options);
    echo "CSV generado: " . $outputDir . "test.csv\n";

    echo "\n--- Resultados de Verificación ---\n";
    
    $sqlContent = file_get_contents($outputDir . 'test.sql');
    if (strpos($sqlContent, "0x89504e47") !== false) {
        echo "[OK] Hex-Blob detectado correctamente en SQL.\n";
    } else {
        echo "[ERROR] Hex-Blob no encontrado en SQL.\n";
    }

    if (strpos($sqlContent, "HIDDEN_EMAIL") !== false && strpos($sqlContent, "********") !== false) {
        echo "[OK] Transformaciones (GDPR) aplicadas correctamente.\n";
    }

    $jsonContent = file_get_contents($outputDir . 'test.json');
    $jsonData = json_decode($jsonContent, true);
    if (count($jsonData['test_pro_features']) === 1) {
        echo "[OK] Filtro WHERE aplicado correctamente (1 fila).\n";
    } else {
        echo "[ERROR] Filtro WHERE falló en JSON.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
