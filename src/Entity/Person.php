<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping;
use Doctrine\DBAL\Types\Types;
use Exception;

#[Mapping\Entity]
#[Mapping\Table(name: 'person')]
class Person
{
    #[Mapping\Id]
    #[Mapping\Column(type:Types::INTEGER, unique:true)]
    #[Mapping\GeneratedValue]
    private int $id;
    
    #[Mapping\Column(type:Types::STRING, length:100)]
    private string $name;

    #[Mapping\Column(type:Types::STRING, unique:true)]
    private string $cpf;

    #[Mapping\Column(type:Types::STRING)]
    private $gender;

    
    /** @var Collection<int,Contact> */
    #[Mapping\OneToMany(targetEntity: Contact::class,mappedBy:'person',cascade:['persist','remove'])]
    private Collection $contacts;

    public function __construct($name,$cpf,$gender)
    {
        try{
            if ($this->authenticate($name,$cpf,$gender)){
                $this->name = $name;
                $this->cpf = $cpf;
                $this->gender = $gender;
                $this->contacts = new ArrayCollection();
            };
        } catch (Exception $e) {
            echo 'Não é válido! Erro: ' . $e->getMessage();
        }
    }
        
    private function authenticate($name,$cpf,$gender): bool
    {
        if (!preg_match('/^[a-zA-ZÀ-Öà-ö]{2,100}\s[a-zA-ZÀ-Öà-ö]{2,100}$/',$name)){
            throw new Exception('Invalid name!');
        }
        if (!preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $cpf)){
            throw new Exception('Invalid cpf! Use this format: XXX.XXX.XXX-XX.');
        }
        if (!in_array($gender, ['Male','Female','Other'])) {
            throw new \InvalidArgumentException("Gênero inválido: $gender");
        }
        
        return true;
    }

    public function addContact(Contact $contact): void
    {
        $contact->setPerson( $this);
        $this->contacts[] = $contact;
    }

    public function removeContact(int $contactId): void
    {   
        foreach ($this->contacts as $contact){
            if ($contact->getId() === $contactId){
                $this->contacts->removeElement($contact);
                $contact->setPerson(null);
                break;
            }
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    
    public function getCPF(): string
    {
        return $this->cpf;
    }
    public function getContacts(): array|Collection
    {
        return $this->contacts;
    }
    public function getGender(): string
    {
        return $this->gender;
    }
}