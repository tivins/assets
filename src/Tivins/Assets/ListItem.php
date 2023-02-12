<?php

namespace Tivins\Assets;

use Tivins\Assets\Components\Icon;
use Tivins\Core\StrUtil;

class ListItem extends ListItemBase
{
    protected array $attrs = [];
    /**
     * @todo change $classes type to string[]
     */
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

    /**
     * Add HTML attributes to the item.
     *
     * @param array $attrs An associative array with attribute-name as key, and HTML value as value.
     * @return $this
     */
    public function addAttributes(array $attrs): static
    {
        $this->attrs = array_merge($this->attrs, $attrs);
        return $this;
    }
    public function __toString(): string
    {
        $icon = $this->icon;
        // Backward compatibility
        if (!empty($icon) && is_string($icon)) {
            $icon = '<i class="icon  ' . $icon . ' p-3 op-025 text-center"></i>';
        }

        $attrs = '';
        foreach ($this->attrs as $attrName => $attrValue) {
            if (!preg_match('~[a-z\-]~', $attrName)) {
                continue;
            }
            if (is_null($attrValue)) {
                $attrs .= ' '.$attrName;
            } else {
                $attrs .= ' '.$attrName.'="' . StrUtil::html($attrValue) . '"';
            }
        }
        //<!-- <a href='#dd' class='p-3'><i class='fa-regular fa-minus-square'></i></a> -->
        return '<div class="list-item" '.$attrs.'>
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

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function setSubTitle(string $subTitle): static
    {
        $this->subTitle = $subTitle;
        return $this;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;
        return $this;
    }

    public function setIcon(Icon|string|null $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function setSupTitle(string $supTitle): static
    {
        $this->supTitle = $supTitle;
        return $this;
    }

    public function setClasses(string $classes): static
    {
        $this->classes = $classes;
        return $this;
    }
    public function addClasses(string ...$classes): static
    {
        $this->classes .= ' ' . join(' ', $classes);
        return $this;
    }


}