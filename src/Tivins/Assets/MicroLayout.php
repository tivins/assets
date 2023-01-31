<?php

namespace Tivins\Assets;

use Tivins\Assets\Components\HTMLElement;

class MicroLayout
{
    /**
     * @var int[]
     */
    public array $columnConfig = [];
    /**
     * @var string[]
     */
    public array $columnContent = [];
    public Size  $gutterSize    = Size::NONE;
    public Size  $screenSize    = Size::MD;

    /**
     * @param int[] $config
     */
    public function __construct(array $config)
    {
        $this->columnConfig = $config;
    }

    public function setGutterSize(Size $gutterSize): MicroLayout
    {
        $this->gutterSize = $gutterSize;
        return $this;
    }

    public function setScreenSize(Size $screenSize): MicroLayout
    {
        $this->screenSize = $screenSize;
        return $this;
    }


    public function setColumnContent(int $index, string $content): static
    {
        $this->columnContent[$index] = $content;
        return $this;
    }

    public function __toString(): string
    {
        $html = '';/*
        . '<div class="col-2">' . $col1 . '</div>'
    . '<div class="col-8">' . $col2 . '</div>'
    . '<div class="col-2">' . $col3 . '</div>';
        */
        foreach ($this->columnConfig as $key => $size) {
            $html .= Components::div('col-' . $size, $this->columnContent[$key]);
        }
        $classes = [
            $this->screenSize->suffix('d-flex'),
            $this->gutterSize->suffix('gutter'),
        ];
        return Components::div($classes, $html);
    }

    //---------------------------
    public static function col84GutterBorder(string $col1, string $col2): string
    {
        return '<div class="d-flex-md">'
            . '<div class="col-8 pr-md-3">' . $col1 . '</div>'
            . '<div class="col-4 pl-md-3 b-left-md b-top-sm">' . $col2 . '</div>'
            . '</div>';
    }
    public static function col84Gutter(string $col1, string $col2): string
    {
        return '
            <div class="d-flex-md gutter-sm">
            <div class="col-8">'.$col1.'</div>
            <div class="col-4">'.$col2.'</div>
            </div>';
    }
    public static function col363(string $col1, string $col2, string $col3): string
    {
        return '<div class="d-flex-md gutter-sm">'
            . '<div class="col-2">' . $col1 . '</div>'
            . '<div class="col-8">' . $col2 . '</div>'
            . '<div class="col-2">' . $col3 . '</div>'
            . '</div>';
    }
}