<?php

namespace Tivins\Assets;

use Tivins\Assets\Components\Button;
use Tivins\Core\Util;

class Field
{
    protected string $placeholder = '';
    protected bool   $required    = false;
    protected string $label       = '';
    protected string $name        = '';
    protected string $value       = '';
    protected Button $labelButton;

    public function getID(): string
    {
        return 'field-' . Util::getObjectID($this);
    }

    protected function wrap(string $html): string {
        return Components::div('field', $html);
    }

    public function setPlaceholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function setRequired(bool $required = true): static
    {
        $this->required = $required;
        return $this;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function setLabelButton(Button $button): static
    {
        $this->labelButton = $button;
        return $this;
    }
    protected function getLabel(): string
    {
        $guid  = $this->getID();
        $label = '<label for="' . $guid . '" class="flex-grow"><span class="form-label">' . new Str($this->label) . '</span></label>';
        if (isset($this->labelButton)) {
            return Components::div('d-flex', $label . $this->labelButton);
        }
        return $label;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): Field
    {
        $this->value = $value;
        return $this;
    }

}

