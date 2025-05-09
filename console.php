<?php

require_once 'vendor/autoload.php';
require_once 'entity-manager.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

ConsoleRunner::run(
     new SingleManagerProvider($entityManager)
);

