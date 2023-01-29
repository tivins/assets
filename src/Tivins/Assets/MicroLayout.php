<?php

namespace Tivins\Assets;

class MicroLayout
{
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
            <div class="d-flex-md gutter">
            <div class="col-8">'.$col1.'</div>
            <div class="col-4">'.$col2.'</div>
            </div>';
    }
    public static function col363(string $col1, string $col2, string $col3): string
    {
        return '
            <div class="d-flex-md gutter">
            <div class="col-3">'.$col1.'</div>
            <div class="col-6">'.$col2.'</div>
            <div class="col-3">'.$col3.'</div>
            </div>';
    }
}