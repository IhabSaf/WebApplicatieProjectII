<?php

namespace FrameWork\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Role
{
    public function __construct(public array $roles)
    {
    }
}
