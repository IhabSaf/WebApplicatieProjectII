<?php
namespace src\Model;

use Framework\Attribute\Column;
use Framework\database\Mapping;

class User extends Mapping
{
    #[Column('id')]
    public ?int $id = null;

    #[Column('name')]
    public ?string $name = null;

    #[Column('email')]
    public ?string $email = null;

    #[Column('password')]
    public ?string $password = null;

    public function __construct()
    {
        parent::__construct();
    }

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
}
