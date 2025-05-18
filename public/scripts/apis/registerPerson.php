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

if ($newPerson){
    echo json_encode([
        'sucess'=>true,
        'message'=>'Pessoa criada com sucesso.',
        'id'=>$newPerson->getId(),
    ]);
}
else {
    echo json_encode([
        'sucess'=>false,
        'message'=> 'Pessoa já existe!',
    ]);
}



