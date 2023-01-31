<?php

namespace Tivins\Assets;

use Tivins\Core\StrUtil;

class LinkList
{
    private array $items   = [];
    private array $classes = [];

    public function push(ListItemBase $item): static
    {
        $this->items[] = $item;
        return $this;
    }

    public function addClasses(string ...$classes): static
    {
        $this->classes = array_merge($this->classes, $classes);
        return $this;
    }

    public function __toString(): string
    {
        /**
         * Calls iteratively the __toString() on each items.
         */
        return '<div class="link-list ' . join(' ', $this->classes) . '">' . join($this->items) . '</div>';
    }

}