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
            return null;
        }
        
    }
    public function deletePerson($id): void 
    {
        try {
            $person = $this->PersonRepository->findOneBy([
                'id'=> $id,
            ]);
            $hasContact = $person->getContacts();
            if (!$hasContact->isEmpty())
            {
                forEach ($hasContact as $contact){
                    $contact->setPerson(null);
                }
            }

            $this->entityManager->remove($person);
            $this->entityManager->flush();
        }
        catch (Exception $e){
            echo 'Error: '.$e;
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
            
            return $caughtPerson ? $caughtPerson : null;
        }
        catch(Exception $e)
        {
            return null;
        }
    }
    public function getPersons($name): array|null
    {
        $personArray = [];

        $query = $this->entityManager->createQuery(
            'SELECT p FROM App\Entity\Person p WHERE LOWER(p.name) LIKE LOWER(:name)'
        )->setParameter('name', '%' . $name . '%');

        $results = $query->getResult();
        if (!empty($results)){
            foreach ($results as $person) 
            {
                $contactsArray = [];
                foreach ($person->getContacts() as $contact) 
                {
                    $contactsArray[] = [
                        'id' => $contact->getId(),
                        'type' => $contact->getType(),
                        'contact' => $contact->getContact()
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
                
            }
            return $personArray; 
        }
        else {
            return null;
        }
    }
    public function hasPerson($name, $cpf): bool|null
    {   
        try {
            $hasPerson = $this->PersonRepository->findOneBy([
                'name' => $name,
                'cpf' => $cpf,
            ]);
            return $hasPerson? true: false;
        } catch (Exception $e) {
            
            return null;
        }

    }

}