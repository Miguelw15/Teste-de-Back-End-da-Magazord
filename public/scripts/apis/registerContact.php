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


if (preg_match('/^(.*?)\s*-\s*(\d{3}\.\d{3}\.\d{3}-\d{2})$/', $data['person'], $matches)) {
    $name = trim($matches[1]);
    $cpf = str_replace(' ', '', $matches[2]);
}


$hasPerson = $PersonManager->hasPerson(null,$name, $cpf);
$hasContact = $ContactManager->hasContact(null,$data['type'],$data['contact']);

if (!$hasContact){
    
    $newContact = $ContactManager->createContact($data['type'],$data['contact']);
    
    if($hasPerson && $data['person']!=null)
    {
        $person = $PersonManager->getPerson(null,$name,$cpf);
        $person->addContact($newContact);
        $newContact->setPerson($person);
    }
    elseif (!$hasPerson && $data['person']!=null)
    {
        echo json_encode(['message' => 'Faltando dados em Person ou dado inválido!']);
        exit();
    }

    $entityManager->persist($newContact);
    $entityManager->flush();
    echo json_encode(['message'=>'Contato registrado com sucesso!','success'=>true]);
}
else {
    echo json_encode(['message'=>'Contato já existente, tente outro!','success'=>false]);
}

