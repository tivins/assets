<?php

namespace Tivins\Assets;

enum Style: string
{
    case Default = '';
    case Success = 'success';
    case Danger = 'danger';
    case Warning = 'warning';
    case Info = 'info';
}
