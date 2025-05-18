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
    
    public function getContacts($search): array|null 
    {   
        $contactsArray = [];
        $query = $this->entityManager->createQuery(
            'SELECT c FROM App\Entity\Contact c WHERE LOWER(c.contact) LIKE LOWER(:contact)'        
            )->setParameter('contact','%'.$search.'%');

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
    public function hasContact($type,$contact):bool|null
    {
        try {
            
            $hasContact = $this->ContactsRepository->findOneBy([
                'type'=>$type,
                'contact'=>$contact,
            ]);
            return $hasContact ? true : false;
        }
        catch (Exception $e)
        {
           
            return null;
        }
    }
    public function deleteContact($id){
        try {
            $contact = $this->ContactsRepository->findOneBy([
                'id' => $id,
            ]);
            $this->entityManager->remove($contact);
            $this->entityManager->flush();
        }
        catch (Exception $e){
            echo 'Error: '. $e;
        }
    }
}