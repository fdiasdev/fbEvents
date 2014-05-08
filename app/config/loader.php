<?php

$loader = new \Phalcon\Loader();

$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir
    )
);

$loader->registerNamespaces([
    'Ingresse' => __DIR__ . '/../../src/Ingresse/',
    'Facebook' => __DIR__ . '/../../vendor/facebook/php-sdk-v4/src/Facebook/',
]);

$loader->register();
