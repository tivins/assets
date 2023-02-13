<?php

namespace Tivins\Assets;

use Tivins\Assets\Components\Button;
use Tivins\Assets\Components\HeaderBarMain;
use Tivins\Assets\Components\HTMLElement;
use Tivins\Assets\Components\Icon;
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

    public static function ico(
        string $icon = 'check',
        bool $regular = false,
        bool $lighter = true,
        bool $fixedWidth = false,
        string $margin = 'right'
    ): string
    {
        $classes[] = 'fa' . ($regular ? '-regular' : '');
        if ($fixedWidth) {
            $classes[] = 'fa-fw';
        }
        $classes[] = 'fa-' . $icon;
        if ($margin != 'none') {
            $classes[] = 'm' . substr($margin, 0, 1) . '-1';
        }
        if ($lighter) {
            $classes[] = 'op-05';
        }
        return '<i class="' . join(' ', $classes) . '"></i>';
    }

    public static function div(string|array $classes, string $content, string $tag = 'div'): HTMLElement
    {
        if (is_string($classes)) {
            $classes = explode(' ', $classes);
        }
        return (new HTMLElement($tag))
            ->setClassList(...$classes)
            ->setContent(new HTMLStr($content));
    }

    public static function subText(string $content, string $classes = ''):string {
        return self::div('subtext ' . $classes, $content);
    }
    public static function subText2(string $content, string $classes = ''):string {
        return self::div('subtext-2 ' . $classes, $content);
    }
    public static function subText3(string $content, string $classes = ''):string {
        return self::div('subtext-3 ' . $classes, $content);
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
            . self::getIcon('state-normal fa-regular fa-clone' . ($text ? ' mr-2' : ''))
            . self::getIcon('state-success fa-solid fa-check hidden' . ($text ? ' mr-2' : ''))
            . StrUtil::html($text)
            . '</a>';
    }
    public static function getCloseLink(string $tooltip = 'Close'): string
    {
        return '<a href="#" class="header-item close-box-btn" 
            title="'.StrUtil::html($tooltip).'"><i class="fa fa-fw fa-times"></i></a>';
    }
    public static function getMoreLink2(
        string $trigger ,
        string $tooltip = 'More',
        string $icon = 'fa fa-ellipsis-h',
    ): string
    {
        return '<a href="#" class="header-item pop-trigger"'
            . ' data-target="'.$trigger.'"'
            . ' title="'.StrUtil::html($tooltip).'"'
            . '>'
            . '<i class="fa-fw '.$icon.'"></i>'
            . '</a>';
    }
    public static function getMoreLink(
        string $tooltip = 'More',
        string $icon = 'fa fa-ellipsis-h',
        ListItemBase ...$items
    ): string
    {
        return '<a href="#" class="header-item pop-trigger"'
            . ' data-data="[1,2,3]"'
            . ' title="'.StrUtil::html($tooltip).'"'
            . '>'
            . '<i class="fa-fw '.$icon.'"></i>'
            . '</a>';
    }
    public static function boxMessage(array|Str $message, string $status = 'info',string $classes = '',
                                      bool $closable =true, string $icon = '',string $body=''): Box {
        $title = '';
        if ($message instanceof Str) {
            $title = $message;
        } else {
            $title = '<ul class="my-0"><li>'.join('</li><li>', $message).'</li></ul>';
        }
        $box= (new Box())
            ->setTitleHTML($title)
            ->setBoxClasses('box-'.$status.' mb ' . $classes)
            ->setHeaderClasses('no-borders');
        if ($closable) {
            $box->addHeaderOption(Components::getCloseLink());
        }
        if ($icon) {
            $box->setIcon($icon);
            //$box->addHeaderInfo('<i class="'.$icon.' header-item"></i>');
        }
        if ($body) {
            $box->setHeaderClasses();
            $box->addHTML($body);
        }
        return $box;
    }

    /**
     * @deprecated
     * @see HeaderBarMain
     */
    public static function getHeaderBar(string $title): string {
        return new HeaderBarMain($title);
    }

    /**
     * @param string[] $tags
     * @return string
     */
    public static function getTagList(array $tags): string
    {
        $items = [];
        foreach ($tags as $tag) {
            $items[] = (new Button())
                ->setLabel(new Str($tag))
                ->setClasses('tag')
                ->setUrl('#');
        }
        return Components::div('tag-list', join($items));
    }

    public static function getCookieListItem(string $url = '/?cookies'): ListItem {
        return new ListItem('Cookies','Manage your cookies', $url,'fa fa-cookie');
    }
}