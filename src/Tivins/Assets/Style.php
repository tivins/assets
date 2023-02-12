<?php

namespace Tivins\Assets;

enum Style: string
{
    case Default = '';
    case Info = 'info';
    case Success = 'success';
    case Warning = 'warning';
    case Danger = 'danger';
    case Important = 'important';
}
