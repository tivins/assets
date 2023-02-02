<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Size;
use Tivins\Assets\Template;
use Tivins\Assets\Website;
use Tivins\Core\StrUtil;

class ModalPage extends Page
{
    public function __construct(string $title = '')
    {
        parent::__construct($title, Size::SM);
    }

    public function __toString(): string
    {
        return Template::tpl($this->title, Template::container(
            '
            <div class="text-center">
                <a href="/assets/" class="d-block p-4 website-icon modal-icon">
                  '.Website::getIcon().'
                </a>
                <h2 class="mt-0 mb-4 fw-light">' . StrUtil::html($this->title) . '</h2>
            </div>
            '
            . $this->content
            . $this->getFooter()
        ,$this->containerWidth), true
        );
    }
}