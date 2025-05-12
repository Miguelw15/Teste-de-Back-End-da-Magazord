<?php 

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
class ContactController
{
    private $entityManager;
    private $ContactsRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {   
        $this->entityManager = $entityManager;
        $this->ContactsRepository = $this->entityManager->getRepository(Contact::class);
    }

    public function getAllContacts(): array
{
    $contactsArray = [];

    foreach ($this->ContactsRepository->findAll() as $contact) {
        $person = $contact->getPerson();

        $contactsArray[] = [
            'id' => $contact->getId(),
            'type' => $contact->getType(),
            'content' => $contact->getContent(),
            'person' => $person ? [
                'id' => $person->getId(),
                'name' => $person->getName(),
                'cpf' => $person->getCPF(),
                'gender' => $person->getGender()
            ] : null
        ];
    }

    return $contactsArray;
}
}