<?php

namespace src\Model;

use FrameWork\Attribute\Column;
use FrameWork\Attribute\Table;
use FrameWork\database\Mapping;
#[Table('user')]
class User extends Mapping
{
    #[Column('id')]
    public ?int $id = null;

    #[Column('name')]
    public ?string $name = null;

    #[Column('rolId')]
    public ?int $rolId = null;

    #[Column('email')]
    public ?string $email = null;

    #[Column('password')]
    public ?string $password = null;



    /**
     * @return int|null
     */
    public function getId(): ?int
    {
         return $this->getAttribute('id');
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
         return $this->getAttribute('name');
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->getAttribute('email');
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->getAttribute('password');
    }

    /**
     * @return int|null
     */


    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->setAttribute('id', $id);
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->setAttribute('name', $name);
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->setAttribute('email', $email);
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        if ($password !== null) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $this->setAttribute('password', $passwordHash);
        }
    }


    public function getRolId()
    {
        return $this->getAttribute('rolId');
    }


    public function setRolId(int $rolId): void
    {
        $this->setAttribute('rolId', $rolId);
    }




}
