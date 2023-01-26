<?php

namespace Tivins\Assets;

use Tivins\Core\StrUtil;

class Components
{
    /**
     * @param string $icon "fa-regular fa-clone"
     * @return string
     */
    public static function getIcon(string $icon): string
    {
        return '<i class="fa-fw ' . $icon . '" aria-hidden="true"></i>';
    }

    /**
     * @param string $target "href","myself" or selector.
     * @return string
     */
    public static function getCloneLink(
        string $target,
        string $tooltip = 'Copy',
        string $linkClass = 'header-item',
        string $text = '',
        string $successText = 'Copied!',
    ): string
    {
        return '<a href="#" class="'.$linkClass.' copy"'
            . ' title="'. StrUtil::html($tooltip).'"'
            . ' data-target="'.$target.'"'
            . ($successText ? ' data-text="'.StrUtil::html($successText).'"' : '')
            . '>'
            . self::getIcon('fa-regular fa-clone' . ($text ? ' mr-2' : ''))
            . StrUtil::html($text)
            . '</a>';
    }
}