<?php

namespace Tivins\Assets;

class ListSeparator extends ListItemBase
{
    public function __construct(public string $text)
    {
    }

    public function __toString(): string
    {
        return '<div class="list-item-separator">'.$this->text.'</div>';
    }

}