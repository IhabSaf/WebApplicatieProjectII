<?php

namespace src\Model;

use FrameWork\Attribute\Table;
use FrameWork\Attribute\Column;
use Framework\database\Mapping;


#[Table('rol')]
class Rol extends Mapping
{

    #[Column('id')]
    private $id;

    #[Column('name')]
    private ?string $name;


    public function getId()
    {
        return $this->getAttribute('id');
    }


    public function getName(): ?string
    {
        return $this->getAttribute('name');
    }


    public function setId($id): void
    {
         $this->setAttribute("id",$id);
    }


    public function setName(?string $name): void
    {
        $this->setAttribute("name", $name);
    }



}