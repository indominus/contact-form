<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

include_once './vendor/autoload.php';

(new Dotenv\Dotenv(__DIR__))->load();

$paths = realpath(__DIR__ . '/src');
$connection = ['driver' => getenv('DB_DRIVER'), 'url' => getenv('DB_URL')];

$config = Setup::createAnnotationMetadataConfiguration([$paths], true);
$entityManager = EntityManager::create($connection, $config);

return ConsoleRunner::createHelperSet($entityManager);
