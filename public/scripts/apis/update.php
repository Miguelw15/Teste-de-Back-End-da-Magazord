<?php

use App\Services\EntityManagerFactory;
use App\Controller\ContactController;
use App\Controller\PersonController;

require_once __DIR__ . "/../../../vendor/autoload.php";

$entityManager = EntityManagerFactory::create();
$ContactManager = new ContactController($entityManager);
$PersonManager = new PersonController($entityManager);

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

$class = $data['class'];
$id = $data['id'];

if ($class === 'Contact') {
    $name = '';
    $cpf = '';

    if (preg_match('/^(.*?)\s*-\s*(\d{3}\.\d{3}\.\d{3}-\d{2})$/', $data['person'], $matches)) {
        $name = trim($matches[1]);
        $cpf = str_replace(' ', '', $matches[2]);
    }

    $newContact = $data['contact'];
    $newPersonStr = $data['person'];

    $editingContact = $ContactManager->getContact($id, null, null);

    $contactExists = $ContactManager->hasContact(null, $data['type'], $newContact);
    $foundContact = $ContactManager->getContact(null, $data['type'], $newContact);

    if ($contactExists && $foundContact->getId() !== $editingContact->getId()) {
        echo json_encode(['message' => 'Contato já existe.', 'success' => false]);
        exit();
    }

    $hasPerson = $PersonManager->hasPerson(null, $name, $cpf);
    $person = $PersonManager->getPerson(null, $name, $cpf);

    $somethingChanged = false;

    if ($newContact !== $editingContact->getContact()) {
        $editingContact->setContact($data['type'], $newContact);
        $somethingChanged = true;
    }

    if ($newPersonStr === '') {
        if ($editingContact->getPerson() !== null) {
            $editingContact->setPerson(null);
            $somethingChanged = true;
        }
    } 
    elseif ($hasPerson) {
        if ($editingContact->getPerson() === null || $editingContact->getPerson()->getId() !== $person->getId()) {
            $editingContact->setPerson($person);
            $somethingChanged = true;
        }
    } 
    else {
        echo json_encode(['message' => 'Pessoa inválida.', 'success' => false]);
        exit();
    }

    if ($somethingChanged) {
        $entityManager->flush();
        echo json_encode(['message' => 'Contato salvo com sucesso!', 'success' => true]);
    } 
    else {
        echo json_encode(['message' => 'Nada alterado.', 'success' => false]);
    }

    exit();
} 
elseif ($class === 'Person') {

    $editingPerson = $PersonManager->getPerson($id, null, null);

    if (!$editingPerson) {
        echo json_encode(['message' => 'Pessoa não encontrada.', 'success' => false]);
        exit();
    }

    $newName = $data['name'];
    $newCpf = $data['cpf'];
    $newGender = $data['gender'];

    $cpfExists = $PersonManager->hasPerson(null, null, $newCpf);
    $foundPerson = $PersonManager->getPerson(null, null, $newCpf);

    if ($cpfExists && $foundPerson->getId() !== $editingPerson->getId()) {
        echo json_encode(['message' => 'CPF já está em uso por outra pessoa.', 'success' => false]);
        exit();
    }

    $somethingChanged = false;

    if ($newName !== $editingPerson->getName()) {
        $editingPerson->setName($newName);
        $somethingChanged = true;
    }

    if ($newCpf !== $editingPerson->getCpf()) {
        $editingPerson->setCpf($newCpf);
        $somethingChanged = true;
    }

    if ($newGender !== $editingPerson->getGender()) {
        $editingPerson->setGender($newGender);
        $somethingChanged = true;
    }

    if ($somethingChanged) {
        $entityManager->flush();
        echo json_encode(['message' => 'Pessoa atualizada com sucesso!', 'success' => true]);
    } 
    else {
        echo json_encode(['message' => 'Nada foi alterado.', 'success' => false]);
    }

    exit();

}

$entityManager->flush();
exit();