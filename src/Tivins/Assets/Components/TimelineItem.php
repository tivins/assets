<?php

namespace Tivins\Assets\Components;

class TimelineItem
{
    public function __construct(
        public int $timestamp,
        public string $title,
        public string $description,
    )
    {
    }
}