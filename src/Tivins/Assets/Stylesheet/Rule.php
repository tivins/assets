<?php

namespace Tivins\Assets\Stylesheet;

class Rule
{
    public function __construct(
        public Property $property,
        public Value $value,
    )
    {
    }
    public function __toString(): string
    {
        return $this->property->value . ':' . $this->value;
    }
}