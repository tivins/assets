<?php

namespace Tivins\Assets;

use Tivins\Core\StrUtil;

class Str
{
    public function __construct(private string $value, private bool $safe = false)
    {
    }

    public function __toString(): string
    {
        var_dump($this->value);
        return $this->safe ? $this->value : StrUtil::html($this->value);
    }
}