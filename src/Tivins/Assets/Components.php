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
            ->setBoxClasses(    'box-'.$status.' mb ' . $classes)
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
        return '<div class="d-flex flex-align my-4">
            <h1 class="h1-icon flex-grow my-0">
              <a href="/assets/" class="icon" title="'. new Str(Website::getTitle()).'">'. Website::getIcon().'</a>
              <div class="flex-grow">'.new Str($title).'</div>
            </h1>
            <div>
              <label class=" button ghost pr-1 py-1 mr-1" style="cursor: text;padding:.5rem;">
                  <input type="search" placeholder="Search" class="no-background no-borders"/><i class="fa fa-fw fa-search"></i>
              </label>
            </div>
            <a href="#" class="button ghost" title="admin"><i class="fa fa-fw fa-cog"></i></a>
            <a href="#" class="button ghost toggle-theme" title="Set dark mode"><i class="fa-regular fa-fw fa-moon"></i></a>
            <a href="#" class="button ghost" onclick="event.preventDefault();document.querySelector(\'.dialog\').classList.remove(\'closed\')"><i class="fa fa-fw fa-user"></i></a>
          </div>';
    }
}