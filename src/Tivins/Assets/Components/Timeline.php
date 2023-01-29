<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\Components;

class Timeline
{
    /** @var TimelineItem[] */
    private array $elements = [];

    public function __construct()
    {
    }

    public function addItem(TimelineItem $item) {
        $this->elements[] = $item;
    }

    public function __toString(): string
    {
        usort($this->elements,
            fn(TimelineItem $a, TimelineItem $b) => $b->timestamp <=> $a->timestamp);

        $html = '';
        foreach ($this->elements as $element) {
            $html .= '<div class="timeline-item">'
                . '<div class="date">'.date('F jS, Y',$element->timestamp).'</div>'
                . '<div class="title">'.$element->title.'</div>'
                . '<div class="text">'.$element->description.'</div>'
                .'</div>';
        }
        return Components::div('timeline', $html);
    }
}