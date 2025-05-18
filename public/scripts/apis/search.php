<?php
header('Content-Type: application/json');

use App\Services\EntityManagerFactory;
use App\Controller\PersonController;
use App\Controller\ContactController;

require_once __DIR__ . '/../../../vendor/autoload.php';

$entityManager = EntityManagerFactory::create();
$PersonManager = new PersonController($entityManager);
$ContactManager = new ContactController($entityManager);

$class = isset($_GET['class'])? $_GET['class']: '';
$search = isset($_GET['search'])? $_GET['search']: '';

if ($class==='Person'){
    $persons = $PersonManager->getPersons($search);
    echo json_encode($persons??[]);
}
elseif ($class==='Contact'){
    $contacts = $ContactManager->getContacts($search);
    echo json_encode($contacts??[]);
}
else {
    echo json_encode(value: ['message'=>'invalid class.']);
}


