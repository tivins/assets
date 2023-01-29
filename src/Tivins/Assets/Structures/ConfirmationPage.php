<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Box;

class ConfirmationPage
{
    public function __toString(): string
    {
        $box = (new Box())
            ->setTitle('Confirmation')
            ;

        $content = ''.$box;



        return $content;
    }
}