<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\Box;
/*
 *
    $card3 = (new Box())
        ->setFooter(
            '
            <a href="#" class="p col-4 py-2 button ghost text-center"><i class="fa-regular fa-envelope d-block"></i></a>
            <a href="#" class="p col-4 py-2 mx-1 button success text-center"><i class="fa fa-phone d-block"></i></a>
            <a href="#" class="p col-4 py-2 button ghost text-center"><i class="fa fa-globe-americas d-block"></i></a>
            '
        )
        ->addHTML('
                <div class="pr-3 text-center">
                  <img src="https://i.stack.imgur.com/2EeK7.png" width="64" class="rounded" alt="user-avatar"/>
                 <!-- <hr>
                  <div class="fs-80"><i class="fa-regular fa-handshake"></i><br>86%</div>-->
                </div>
                <div class="flex-grow">
                  <b class="fs-120">John Doe</b>
                  <div class="subtext-2">real estate agent</div>
                  <div class="my-2 fs-90"><span class="fs-90">123 Anywhere on Earth St.,</span><br>Another City, ST 12354<br>CA, Country</div>
                  <div class="subtext-2"><i class="fa-regular fa-calendar mr-1"></i>joined on 2023</div>
                </div>
              ');
 */
class Card extends Box
{
    public string   $userName;
    public string   $text;
    protected array $footerButtons = [];
    protected Icon $cardIcon;


    public function __construct(string $title = '', string $text = '')
    {
        $this->text  = $text;
        $this->userName = $title;
        $this->cardIcon = new Icon('user', margin: 'none');
        $this->cardIcon->classes[] = 'fa-fw';
        $this->cardIcon->classes[] = 'fa-2x';
        $this->cardIcon->classes[] = 'muted-2';
        // <i class='fa fa-fw fa-2x fa-user muted-3'></i>
        $this->setBodyClasses('p d-flex');
        /*$this->setFooter(
                '
                        <a href="#" class="p">follow</a>
                        <a href="#" class="p"><i class="fa fa-code-fork mr-1"></i>fork</a>
                        '
            );*/
    }
    public function addFooterLink(Button $button): static {
        $this->addFooter($button);
        return $this;
    }
    public function __toString(): string
    {
        $this->setHTML('
                <div class="pr-3 text-center">
                  '.$this->cardIcon.'
                  <hr>
                  <div class="fs-80"><i class="fa-regular fa-star"></i><br>24</div> 
                </div>
                <div class="flex-grow">
                  <b>'.$this->userName.'</b><br>
                  <div class="my-2 fs-90">'.$this->text.'</div>
                  <div class="subtext-2"><i class="fa-regular fa-calendar mr-1"></i>created on 2023</div>
                </div>
              '
        );
        return parent::__toString();
    }

    public function setUserName(string $userName): static
    {
        $this->userName = $userName;
        return $this;
    }

    public function setText(string $text): Card
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param string $icon
     * @return Card
     */
    public function setCardIcon(string $icon): static
    {
        $this->cardIcon->icon = $icon;
        return $this;
    }


}