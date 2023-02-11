<?php

namespace Tivins\Assets\Components;

class Icon
{
    /**
     * @param string $icon Main part of the icon name (after 'fa-').
     * @param string|bool $class bool: regular or not, or string: 'regular','brands'...
     * @param int $mutedLevel level
     * @param bool $fixedWidth
     * @param string $margin
     * @param array $classes
     */
    public function __construct(
        public string      $icon = 'check',
        public string|bool $class = '',
        public int         $mutedLevel = 1,
        public bool        $fixedWidth = false,
        public string      $margin = 'right',
        public array       $classes = [],
    )
    {
        if (is_bool($class)) {
            $this->class = $class ? 'regular' : '';
        }
    }

    public function __toString(): string
    {
        $classes[] = 'fa' . ($this->class ? '-' . $this->class : '');
        if ($this->fixedWidth) {
            $classes[] = 'fa-fw';
        }
        $classes[] = 'fa-' . $this->icon;
        if ($this->margin != 'none') {
            $classes[] = 'm' . substr($this->margin, 0, 1) . '-2';
        }
        if ($this->mutedLevel) {
            $classes[] = 'op-05';
        }
        $classes = array_merge($classes, $this->classes);
        return '<i class="' . join(' ', $classes) . '"></i>';
    }

    public function setMargin(string $margin): static {
        $this->margin = $margin;
        return $this;
    }

    public static function newSingle(string $icon, string $class = ''): static {
        return (new static($icon, $class, margin: 'none', mutedLevel: 0));
    }
}
