<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Str;
use Tivins\Assets\Template;
use Tivins\Assets\Website;
use Tivins\Core\StrUtil;

class ModalPage extends Page
{
    public function __toString(): string
    {
        return Template::tpl($this->title, Template::container(
            '<div class="mx-auto max-w-350px">
            <div class="text-center">
                <div class="p-4 modal-icon">
                  '.Website::getIcon().'
                </div>
                <h2 class="mt-0 mb-4 fw-light">' . StrUtil::html($this->title) . '</h2>
            </div>
            '
            . $this->content
            . $this->getFooter()
            . '</div>'
        ), true
        );
    }
}