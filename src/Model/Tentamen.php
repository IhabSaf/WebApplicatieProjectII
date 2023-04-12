<?php

namespace src\Model;

use FrameWork\Attribute\Column;
use FrameWork\Attribute\Table;
use FrameWork\database\Mapping;

#[Table('tentamen')]
class Tentamen extends Mapping
{

    #[Column('id')]
    private ?string $id;

    #[Column('name')]
    private ?string $name;

    #[Column('docentId')]
    private ?int $tentamenId;


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
        $this->setAttribute("id", $id);
    }


    public function setName(?string $name): void
    {
        $this->setAttribute("name", $name);
    }

    public function setDocentId($name): void
    {
        $this->setAttribute("docentID", $name);
    }

}