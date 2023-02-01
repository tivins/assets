<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Size;
use Tivins\Assets\Str;
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
                <div class="p-4 modal-icon">
                  '.Website::getIcon().'
                </div>
                <h2 class="mt-0 mb-4 fw-light">' . StrUtil::html($this->title) . '</h2>
            </div>
            '
            . $this->content
            . $this->getFooter()
        ,$this->containerWidth), true
        );
    }
}