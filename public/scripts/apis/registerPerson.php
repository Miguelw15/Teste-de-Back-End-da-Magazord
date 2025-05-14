<?php
use App\Controller\PersonController;
use App\Services\EntityManagerFactory;

header('Content-Type: application/json');

require_once __DIR__ . '/../../../vendor/autoload.php';

$entityManager = EntityManagerFactory::create();
$rawData = file_get_contents('php://input');
$data = json_decode($rawData,true);

$PersonManager = new PersonController($entityManager);

$newPerson = $PersonManager->createPerson($data['name'],$data['cpf'],$data['gender']);


echo json_encode(['message'=>'sucesso menino, voa, que Deus seja louvado']);



