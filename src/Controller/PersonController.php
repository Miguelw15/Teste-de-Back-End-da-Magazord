<?php 

namespace App\Controller;

use App\Entity\Person;

class PersonController
{   
    private $entityManager;
    private $PersonRepository;

    public function __construct()
    {
        $this->entityManager = require_once __DIR__ . '/../Services/entity-manager.php';
        $this->PersonRepository = $this->entityManager->getRepository(Person::class); 
    }

    public function getAllPersons():    array
    {
        return $this->PersonRepository->findAll();
    }

    
}