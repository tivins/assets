<?php

namespace Tivins\Assets\Stylesheet;

enum Property: string
{
    case fontSize = 'font-size';
    case fontFamily = 'font-family';
    case lineHeight = 'line-height';
    case webkitTextSizeAdjust = '-webkit-text-size-adjust';
    case margin = 'margin';
    case marginLeft = 'margin-left';
    case marginRight = 'margin-right';
    case marginBottom = 'margin-bottom';
    case marginTop = 'margin-top';
    case padding = 'padding';
    case paddingLeft = 'padding-left';
    case paddingRight = 'padding-right';
    case paddingBottom = 'padding-bottom';
    case paddingTop = 'padding-top';
    case display = 'display';
    case boxSizing = 'box-sizing';
    case height = 'height';
    case overflow = 'overflow';
}
