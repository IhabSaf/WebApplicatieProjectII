<?php

namespace src\Model;

use FrameWork\Attribute\Column;
use FrameWork\Attribute\Table;
use Framework\database\Mapping;

#[Table('userTentamen')]
class UserTentamen extends Mapping
{
    #[Column('id')]
    private $id;

    #[Column('userId')]
    private $userId;

    #[Column('tentamenId')]
    private ?string $tentamenId;


    #[Column('cijfer')]
    private ?string $cijfer;


    public function getId()
    {
        return $this->getAttribute('id');
    }


    public function getUserId()
    {
        return $this->getAttribute('userId');
    }


    public function getTentamenId()
    {
        return $this->getAttribute('tentamenId');

    }


    public function getCijfer()
    {
        return $this->getAttribute('cijfer');
    }


    public function setId($id): void
    {
        $this->setAttribute('id', $id);
    }


    public function setUserId($userId): void
    {
        $this->setAttribute('userId', $userId);
    }


    public function setTentamenId(?string $tentamenId): void
    {
        $this->setAttribute('tentamenId', $tentamenId);
    }


    public function setCijfer(?string $cijfer): void
    {
        $this->setAttribute('cijfer', $cijfer);
    }

}