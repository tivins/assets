<?php

namespace Tivins\Assets;

class FieldButtons extends Field
{
    public function __toString(): string
    {
        $html = '';//$this->getLabel();
        $html .= 'ok';
        return $this->wrap($html);
    }
}