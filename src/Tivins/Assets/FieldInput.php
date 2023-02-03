<?php

namespace Tivins\Assets;

use Tivins\Core\Util;

class FieldInput extends Field
{
    protected string $type = 'text';

    public function __construct($type = 'text')
    {
        $this->type = $type;
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

    public function __toString(): string
    {
        $html = $this->getLabel();
        $html .= '<input id="' . $this->getID() . '" type="' . $this->type . '"'
            . ' name="' . $this->name . '"'
            . ($this->required ? ' required' : '')
            . ($this->placeholder ? ' placeholder="' . $this->placeholder . '"' : '')
            . '>';
        return $this->wrap($html);
    }
}