<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Box;
use Tivins\Assets\Components;
use Tivins\Assets\HTMLStr;
use Tivins\Assets\Str;
use Tivins\Assets\Template;
use Tivins\Assets\Website;
use Tivins\Core\StrUtil;

class Page
{
    protected string $title = 'Modal page';
    protected string $content = '';

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }
    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function __toString(): string
    {
        $dialog = '<div class="dialog closed">'
            . (
            (new Box())
                ->setBoxClasses('box-info')
                ->setTitle('ALERTE')
                ->setBodyClasses('p')
                ->addHTML('yo')
                ->setFooterClasses('p-2')
                ->addHeaderOption(Components::getCloseLink())
                ->setFooter('<div class="flex-grow"></div>
                    <button class="ghost close-box-btn" ">Cancel</button>
                    <button class="success ml close-box-btn">OK</button>'
                )
            )
            . '</div>';
        $cookie = Components::boxMessage(new HTMLStr('
                  <h3 class="mt-0 mb-0">Cookies</h3>
                  <div class="my-1">Ce site n\'utilise que des cookies essentiels.</div>
                  '
        ), 'warning', 'sticky-top top-2 mt-2', true
        );
        $cookie = '';
        return Template::tpl($this->title, Template::container(
            $cookie
            . Components::getHeaderBar($this->title)
            . $this->content
            . $this->getFooter()
//            . $dialog
        ), true
        );
    }

    public function getFooter(): string {
        return '
            <div class="py-4 d-flex fs-80">
                <a href="/assets/" class="flex-grow text-center p-2">
                    '.new Str(Website::getTitle()).'
                </a>
                <a href="/assets/legal.html" class="flex-grow text-center p-2">Terms &amp; Privacy</a>
            </div>
        ';
    }
}