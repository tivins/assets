<?php

namespace Tivins\Assets;

use Tivins\Assets\Components\HTMLElement;

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
        $label = $this->getLabel();
        $input      = (new HTMLElement('input'))
            ->setAttributes([
                'id'   => $this->getID(),
                'type' => $this->type,
                'name' => $this->name,
            ])
            ->setSelfClosedType(1);

        if ($this->required) {
            $input->addAttribute('required', null);
        }
        if ($this->placeholder) {
            $input->addAttribute('placeholder', $this->placeholder);
        }

        return $this->wrap($label . $input);
    }
}