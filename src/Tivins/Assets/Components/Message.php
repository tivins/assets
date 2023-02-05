<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\Components;
use Tivins\Assets\Str;

class Message extends \Tivins\Assets\Box
{
    /** @var Button[] */
    private array $buttons = [];

    public function __construct(string $style = 'info', string $iconName = '', string $iconWeight = 'regular')
    {
        $this->setBoxClasses('box-' . $style, 'my-2');
        $this->setHeaderClasses('no-borders');
        $this->addHeaderInfo(
            Components::div('header-item w-4 text-center pr-0',
                new Icon($iconName . ' fs-200', $iconWeight, margin: 'none')
            )
        );
    }

    public function getTitle(): string
    {
        return '<b>' . $this->title . '</b>'
            . Components::div('my-2 fs-90', $this->body)
            . Components::div('d-flex fs-80', join($this->buttons));
    }

    public function getBody(): string
    {
        return '';
    }

    public function addButton(Button $btn): static
    {
        $this->buttons[] = $btn;
        return $this;
    }
}