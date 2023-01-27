<?php

namespace Tivins\Assets;

use Tivins\Core\StrUtil;

class ListItem extends ListItemBase
{
    public function __construct(
        public string $title = '',
        public string $subTitle = '',
        public string $link = '#',
        public string $icon = 'fa fa-chess'
    )
    {
    }

    public function __toString(): string
    {
        return '<div class="list-item">
        <!-- <a href="#dd" class="p-3"><i class="fa-regular fa-minus-square"></i></a> -->
        <a href="' . $this->link . '" class="d-flex item-link">
          <i class="fs-200 ' . $this->icon . ' p-3 op-025" style="text-align:center;width:5rem"></i>
          <div class="flex-grow py-3 pr-4">
            <span class="as-link">' . StrUtil::html($this->title) . '</span>
            ' . ($this->subTitle ? '<div class="subtext-2">' . StrUtil::html($this->subTitle) . '</div>' : '')
            . '</div>
        </a>
        </div>';
    }
}