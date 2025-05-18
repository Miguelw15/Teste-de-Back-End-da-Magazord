<?php

use App\Controller\ContactController;
use App\Controller\PersonController;
use App\Services\EntityManagerFactory;

header('Content-Type : application/json');
require_once __DIR__.'/../../../vendor/autoload.php';

$entityManager = EntityManagerFactory::create();
$PersonManager = new PersonController($entityManager);
$ContactManager = new ContactController($entityManager);

$rawData = file_get_contents('php://input');
$data = json_decode($rawData,true);

$class = $data['class'];
$id = $data['id'];

if ($class==='Contact' && $id) {
    $ContactManager->deleteContact($id);
    
}
elseif ($class==='Person' && $id) {
    $PersonManager->deletePerson($id);
}
else {
    echo json_encode(['message'=>'Error']);
    exit();
}
echo json_encode(value: ['message'=>'Sucess']);

