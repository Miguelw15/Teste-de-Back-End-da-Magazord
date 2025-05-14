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
    public function createContact($type,$contact): ?Contact
    {
        try {
            $newContact = new Contact($type,$contact);
            $this->entityManager->persist($newContact);
            $this->entityManager->flush();
            return $newContact;
        }
        catch(Exception $e)
        {
            echo "Error: ". $e->getMessage();
            return null;
        }
    }
}