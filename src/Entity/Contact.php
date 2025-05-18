<?php

namespace App\Entity;

use Doctrine\ORM\Mapping;
use Doctrine\DBAL\Types\Types;
use Exception;

#[Mapping\Entity]
#[Mapping\Table(name:'contact')]
class Contact
{   
    #[Mapping\Id]
    #[Mapping\Column(type: Types::INTEGER,unique:true)]
    #[Mapping\GeneratedValue]
    private int $id;
    
    #[Mapping\Column(type: Types::STRING)]
    private string $type; 

    #[Mapping\Column(type: Types::STRING, unique: true)]
    private string $contact;

    #[Mapping\ManyToOne(targetEntity: Person::class, inversedBy:'contacts')]
    private ?Person $person = null;

    public function __construct(string $type, string $contact)
    {
        try {
            if ($this->authenticate($type, $contact)){
                $this->type = $type;
                $this->contact = $contact;
            }
        }   catch(Exception $error){
            echo 'Erro: ' . $error->getMessage();
        }
    }

    private function authenticate($type,$contact)
    {  
        if ($type === 'Email'){
            if(!filter_var($contact,FILTER_VALIDATE_EMAIL)){
                throw new Exception('Invalid email! ');
            }
        }
        elseif ($type === 'Phone'){
            if(!preg_match('/^\(\d{2}\)\s\d{5}-\d{4}$/',$contact)){
                throw new Exception('Invalid phone! ');
            }
        }
        else {
            throw new Exception('Invalid type!');
        }
        return true; 
    }
    
    public function setPerson(?Person $person): void
    {
        $this->person = $person;
    }

    public function getPerson(): ?Person
    {  
        return $this->person;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getType():string
    {
        return $this->type;
    }
    
    public function getContact(): string
    {
        return $this->contact;
    }
    

}