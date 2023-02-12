<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\Box;
use Tivins\Assets\LinkList;
use Tivins\Assets\ListItem;
use Tivins\Assets\Size;

class BoxList extends Box
{
    private LinkList $list;

    public function __construct(Size $size)
    {
        $this->list = new LinkList($size);
    }

    public function push(ListItem $item): static
    {
        $this->list->push($item);
        return $this;
    }

    /**
     * Override the default behavior to render the LinkList instance.
     */
    public function getBody(): string
    {
        return $this->list;
    }
}