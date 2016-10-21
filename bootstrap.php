<?php

// bootstrap.php

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;

require_once 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = getenv('APP_DEV');

$config = Setup::createConfiguration($isDevMode);
$driver = new AnnotationDriver(new AnnotationReader(), [__DIR__.'/src']);

// registering noop annotation autoloader - allow all annotations by default
AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);

// database configuration parameters
$conn = [
    'driver'   => getenv('DB_DRIVER'),
    'dbname'   => getenv('DB_NAME'),
    'host'     => getenv('DB_HOST'),
    'user'     => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
];

$em = EntityManager::create($conn, $config);
$qb = $em->createQueryBuilder();
