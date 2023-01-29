<?php

namespace Tivins\Assets\Components;

class Icon
{
    public function __construct(
        public string $icon = 'check',
        public string|bool $class = '',
        public bool   $muted = true,
        public bool   $fixedWidth = false,
        public string $margin = 'right',
        public array $classes = [],
    )
    {
        if (is_bool($class)) {
            $this->class = $class ? 'regular' : '';
        }
    }

    public function __toString(): string
    {
        $classes[] = 'fa' . ($this->class ? '-'.$this->class : '');
        if ($this->fixedWidth) {
            $classes[] = 'fa-fw';
        }
        $classes[] = 'fa-' . $this->icon;
        if ($this->margin != 'none') {
            $classes[] = 'm' . substr($this->margin, 0, 1) . '-1';
        }
        if ($this->muted) {
            $classes[] = 'op-05';
        }
        $classes = array_merge($classes, $this->classes);
        return '<i class="' . join(' ', $classes) . '"></i>';
    }

}