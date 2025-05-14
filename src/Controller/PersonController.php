<?php 
namespace App\Controller;
require_once __DIR__.'/../../vendor/autoload.php';

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class PersonController
{   
    private $entityManager;
    private $PersonRepository;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->PersonRepository = $this->entityManager->getRepository(Person::class); 
    }
    public function createPerson($name,$cpf,$gender): ?Person
    {
        try {
            $newPerson = new Person($name,$cpf,$gender);
            $this->entityManager->persist($newPerson);
            $this->entityManager->flush();
            return $newPerson;
        }
        catch (Exception $e)
        {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
        
    }

    public function getAllPersons(): array
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
    public function getPerson($name,$cpf): ?Person
    {
        try {
            $caughtPerson = $this->PersonRepository->findOneBy([
                'cpf'=> $cpf
            ]);
            
            return $caughtPerson;
        }
        catch(Exception $e)
        {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    public function getPersons($name,) 
    {
        $personArray = [];

        $query = $this->entityManager->createQuery(
            'SELECT p FROM App\Entity\Person p WHERE LOWER(p.name) LIKE LOWER(:name)'
        )->setParameter('name', '%' . $name . '%');

        $results = $query->getResult();

       foreach ($results as $person) 
       {
            $contactsArray = [];
            foreach ($person->getContacts() as $contact) 
            {
                $contactsArray[] = [
                    'id' => $contact->getId(),
                    'type' => $contact->getType(),
                    'content' => $contact->getContent()
                ];
            }

            $personArray[] = 
            [
                'id' => $person->getId(),
                'name' => $person->getName(),
                'cpf' => $person->getCPF(),
                'gender' => $person->getGender(),
                'contacts' => $contactsArray 
            ];
            return $personArray; 
        }
    }
    public function hasPerson($name, $cpf): bool
    {   
        try {
            $hasP = $this->PersonRepository->findOneBy([
                'name' => $name,
                'cpf' => $cpf,
            ]);
            return true;
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }

    }

}