<?php

namespace Tivins\Assets\Stylesheet;

class Value
{
    public function __construct(
        public ValueType $valueType,
        public string $value,
    )
    {
    }

    public function __toString(): string
    {
        return match ($this->valueType) {
            ValueType::REM => $this->value . 'rem',
            ValueType::EM => $this->value . 'em',
            ValueType::PX => $this->value . 'px',
            ValueType::NUMBER, ValueType::STR, ValueType::PER_ONE => $this->value,
            ValueType::PERCENT => $this->value . '%',
        };
    }
}