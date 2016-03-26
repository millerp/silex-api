<?php
// bootstrap.php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;

$config = Setup::createConfiguration($isDevMode);
$driver = new AnnotationDriver(new AnnotationReader(), array(__DIR__ . "/src"));

// registering noop annotation autoloader - allow all annotations by default
AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'dbname' => 'silex-api',
    'host' => '192.168.10.10',
    'user' => 'homestead',
    'password' => 'secret'
);

$em = EntityManager::create($conn, $config);
$qb = $em->createQueryBuilder();