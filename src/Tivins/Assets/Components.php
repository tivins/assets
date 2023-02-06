<?php

namespace Tivins\Assets;

use Tivins\Assets\Components\Button;
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

    public static function div(string|array $classes, string $content):string
    {
        if (is_string($classes)) {
            $classes = explode(' ', $classes);
        }
        return (new HTMLElement('div'))
            ->setClassList(...$classes)
            ->setContent(new HTMLStr($content));

        //return '<div class="' . $classes . '">' . $content . '</div>';
    }

    public static function subText(string $content, string $classes = ''):string {
        return self::div('subtext ' . $classes, $content);
    }
    public static function subText2(string $content, string $classes = ''):string {
        return self::div('subtext-2 ' . $classes, $content);
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
    public static function getHeaderBar(string $title): string {
        return '
        <div class="d-flex flex-align my-3 header-bar">
            <a href="#" class="p button ghost pop-trigger mr visible-sm" data-target=".menu-mobile"><i class="fa fa-bars"></i></a>
            <h1 class="h1-icon flex-grow my-0">
              <a href="'.Website::getRootURL().'" class="website-icon mr-2" title="'. new Str(Website::getTitle()).'">'. Website::getIcon().'</a>
              <span class="flex-grow visible-md">'.new Str($title).'</span>
            </h1>
              <label class="visible-md button ghost pr-1 py-1 mr-1" title="Search on site" style="cursor: text;padding:.5rem;">
                  <input type="search" placeholder="Search" class="no-background no-borders"/><i class="fa fa-fw fa-search"></i>
              </label>
              '
            . Button::newGhost()
                ->setTitle('Search')
                ->setIcon(new Icon('search', mutedLevel: 0, fixedWidth: true, margin: 'none'))
                ->addClasses('p-2 visible-sm')
            . Button::newGhost()
                ->setDataAttr('target', '.pop-menu-admin')
                ->setTitle('Configuration')
                ->setIcon(new Icon('cog', mutedLevel: 0, fixedWidth: true, margin: 'none'))
                ->addClasses('mr-1 pop-trigger p-2')
                ->setDropDir(HDirection::Down)
            // . Button::newGhost()
            //     ->setTitle('Set dark mode')
            //     ->setIcon(new Icon('moon', 'regular', mutedLevel: 0, fixedWidth: true, margin: 'none'))
            //     ->addClasses('toggle-theme')
            . Button::newGhost()
                ->setDataAttr('target', '.pop-menu-user')
                ->setTitle('User options')
                ->setIcon(new Icon('user', 'regular', mutedLevel: 0, fixedWidth: true, margin: 'none'))
                ->addClasses('pop-trigger p-2')
                ->setLabel(Fake::name())
                // ->setLabel(new HTMLStr('<img src="https://i.stack.imgur.com/2EeK7.png" width="24" style="display: inline-block" />'))
                ->setDropDir(HDirection::Down)
            .'
            <!-- onclick="event.preventDefault();document.querySelector(\'.dialog\').classList.remove(\'closed\')" -->
          </div>'
            .(new LinkList(Size::SM))
                ->addClasses('pop-menu-admin hidden')
                ->push(
                new ListItem('Theme','submenu1','', 'fa fa-moon', classes: 'toggle-theme'),
                new ListItem('menu1','submenu1','#'),
            )
            .(new LinkList(Size::SM))
                ->addClasses('pop-menu-user hidden')
                ->push(
                    new ListSeparator('<span class="fw-light">Signed in as</span> '.Fake::name()),
                    new ListItem('Profile','submenu1','#', 'fa fa-moon'),
                    new ListItem('Settings','submenu1','/assets/user-settings.html', 'fa fa-user-gear'),
                    new ListItem('Log out','submenu1','#', 'fa fa-power-off'),
                )
            . '<h1 class="visible-sm">' . new Str($title) . '</h1>'
            . '<div class="menu-mobile hidden">'.(new LinkList(Size::SM))
                ->addClasses('')
                ->push(
                    new ListSeparator(new Icon('user', true).'<span class="fw-light">Signed in as</span> '.Fake::name()),
                    new ListItem('Profile','submenu1','#', 'fa fa-moon'),
                    new ListItem('Settings','submenu1','/assets/user-settings.html', 'fa fa-user-gear'),
                    new ListItem('Log out','submenu1','#', 'fa fa-power-off'),
                ).'</div>';
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
}