<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\HDirection;
use Tivins\Assets\LinkList;
use Tivins\Assets\ListItem;
use Tivins\Assets\Size;
use Tivins\Assets\Str;
use Tivins\Assets\Website;

class HeaderBarMain
{
    public string $title;
    private LinkList $configList;
    private LinkList $userMenu;
    private bool $searchShown = true;
    private bool $userIsLogged = false;
    private string $username = '';
    private bool $userNameShown = true;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->configList = (new LinkList(Size::SM))->addClasses('pop-menu-admin hidden');
        $this->userMenu = (new LinkList(Size::SM))->addClasses('pop-menu-user hidden');
    }

    public function isUserIsLogged(): bool
    {
        return $this->userIsLogged;
    }

    public function setUserIsLogged(bool $userIsLogged): HeaderBarMain
    {
        $this->userIsLogged = $userIsLogged;
        return $this;
    }

    public function isSearchShown(): bool
    {
        return $this->searchShown;
    }

    public function setSearchShown(bool $searchShown): static
    {
        $this->searchShown = $searchShown;
        return $this;
    }

    public function isUserNameShown(): bool
    {
        return $this->userNameShown;
    }

    public function setUserNameShown(bool $userNameShown): static
    {
        $this->userNameShown = $userNameShown;
        return $this;
    }

    public function getThemeItem(): ListItem
    {
        return new ListItem('Theme','submenu1','', 'fa fa-moon', classes: 'toggle-theme');
    }

    public function getConfigList(): LinkList {
        return $this->configList;
    }

    public function getUserMenu(): LinkList {
        return $this->userMenu;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;
        return $this;
    }

    public function __toString(): string
    {
        return '
        <div class="d-flex flex-align my-3 header-bar">
            <a href="#" class="p button ghost pop-trigger mr visible-sm" data-target=".menu-mobile"><i class="fa fa-bars"></i></a>
            <h1 class="h1-icon flex-grow my-0">
              <a href="'.Website::getLink().'" class="website-icon mr-2" title="'. new Str(Website::getTitle()).'">'. Website::getIcon().'</a>
              <span class="flex-grow visible-md">'.new Str($this->title).'</span>
            </h1>'
            .(
                $this->isSearchShown()
                ? '<label class="visible-md button ghost pr-1 py-1 mr-1" title="Search on site" style="cursor: text;padding:.5rem;">
                      <input type="search" placeholder="Search" class="no-background no-borders"/><i class="fa fa-fw fa-search"></i>
                    </label>'
                : ''
            )
            . Button::newGhost()
                ->setTitle('Search')
                ->setIcon(new Icon('search', mutedLevel: 0, fixedWidth: true, margin: 'none'))
                ->addClasses('p-2 visible-sm')
            . ($this->configList->empty()
                ? ''
                : Button::newGhost()
                ->setTitle('Configuration')
                ->setDataAttr('target', '.pop-menu-admin')
                ->setIcon(new Icon('cog', mutedLevel: 0, fixedWidth: true, margin: 'none'))
                ->addClasses('mr-1 pop-trigger p-2')
                ->setDropDir(HDirection::Down)
            )
            // . Button::newGhost()
            //     ->setTitle('Set dark mode')
            //     ->setIcon(new Icon('moon', 'regular', mutedLevel: 0, fixedWidth: true, margin: 'none'))
            //     ->addClasses('toggle-theme')
            . Button::newGhost()
                ->setLabel($this->isUserNameShown() ? ($this->isUserIsLogged() ? $this->username : 'Sign in/Sign up') : '')
                ->setIcon(new Icon('user', 'regular', mutedLevel: 0, fixedWidth: true, margin: 'none'))
                ->setTitle('User options')
                ->setDataAttr('target', '.pop-menu-user')
                ->addClasses('pop-trigger p-2')
                // ->setLabel(new HTMLStr('<img src="https://i.stack.imgur.com/2EeK7.png" width="24" style="display: inline-block" />'))
                ->setDropDir(HDirection::Down)
            .'
            <!-- onclick="event.preventDefault();document.querySelector(\'.dialog\').classList.remove(\'closed\')" -->
          </div>'
            . '<h1 class="visible-sm">' . new Str($this->title) . '</h1>'
            // .(new LinkList(Size::SM))
            //     ->addClasses('pop-menu-user hidden')
            //     ->push(
            //         new ListSeparator('<span class="fw-light">Signed in as</span> '.$this->username),
            //         new ListItem('Profile','submenu1','#', 'fa fa-moon'),
            //         new ListItem('Settings','submenu1','/assets/user-settings.html', 'fa fa-user-gear'),
            //         new ListItem('Log out','submenu1','#', 'fa fa-power-off'),
            //     )
            . $this->userMenu
            . $this->configList;
    }
}