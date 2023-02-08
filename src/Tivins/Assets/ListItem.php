<?php

namespace Tivins\Assets;

use Tivins\Assets\Components\Icon;
use Tivins\Core\StrUtil;

class ListItem extends ListItemBase
{
    public function __construct(
        public string           $title = '',
        public string           $subTitle = '',
        public string           $link = '#',
        public Icon|string|null $icon = 'fa fa-chess',
        public string           $supTitle = '',
        public string           $classes = ''
    )
    {
    }

    public function __toString(): string
    {
        $icon = $this->icon;
        // Backward compatibility
        if (!empty($icon) && is_string($icon)) {
            $icon = '<i class="icon  ' . $icon . ' p-3 op-025 text-center"></i>';
        }

        //<!-- <a href='#dd' class='p-3'><i class='fa-regular fa-minus-square'></i></a> -->
        return '<div class="list-item">
          <a href="' . $this->link . '" class="d-flex item-link w-100 ' . $this->classes . '">'
            . $icon
            . Components::div('flex-grow ' . ($icon ? 'py-3 pr-4' : 'p'),
                ($this->supTitle ? Components::subText3(StrUtil::html($this->supTitle)) : '')
                . Components::div('as-link', StrUtil::html($this->title), 'span')
                . ($this->subTitle ? Components::subText2($this->subTitle) : '')
            )
            . '</a>
        </div>';
    }
}