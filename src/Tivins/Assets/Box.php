<?php

namespace Tivins\Assets;

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
    private array $boxClasses = ['mb-3'];
    /** @var string[] */
    private array $headerClasses = [];

    private string $footer = '';
    private string $icon = '';

    public function setBackURL(string $url): static
    {
        $this->backURL = $url;
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

    public function setFooter(string $v): static
    {
        $this->footer = $v;
        return $this;
    }

    public function render(): string
    {
        $backLink = $this->backURL
            ? '<a href="' . $this->backURL . '" class="header-item" title="back"><i class="fa fa-fw fa-chevron-left" aria-hidden="true"></i></a>'
            : '';

        $header = '<div class="header ' . join(' ', $this->headerClasses) . '">'
            . $backLink
            . join($this->leftLinks)
            . '<span class="title header-item">'
                . ($this->icon ? '<i class="fa-fw '.$this->icon.' op-05"></i>' : '')
                . ($this->title)
                . '</span>'
            . join($this->rightLinks)
            . '</div>';

        return '<div class="box ' . join(' ', $this->boxClasses) . '">'
            . $header
            . '<div class="body ' . join(' ', $this->bodyClasses) . '">' . $this->body . '</div>'
            . '<div class="footer no-background fs-90">' . $this->footer . '</div>'
            . '</div>';
    }
}