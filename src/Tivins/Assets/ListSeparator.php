<?php

namespace Tivins\Assets;

class ListSeparator extends ListItemBase
{
    public function __toString(): string
    {
        return '<div class="list-item-separator">User related pages
        </div>';
    }

}