<?php

namespace App\Entity;

use Doctrine\ORM\Mapping;
use Doctrine\DBAL\Types\Types;
use Exception;

#[Mapping\Entity]
#[Mapping\Table]
class Contact
{   
    #[Mapping\Id]
    #[Mapping\Column(type: Types::INTEGER,unique:true)]
    #[Mapping\GeneratedValue]
    private int $id;
    
    #[Mapping\Column(type: Types::STRING)]
    private string $type; // email or phone

    #[Mapping\Column(type: Types::STRING, unique: true)]
    private string $content;

    #[Mapping\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Mapping\ManyToOne(targetEntity: Person::class, inversedBy:'contacts')]
    private ?Person $person = null;

    public function __construct(string $type, string $content)
    {
        try {
            if ($this->authenticate($type, $content)){
                $this->type = $type;
                $this->content = $content;
            }
        }   catch(Exception $error){
            echo 'Erro: ' . $error->getMessage();
        }
    }

    private function authenticate($type,$content)
    {  
        if ($type === 'email'){
            if(!filter_var($content,FILTER_VALIDATE_EMAIL)){
                throw new Exception('Invalid email! ');
            }
        }
        elseif ($type === 'phone'){
            if(!preg_match('/^\(\d{2}\)\s\d{5}-\d{4}$/',$content)){
                throw new Exception('Invalid email! ');
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

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }


}