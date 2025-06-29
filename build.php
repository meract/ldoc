<?php

// Проверка phar.readonly
if (ini_get('phar.readonly')) {
    die("Запустите с параметром: php -d phar.readonly=0 build-phar.php\n");
}

$pharFile = 'ldoc.phar';

// Удаление старого PHAR
if (file_exists($pharFile)) {
    unlink($pharFile);
}

try {
    $phar = new Phar($pharFile, 0, 'ldoc.phar');
    $phar->startBuffering();

    // Добавляем файлы с сохранением структуры путей
    $phar->buildFromDirectory(__DIR__, '/\.(php|json|md|lock)$/');
    
    // Отдельно добавляем бинарник, если он не попал
    if (file_exists('bin/ldoc')) {
        $phar->addFile('bin/ldoc', 'bin/ldoc');
    }

    // Создаём правильный stub
    $stub = <<<'STUB'
#!/usr/bin/env php
<?php
Phar::mapPhar('ldoc.phar');
require 'phar://ldoc.phar/bin/ldoc';
__HALT_COMPILER();
STUB;

    $phar->setStub($stub);
    $phar->stopBuffering();
    
    chmod($pharFile, 0755);
    
    echo "PHAR успешно создан: $pharFile\n";
    
    // Проверка содержимого
    echo "Содержимое PHAR:\n";
    foreach (new RecursiveIteratorIterator($phar) as $file) {
        echo $file . "\n";
    }
    
} catch (Exception $e) {
    die("Ошибка: " . $e->getMessage() . "\n");
}
