<?php

require_once 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$isDevMode = true;
$paths = ["/src/models"];

$dbParams = [
    'driver'    =>  $_ENV['DB_DRIVER'],
    'user'      =>  $_ENV['DB_USER'],
    'password'  =>  $_ENV['DB_PASSWORD'],
    'dbname'    =>  $_ENV['DB_NAME'],
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths,$isDevMode);
$conn = DriverManager::getConnection($dbParams,$config);

$entityManager = new EntityManager($con,$config);

