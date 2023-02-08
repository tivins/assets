<?php

namespace Tivins\Assets;

class Form
{
    protected string $method = '';
    protected array $fields = [];

    public function __construct(string $method = 'post')
    {
        $this->method = $method;
    }

    public function addField(Field $field): static
    {
        $this->fields[] = $field;
        return $this;
    }

    public function __toString(): string
    {
        return '<form method="' . $this->method . '" action="" class="form p">'
            . join($this->fields)
            . '</form>';
    }
}