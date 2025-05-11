<?php

require_once 'vendor/autoload.php';
$entityManager = require_once 'src/Services/EntityService.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

ConsoleRunner::run(
     new SingleManagerProvider($entityManager)
);

