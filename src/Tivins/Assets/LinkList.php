<?php

namespace Tivins\Assets;

class LinkList
{
    private array $items   = [];
    private array $classes = [];
    private array $attrs = [];
    private Size $size;
    
    public function __construct(Size $size = Size::LG)
    {
        $this->size = $size;
    }

    public function empty(): bool {
        return empty($this->items);
    }

    public function push(ListItemBase ...$item): static
    {
        $this->items = array_merge($this->items, $item);
        return $this;
    }

    public function addAttributes(array $attrs): static
    {
        $this->attrs = array_merge($this->attrs, $attrs);
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
         * Add 'link-list' and 'link-list-sm' to class list,
         */
        $classes = array_merge($this->classes, ['link-list', $this->size->suffix('link-list')]);
        /**
         * Calls iteratively the __toString() on each items.
         */
        return Components::div($classes, join($this->items))->setAttributes($this->attrs);
    }

}