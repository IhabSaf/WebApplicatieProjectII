<?php

namespace FrameWork\src\Model;

use FrameWork\Attribute\Column;
use FrameWork\Attribute\Table;

#[Table('user')]

class User
{
    #[Column(type: 'int')]
    public $id;

    #[Column(type: 'varchar')]
    public $name;

    #[Column(type: 'varchar')]
    public $pass;


    public function getId()
    {
        return $this->id;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getPass()
    {
        return $this->pass;
    }





}
