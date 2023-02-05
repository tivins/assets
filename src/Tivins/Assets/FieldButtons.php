<?php

namespace Tivins\Assets;

class FieldButtons extends Field
{
    protected array $buttons = [];

    public function __toString(): string
    {
        return $this->wrap(join($this->buttons));
    }

    public function addButton(string $button): static
    {
        $this->buttons[] = $button;
        return $this;
    }
}