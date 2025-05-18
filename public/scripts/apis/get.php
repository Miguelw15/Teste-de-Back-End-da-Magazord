<?php
use App\Services\EntityManagerFactory;
require_once __DIR__.'/../../../vendor/autoload.php';
$entityManager = EntityManagerFactory::create();

use App\Controller\ContactController;
use App\Controller\PersonController;

$ContactManager = new ContactController($entityManager);
$PersonManager = new PersonController($entityManager);

$contactList = $ContactManager->getAllContacts();
$personList = $PersonManager->getAllPersons();

echo json_encode(['PersonList'=>$personList,'ContactList'=>$contactList]);
    
