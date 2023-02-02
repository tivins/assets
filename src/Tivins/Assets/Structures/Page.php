<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Components;
use Tivins\Assets\Components\Button;
use Tivins\Assets\Components\Icon;
use Tivins\Assets\HTMLStr;
use Tivins\Assets\Size;
use Tivins\Assets\Str;
use Tivins\Assets\Template;
use Tivins\Assets\Website;

class Page
{
    protected string $title = 'Modal page';
    protected string $content = '';
    protected Size $containerWidth = Size::LG;
    protected array $footerButtons = [];

    public function __construct(string $title = '', Size $containerWidth = Size::LG)
    {
        $this->title = $title;
        $this->containerWidth = $containerWidth;
    }

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

    public function setContainerWidth(Size $containerWidth): Page
    {
        $this->containerWidth = $containerWidth;
        return $this;
    }

    public function __toString(): string
    {
        $cookie = Components::boxMessage(new HTMLStr('
                  <h3 class="mt-0 mb-0">Cookies</h3>
                  <div class="my-1">Ce site n\'utilise que des cookies essentiels.</div>
                  '
        ), 'warning', 'sticky-top top-2 mt-2'
        );
        $cookie = '';
        return Template::tpl($this->title, Template::container(
            $cookie
            . Components::getHeaderBar($this->title)
            . $this->content
            . $this->getFooter()
            , $this->containerWidth
        ), true
        );
    }

    public function getFooter(): string
    {
        return Components::div("py-4 d-flex flex-center fs-80",
            Button::newGhost()
                ->setUrl(Website::getRootURL())
                ->setLabel(new Str(Website::getTitle()))
                ->setIcon(Website::getIcon())
            . Components\Button::newLink()->setUrl('/assets/legal.html')->setLabel(new Str('Terms & Privacy'))
            . ($this->containerWidth != Size::SM ? Components\Button::newLink()->setUrl('/assets/docs/')->addClasses('visible-md')->setLabel(new Str('Help & Docs')) : '')
            . Components\Button::newLink()->setUrl('/assets/contact.html')->setLabel(new Str('Contact'))
            . ($this->containerWidth != Size::SM
                ? Components\Button::newLink()
                    ->setUrl('/assets/docs/')
                    ->addClasses('visible-md pop-trigger')
                    ->setLabel(new Str('Follow us'))
                    ->setDropUp()
                    ->setDataAttr('target', '#')
                : '')
        );
    }
}