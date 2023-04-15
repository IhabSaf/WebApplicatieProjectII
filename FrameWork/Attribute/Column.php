<?php

namespace FrameWork\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Column
{

    public function __construct(public ?string $name = null, public ?string $type = null){}

}