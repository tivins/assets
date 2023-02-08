<?php

namespace Tivins\Assets;

use Tivins\Assets\Components\HTMLElement;

class FieldTextArea extends Field
{
    public function __construct()
    {
    }


    public function __toString(): string
    {
        $label = $this->getLabel();
        $input      = (new HTMLElement('textarea'))
            ->setAttributes([
                'id'   => $this->getID(),
                'name' => $this->name,
                'rows' => 5,
            ])
            ->setSelfClosedType(0);

        if ($this->required) {
            $input->addAttribute('required', null);
        }
        if ($this->placeholder) {
            $input->addAttribute('placeholder', $this->placeholder);
        }

        return $this->wrap($label . $input);
    }
}