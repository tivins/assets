<?php

namespace Tivins\Assets\Structures;

use Tivins\Assets\Components;
use Tivins\Assets\Components\Button;
use Tivins\Assets\Components\HeaderBar;
use Tivins\Assets\Components\Icon;
use Tivins\Assets\Components\Message;
use Tivins\Assets\HDirection;
use Tivins\Assets\LinkList;
use Tivins\Assets\ListItem;
use Tivins\Assets\ListSeparator;
use Tivins\Assets\Size;
use Tivins\Assets\Str as S;
use Tivins\Assets\Template;
use Tivins\Assets\Website;

class Page
{
    protected string    $title          = 'Modal page';
    protected string    $content        = '';
    protected Size      $containerWidth = Size::LG;
    protected HeaderBar $headerBar;
    protected array     $footerButtons  = [];

    public function __construct(string $title = '', Size $containerWidth = Size::LG)
    {
        $this->title          = $title;
        $this->containerWidth = $containerWidth;
        $this->headerBar      = new HeaderBar($title);
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

    public function setContainerWidth(Size $containerWidth): static
    {
        $this->containerWidth = $containerWidth;
        return $this;
    }

    public function __toString(): string
    {
        $cookie =
            (new Message('warning', 'cookie-bite', ''))
                ->setTitle('Your privacy')
                ->addHTML('By clicking “Accept all cookies”, you agree we can store cookies on your device and disclose information in accordance with our Cookie Policy.')
                ->addButton(
                    Button::new()
                        ->setLabel(S::plain('Accept all cookies'))
                        ->addClasses('info btn-action mr-1')
                        ->setDataAttr('action', 'GDPR-accept')
                )
                ->addButton(
                    Button::newLink()
                        ->addClasses('btn-action')
                        ->setLabel(S::plain('Reject all cookies'))
                        ->setDataAttr('action', 'GDPR-reject')
                )
                ->addButton(
                    Button::newLink()
                        ->addClasses('btn-action')
                        ->setLabel(S::plain('Customize settings'))
                        ->setDataAttr('action', 'GDPR-setup')
                );
        /*    . Components::boxMessage(
            S::html('
                      <b class="d-block">Your privacy</b>
                      <div class="my-2 fs-90">By clicking “Accept all cookies”, you agree we can store cookies on your device and disclose information in accordance with our Cookie Policy.</div>
              <div class="d-flex fs-80">'
            . (new Button())->setLabel(new S('Accept all cookies'))->addClasses('info mr-1')
            . Button::newLink()->setLabel(new S('Reject all cookies'))
            . Button::newLink()->setLabel(new S('Customize settings'))
                .'</div>'
            ),
            'warning',
            'sticky-top top-2 my-2',
            closable: false
        )
            ->addHeaderInfo(
                Components::div('header-item w-4 text-center pr-0',
                    new Icon('cookie-bite  fs-200', margin: 'none')
                )
            )
            ->setFooterClasses('no-background p-1');
        */
        $info =
            (new Message('info', 'info', ''))
                ->setTitle('Données factices')
                ->addHTML('Cette page utilise des données factices');
        /*Components::boxMessage(new HTMLStr('
        <b class="d-block">Données factices</b>
        <div class="my-2 fs-90">Cette page utilise des données factices.</div>
        '))
        ->addHeaderInfo(
            Components::div('header-item w-4 text-center pr-0',
                new Icon('info  fs-200', margin: 'none')
            )
        )
        ->setBoxClasses('box-info my-2');
        */

        $GDPR = $_COOKIE['GDPR'] ?? 'undefined';

        $messages = '';
        if ($GDPR == 'undefined') {
            $messages .= $cookie;
        }
        //$messages .= $info;

        // $cookie = '';
        return Template::tpl($this->title, Template::container(
            $messages
            . $this->headerBar
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
                ->setLabel(new S(Website::getTitle()))
                ->setIcon(Website::getIcon())
            . Button::newLink()->setUrl('/assets/legal.html')->setLabel(new S('Terms & Privacy'))
            . ($this->containerWidth != Size::SM ? Button::newLink()->setUrl('/assets/docs/')->addClasses('visible-md')->setLabel(new S('Help & Docs')) : '')
            . Button::newLink()->setUrl('/assets/contact.html')->setLabel(new S('Contact'))
            . ($this->containerWidth != Size::SM
                ? Button::newLink()
                    ->setUrl('/assets/docs/')
                    ->addClasses('visible-md pop-trigger')
                    ->setLabel(new S('Follow us'))
                    ->setDropDir(HDirection::Up)
                    ->setDataAttr('target', '.pop-follow')
                : '')
            . (new LinkList(Size::SM))
                ->addClasses('pop-follow hidden')
                ->push(
                    new ListSeparator('Follow us on'),
                    new ListItem('StackOverflow', '', '#', 'fa-brands fa-stack-overflow'),
                    new ListItem('GitHub', '', '#', 'fa-brands fa-github'),
                    new ListItem('Google', '', '#', 'fa-brands fa-google'),
                )
        );
    }

    public function getHeaderBar(): HeaderBar
    {
        return $this->headerBar;
    }

    /**
     * Replace the current header bar by the given one.
     */
    public function setHeaderBar(HeaderBar $headerBar): static
    {
        $this->headerBar = $headerBar;
        return $this;
    }

}