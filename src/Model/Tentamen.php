<?php

namespace src\Model;

use FrameWork\Attribute\Column;
use FrameWork\Attribute\Table;
use Framework\database\Mapping;

#[Table('tentamen')]
class Tentamen extends Mapping
{

    #[Column('id')]
    private ?string $id;

    #[Column('name')]
    private ?string $name;

    #[Column('docentId')]
    private ?string $tentamenId;


    public function getId()
    {
        return $this->getAttribute('id');
    }


    public function getName(): ?string
    {
        return $this->getAttribute('name');
    }


    public function getTentamenId()
    {
        return $this->getAttribute('tentamenId');
    }


    public function setId($id): void
    {
        $this->setAttribute("id", $id);
    }


    public function setName(?string $name): void
    {
        $this->setAttribute("name", $name);
    }


    public function setTentamenId($tentamenId): void
    {
        $this->setAttribute("tentamenId", $tentamenId);
    }




}