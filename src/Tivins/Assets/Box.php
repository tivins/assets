<?php

namespace Tivins\Assets;

use Tivins\Assets\Components\Button;
use Tivins\Assets\Components\Icon;
use Tivins\Core\StrUtil;

class Box
{
    private ?string $backURL = '';
    private string  $body    = '';
    private Str|string  $title   = '';
    /** @var string[] */
    private array $leftLinks = [];
    /** @var string[] */
    private array $rightLinks = [];
    /** @var string[] */
    private array $bodyClasses = [];
    /** @var string[] */
    private array $boxClasses = ['mb'];
    /** @var string[] */
    private array $headerClasses = [];
    /** @var string[] */
    private array $footerClasses = [];

    private string $footer = '';

    /**
     * @var string
     * @todo Change type Icon.
     */
    private string $icon = '';

    public function setBackURL(string $url): static
    {
        $this->backURL = $url;
        return $this;
    }

    public function setHTML(string $html): static
    {
        $this->body = $html;
        return $this;
    }

    public function addHTML(string $html): static
    {
        $this->body .= $html;
        return $this;
    }

    public function addText(string $html): static
    {
        $this->body .= htmlentities($html);
        return $this;
    }

    public function setTitleHTML(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function setTitle(string $title): static
    {
        $this->title = StrUtil::html($title);
        return $this;
    }

    public function setIcon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function addHeaderInfo(string $html): static
    {
        $this->leftLinks[] = $html;
        return $this;

    }

    public function addHeaderOption(string $html): static
    {
        $this->rightLinks[] = $html;
        return $this;
    }

    public function setBoxClasses(string ...$classes): static
    {
        $this->boxClasses = $classes;
        return $this;
    }

    public function setBodyClasses(string ...$classes): static
    {
        $this->bodyClasses = $classes;
        return $this;
    }

    public function setHeaderClasses(string ...$classes): static
    {
        $this->headerClasses = $classes;
        return $this;
    }

    public function setFooterClasses(string ...$classes): static
    {
        $this->footerClasses = $classes;
        return $this;
    }

    public function setFooter(string $v): static
    {
        $this->footer = $v;
        return $this;
    }

    public function addFooter(string $v): static
    {
        $this->footer .= $v;
        return $this;
    }

    public function __toString(): string
    {
        $backLink = $this->backURL
            ? (new Button())
                ->setClasses('header-item')
                ->setTitle('Back')
                ->setUrl($this->backURL)
                ->setIcon(new Icon('chevron-left', mutedLevel: 0, margin: 'none'))
            : '';

        $header = '';
        if ($this->title || !empty($this->rightLinks) || !empty($this->leftLinks) || $this->icon) {
            $header = '<div class="header ' . join(' ', $this->headerClasses) . '">'
                . $backLink
                . join($this->leftLinks)
                . '<span class="title header-item">'
                . ($this->icon ? '<i class="fa-fw ' . $this->icon . ' op-025"></i>' : '')
                . ($this->title)
                . '</span>'
                . join($this->rightLinks)
                . '</div>';
        }

        $boxClasses = array_merge(['box'], $this->boxClasses);
        $bodyClasses = array_merge(['body'], $this->bodyClasses);
        $footerClasses = array_merge(['footer', 'fs-90'], $this->footerClasses);
        return Components::div(
            $boxClasses,
            $header
            . Components::div($bodyClasses, $this->body)
            . ($this->footer ? Components::div($footerClasses, $this->footer) : '')
        );
    }
}