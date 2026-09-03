<?php

use function Livewire\Volt\{title};

title('Zentrale - App-Info');

?>

<div>
<x-intranet-app-zentrale::zentrale-layout heading="App-Info" subheading="Installierte Version und Release-Historie">
    @livewire('intranet-app-base::app-info', ['appIdentifier' => 'zentrale'])
</x-intranet-app-zentrale::zentrale-layout>
</div>
