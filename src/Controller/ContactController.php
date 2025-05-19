<?php 

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
                'contact' => $contact->getContact(),
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
    public function getContact($id,$type,$contact): ?Contact
    {
        try { 
            $criteria = [];
            if ($id !== null) $criteria['id'] = $id;
            if ($type !== null) $criteria['type'] = $type;
            if ($contact !== null) $criteria['contact'] = $contact;

            $contact = $this->ContactsRepository->findOneBy($criteria);
            return $contact ? $contact : null;
        }
        catch (Exception $e)
        {  
            echo 'Error: '. $e;
           return null;
        }
    }

    public function getContacts($contact): array|null 
    {   
        $contactsArray = [];
        $query = $this->entityManager->createQuery(
            'SELECT c FROM App\Entity\Contact c WHERE LOWER(c.contact) LIKE LOWER(:contact)'        
            )->setParameter('contact','%'.$contact.'%');

        $results = $query->getResult();
        if (!empty($results)) {
            foreach ($results as $result) {
                $person = $result->getPerson();
                $contactsArray[] = [
                    'id' => $result->getId(),
                    'type' => $result->getType(),
                    'contact' => $result->getContact(),
                    'person' => $person ? [
                        'id' => $person->getId(),
                        'name' => $person->getName(),
                        'cpf' => $person->getCPF(),
                        'gender' => $person->getGender(),
                    ] : null,
                ];
            }
            return $contactsArray;
        } else {
            return null;
        }
    }
    public function createContact($type,$contact): ?Contact
    {
        try {
            $newContact = new Contact($type,$contact);
            return $newContact;
        }
        catch(Exception $e)
        {
            return null;
        }
    }
    public function hasContact($id=null,$type=null,$contact=null):bool|null
    {
        try {
            
            $criteria = [];
            if ($id !== null) $criteria['id'] = $id;
            if ($type !== null) $criteria['type'] = $type;
            if ($contact !== null) $criteria['contact'] = $contact;

            $hasContact = $this->ContactsRepository->findOneBy($criteria);
            return $hasContact ? true : false;
        }
        catch (Exception $e) {
            return null;
        }
    }
    public function deleteContact($id=null,$type=null,$contact=null){
        try {
            $criteria = [];
            if ($id !== null) $criteria['id'] = $id;
            if ($type !== null) $criteria['type'] = $type;
            if ($contact !== null) $criteria['contact'] = $contact;

            $Contact = $this->ContactsRepository->findOneBy($criteria);
            $this->entityManager->remove($Contact);
            $this->entityManager->flush();
        }
        catch (Exception $e){
            return null;
        }
    }
}