<?php

namespace Tivins\Assets;

class Field
{
    protected string $placeholder = '';
    protected bool $required = false;
    protected string $label = '';
    protected string $name = '';

    public function setPlaceholder(string $placeholder): Field
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function setRequired(bool $required = true): Field
    {
        $this->required = $required;
        return $this;
    }

    public function setLabel(string $label): Field
    {
        $this->label = $label;
        return $this;
    }

    public function setName(string $name): Field
    {
        $this->name = $name;
        return $this;
    }
}

