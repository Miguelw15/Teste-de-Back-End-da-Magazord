<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../vendor/autoload.php';
$entityManager = require_once __DIR__ . '/../../src/Services/entity-manager.php';

use App\Controller\PersonController;
use App\Entity\Person;

$PersonManager = new PersonController($entityManager);
$name = isset($_GET['q'])? $_GET['q'] : '';
$persons = $PersonManager->getPerson($name);




echo json_encode($persons);




