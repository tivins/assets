<?php

namespace Tivins\Assets;

use Tivins\Core\StrUtil;

class Box
{
    private ?string $backURL = '';
    private string  $body = '';
    private string  $title = '';
    /** @var string[] */
    private array   $leftLinks = [];
    /** @var string[] */
    private array   $rightLinks = [];
    /** @var string[] */
    private array $bodyClasses = [];
    /** @var string[] */
    private array $boxClasses = ['mb-3'];
    /** @var string[] */
    private array $headerClasses = [];

    private string $footer = '';

    public function setBackURL(string $url): static {
        $this->backURL = $url;
        return $this;
    }
    public function addHTML(string $html): void
    {
        $this->body .= $html;
    }
    public function addText(string $html): void
    {
        $this->body .= htmlentities($html);
    }
    public function setTitle(string $title): static {
        $this->title = $title;
        return $this;
    }

    public function addHeaderInfo(string $html): static {
        $this->leftLinks[] = $html;
        return $this;

    }
    public function addHeaderOption(string $html): static {
        $this->rightLinks[] = $html;
        return $this;
    }
    public function setBoxClasses(string ...$classes): static {
        $this->boxClasses = $classes;
        return $this;
    }
    public function setBodyClasses(string ...$classes): static {
        $this->bodyClasses = $classes;
        return $this;
    }
    public function setHeaderClasses(string ...$classes): static {
        $this->headerClasses = $classes;
        return $this;
    }
    public function setFooter(string $v): static {
        $this->footer = $v;
        return $this;
    }

    public function render(): string
    {
        return '
  <div class="box '.join(' ', $this->boxClasses).'">
    <div class="header '.join(' ', $this->headerClasses).'">
      '.(
          $this->backURL
            ? '<a href="'.$this->backURL.'" class="header-item" title="back"><i class="fa fa-fw fa-chevron-left" aria-hidden="true"></i></a>'
            : ''
        ).'
      '.join($this->leftLinks).'
      <span class="title header-item">'.StrUtil::html($this->title).'</span>
      '.join($this->rightLinks).'
      <!--<a href="#" class="header-item"><i class="fa fa-fw fa-ellipsis-h" aria-hidden="true" title="Search"></i></a>-->
    </div>
    <div class="body '.join(' ', $this->bodyClasses).'">' . $this->body . '</div>
    <div class="footer no-background fs-90">
      '.$this->footer.'
    </div>
  </div>';
    }
}