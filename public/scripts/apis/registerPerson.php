<?php
use App\Controller\PersonController;
use App\Services\EntityManagerFactory;

header('Content-Type: application/json');

require_once __DIR__ . '/../../../vendor/autoload.php';

$entityManager = EntityManagerFactory::create();
$rawData = file_get_contents('php://input');
$data = json_decode($rawData,true);

$PersonManager = new PersonController($entityManager);

$cpfExists = $PersonManager->getPerson(null,null,$data['cpf']); 

if ($data['name']===''){
    echo json_encode(['success'=>false,'message'=>'Nome inválido.',]);
    exit();
}

if (!$cpfExists && $data['cpf']!==''){
    if ($data['gender']!==''){
        $newPerson = $PersonManager->createPerson($data['name'],$data['cpf'],$data['gender']);
        echo json_encode(['success'=>true,'message'=>'Pessoa criada com sucesso.',]);
        exit();
    } 
    else {
        echo json_encode(value: ['success'=>false,'message'=>'Selecione um gênero.',]);
        exit();
    }
}
if ($data['cpf']===''){
    echo json_encode(['success'=>false,'message'=>'Insira um CPF válido.',]);
    exit();
}


    




