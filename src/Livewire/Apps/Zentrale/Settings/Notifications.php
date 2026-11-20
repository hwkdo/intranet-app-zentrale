<?php

declare(strict_types=1);

namespace Hwkdo\IntranetAppZentrale\Livewire\Apps\Zentrale\Settings;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Zentrale – Benachrichtigungen')]
class Notifications extends Component
{
    public function render(): View
    {
        return view('intranet-app-zentrale::livewire.apps.zentrale.settings.notifications');
    }
}
