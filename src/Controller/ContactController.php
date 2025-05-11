<?php 

namespace App\Controller;

use App\Entity\Contact;

class ContactController
{
    private $entityManager;
    private $ContactsRepository;

    public function __construct()
    {
        $this->entityManager = require_once __DIR__ . '/../Services/entity-manager.php';
        $this->ContactsRepository = $this->entityManager->getRepository(Contact::class);
    }

    public function getAllContacts(): array
    {
        return $this->ContactsRepository->findAll();
    }
}