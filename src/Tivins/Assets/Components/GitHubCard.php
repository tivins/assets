<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\Str;

class GitHubCard extends Card
{
    public function __construct()
    {
        parent::__construct();
        $this->cardIcon->class = 'brands';
        $this->cardIcon->icon = 'github';
        $this->addFooterLink(
            (Button::newLink())
                ->setIcon(new Icon('star', 'regular'))
                ->setLabel(new Str('8'))
                ->setUrl('https://github.com/tivins/database/star')
        );
        $this->addFooterLink(
            (Button::newLink())
                ->setLabel(new Str('fork'))
                ->setIcon(new Icon('code-fork'))
                ->setUrl('https://github.com/tivins/database/fork')
        );
    }
}