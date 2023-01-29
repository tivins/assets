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
            (new Button())
                ->setClasses('ghost')
            ->setLabel(new Str('follow'))
        );
    }
}