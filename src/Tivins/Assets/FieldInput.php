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

    public function __toString(): string
    {
        $label = $this->getLabel();
        $input      = (new HTMLElement('input'))
            ->setAttributes([
                'id'   => $this->getID(),
                'type' => $this->type,
                'name' => $this->name,
                'value' => $this->getValue()
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