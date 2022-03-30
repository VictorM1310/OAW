<?php

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Model\FeedNews;
use Model\RSSFeed;
use Repository\RSSFeedRepository;
use Repository\FeedNewsRepository;

require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(
  array(__DIR__ . "/app/models"),
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

$builder = new ContainerBuilder();
$builder->addDefinitions([
  RSSFeedRepository::class => $entityManager->getRepository(RSSFeed::class),
  FeedNewsRepository::class => $entityManager->getRepository(FeedNews::class)
]);
$container = $builder->build();