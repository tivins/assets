<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\Components;
use Tivins\Assets\Str;

class HeaderBar extends HTMLElement
{
    public Str $title;
    public Str $subTitle;
    public Button $button;

    public function __construct()
    {
        parent::__construct('div');
    }
    
    public function __toString(): string
    {
        $head = '<h1 class="my-0">'.$this->title.'</h1>'
            .Components::subText($this->subTitle)
        ;
        $content = Components::div('d-flex mb flex-align-top',''
            . Components::div('flex-grow', $head)
            . $this->button
        );
        return $content; // parent::__toString();
    }

    /**
     * @return Str
     */
    public function getTitle(): Str
    {
        return $this->title;
    }

    /**
     * @param Str $title
     * @return HeaderBar
     */
    public function setTitle(Str $title): HeaderBar
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return Str
     */
    public function getSubTitle(): Str
    {
        return $this->subTitle;
    }

    /**
     * @param Str $subTitle
     * @return HeaderBar
     */
    public function setSubTitle(Str $subTitle): HeaderBar
    {
        $this->subTitle = $subTitle;
        return $this;
    }

    /**
     * @return Button
     */
    public function getButton(): Button
    {
        return $this->button;
    }

    /**
     * @param Button $button
     * @return HeaderBar
     */
    public function setButton(Button $button): HeaderBar
    {
        $this->button = $button;
        return $this;
    }


}