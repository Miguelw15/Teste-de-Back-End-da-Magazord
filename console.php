<?php

require_once __DIR__.'/vendor/autoload.php';
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use App\Services\EntityManagerFactory;
$entityManager = EntityManagerFactory::create();


ConsoleRunner::run(
     new SingleManagerProvider($entityManager)
);

