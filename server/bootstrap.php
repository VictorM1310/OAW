<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(
  array(__DIR__ . "/src"),
  $isDevMode,
  $proxyDir,
  $cache,
  $useSimpleAnnotationReader
);

// database configuration parameters
$conn = array(
  'driver' => 'pdo_mysql',
  'dbname' => $_ENV['DATABASE'],
  'user' => $_ENV['USER'],
  'password' => $_ENV['PASSWORD'],
  'host' => $_ENV['HOST'],
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);