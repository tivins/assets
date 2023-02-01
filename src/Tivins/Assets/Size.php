<?php

namespace Tivins\Assets;

enum Size: string
{
    case NONE = '';
    case XL = 'xl';
    case LG = 'lg';
    case MD = 'md';
    case SM = 'sm';
    case XS = 'xs';
    //
    case XXL = 'xxl';
    case XXS = 'xxs';
    case Fluid = 'fluid';

    /**
     * Convert 'd-flex' to 'd-flex-md' or 'd-flex';
     */
    public function suffix(string $string): string
    {
        return trim($string . '-' . $this->value, '-');
    }
}