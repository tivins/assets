<?php

namespace Tivins\Assets\Components;

class SVGIcon extends Icon
{
    private string $svg;

    public function __construct(string $svg)
    {
        parent::__construct();
        $this->svg = $svg;
    }

    public function __toString(): string
    {
        return $this->svg;
    }
}