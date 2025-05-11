<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../','.env');
$dotenv->load();
$isDevMode = true;
$paths = ["src/Entity"];

$dbParams = [
    'driver'    =>  $_ENV['DB_DRIVER'],
    'user'      =>  $_ENV['DB_USER'],
    'password'  =>  $_ENV['DB_PASSWORD'],
    'dbname'    =>  $_ENV['DB_NAME'],
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths,$isDevMode);
$conn = DriverManager::getConnection($dbParams,$config);

return $entityManager = new EntityManager($conn,$config);

