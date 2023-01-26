<?php

namespace Tivins\Assets;

use Tivins\Core\StrUtil;

class LinkList
{
    private array $items   = [];
    private array $classes = [];

    public function push(ListItemBase $item): void
    {
        $this->items[] = $item;
    }

    public function addClasses(string ...$classes): void
    {
        $this->classes = array_merge($this->classes, $classes);
    }

    public function __toString(): string
    {
        /**
         * Calls iteratively the __toString() on each items.
         */
        return '<div class="link-list ' . join(' ', $this->classes) . '">' . join($this->items) . '</div>';
    }

}