<?php

declare(strict_types=1);

namespace Hwkdo\IntranetAppZentrale\Data;

use Hwkdo\IntranetAppBase\Data\Attributes\Description;
use Hwkdo\IntranetAppBase\Data\BaseAppSettings;

class AppSettings extends BaseAppSettings
{
    public function __construct(
        #[Description('Hinweistext auf der Zentrale-Übersicht (optional)')]
        public string $hinweis = '',
    ) {}
}
