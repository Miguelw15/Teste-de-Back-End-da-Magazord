<?php

require_once __DIR__.'/vendor/autoload.php';
$entityManager = require_once __DIR__ .'/src/Services/entity-manager.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

ConsoleRunner::run(
     new SingleManagerProvider($entityManager)
);

