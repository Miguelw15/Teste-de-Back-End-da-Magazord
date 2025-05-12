<?php 

namespace App\Controller;

use App\Entity\Person;

use Doctrine\ORM\EntityManagerInterface;

class PersonController
{   
    private $entityManager;
    private $PersonRepository;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->PersonRepository = $this->entityManager->getRepository(Person::class); 
    }
    public function createPerson($name,$cpf,$gender)
    {
        $newPerson = new Person($name,$cpf,$gender);
        $this->entityManager->persist($newPerson);
        $this->entityManager->flush();

    }
    public function getAllPersons():    array
    {
        $personArray = [];
        foreach($this->PersonRepository->findAll() as $person){
            $personArray[]= [
                'id' =>$person->getId(),
                'name'=>$person->getName(),
                'cpf'=>$person->getCPF(),
                'gender'=>$person->getGender(),
                'contacts'=>$person->getContacts()
            ];
        };

        return $personArray;    
    }
    public function getPerson($name) {
        $personArray = [];

        $query = $this->entityManager->createQuery(
            'SELECT p FROM App\Entity\Person p WHERE LOWER(p.name) LIKE LOWER(:name)'
        )->setParameter('name', '%' . $name . '%');

        $results = $query->getResult();

       foreach ($results as $person) {
        
        $contactsArray = [];
        foreach ($person->getContacts() as $contact) {
            $contactsArray[] = [
                'id' => $contact->getId(),
                'type' => $contact->getType(),
                'content' => $contact->getContent()
            ];
        }

        $personArray[] = [
            'id' => $person->getId(),
            'name' => $person->getName(),
            'cpf' => $person->getCPF(),
            'gender' => $person->getGender(),
            'contacts' => $contactsArray // Agora contatos são um array com os dados necessários
        ];
    }

        return $personArray;
}

}