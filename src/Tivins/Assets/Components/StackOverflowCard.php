<?php

namespace Tivins\Assets\Components;

class StackOverflowCard extends Card
{
    public function __construct()
    {
        parent::__construct();
        $this->cardIcon->class = 'brands';
        $this->cardIcon->icon = 'stack-overflow';
    }
}