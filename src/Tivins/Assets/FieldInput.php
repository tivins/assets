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

    public function __toString(): string
    {
        $guid = 'field-' . Util::getObjectID($this);

        $html = '<label for="' . $guid . '">
        <span class="form-label">' . new Str($this->label) . '</span>
        <input id="' . $guid . '" type="' . $this->type . '" name="' . $this->name . '" required placeholder="' . $this->placeholder . '">
        </label>';
        return Components::div('field', $html);
    }
}