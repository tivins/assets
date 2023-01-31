<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Components;
use Tivins\Assets\Components\Button;
use Tivins\Assets\Str;

class InteractivePath
{
    private array $path;

    public function __construct(?string $path = null)
    {
        $path       = $path ?? $_SERVER['REQUEST_URI'] ?? '';
        $this->path = preg_split('~/~', $path, -1, PREG_SPLIT_NO_EMPTY);
    }

    public function __toString(): string
    {
        $home    = Button::newLink()
            ->setUrl('/assets/')
            ->setClasses('button link')
            ->setLabel(new Str(''))
            ->setIcon(new Components\Icon('house', margin: 'none'));

        $items   = array_map(function (string $elm) {
            return Button::newLink()
                ->setLabel(new Str($elm));
        }, $this->path);
        $content = join(' / ', array_merge([$home], $items));
        return Components::div(['breadcrumb'], $content);
    }
}