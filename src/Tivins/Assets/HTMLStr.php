<?php

namespace Tivins\Assets;

class HTMLStr extends Str
{
    public function __construct(string $value)
    {
        parent::__construct($value, true);
    }
}