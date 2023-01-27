<?php

namespace Tivins\Assets;

use Tivins\Core\StrUtil;

class HTMLStr extends Str
{
    public function __construct(string $value)
    {
        parent::__construct($value, true);
    }
}