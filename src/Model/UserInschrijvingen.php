<?php

namespace src\Model;

use FrameWork\Attribute\Column;
use FrameWork\Attribute\Table;
use FrameWork\database\Mapping;

#[Table('UserInschrijvingen')]
class UserInschrijvingen extends Mapping
{
    #[Column('id')]
    private int $id;

    #[Column('userId')]
    private ?int $userId;

    #[Column('tentamenId')]
    private ?int $tentamenId;


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


}