<?php
use App\Services\EntityManagerFactory;
use App\Controller\PersonController;

require_once __DIR__ . '/../../../vendor/autoload.php';

$entityManager = EntityManagerFactory::create();
$PersonManager = new PersonController($entityManager);

$name = isset($_GET['q'])? $_GET['q']: '';
$persons = $PersonManager->getPersons($name);

echo json_encode($persons);




