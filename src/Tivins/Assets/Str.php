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
        return $this->safe ? $this->value : StrUtil::html($this->value);
    }

    public function empty(): bool
    {
        return empty($this->value);
    }

    public static function plain(string $value): static {
        return new static($value);
    }
    public static function html(string $value): static {
        return new static($value, true);
    }
}