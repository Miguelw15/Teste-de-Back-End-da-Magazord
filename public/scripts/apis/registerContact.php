<?php 

use App\Controller\ContactController;
use App\Controller\PersonController;
use App\Services\EntityManagerFactory;

header('Content-Type: application/json');

require_once __DIR__ . '/../../../vendor/autoload.php';

$rawData = file_get_contents('php://input');
$data = json_decode($rawData,true);

$entityManager = EntityManagerFactory::create();
$ContactManager = new ContactController($entityManager);
$PersonManager = new PersonController($entityManager);
$name = '';
$cpf = '';
$matches = [];

if (preg_match('/^(.*?)\s*-\s*(\d{3}\.\d{3}\.\d{3}-\d{2})$/', $data['person'], $matches )|| $data['person'] == null) {
    $name = trim($matches[1]);  
    $cpf = str_replace(' ', '', $matches[2]);
} else  {
    echo json_encode( ['message'=>'Faltando dados, ou dado invalido!']);
    exit();
}

$hasPerson = $PersonManager->hasPerson($name,$cpf);

if (isset($data['type'], $data['contact'])){

    $newContact = $ContactManager->createContact($data['type'],$data['contact']);
    
    if($hasPerson){
        $person = $PersonManager->getPerson($matches[1],$matches[2]);
        $person->addContact($newContact);
        $newContact->setPerson($person);
    }; 
    
};

$entityManager->persist($newContact);
$entityManager->flush();
echo json_encode(['message'=>$matches[1]]);