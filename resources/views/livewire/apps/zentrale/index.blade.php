<?php

use function Livewire\Volt\{mount, state, title};

title('Zentrale');

state(['activeTab' => 'assets']);

mount(function (): void {
    $user = auth()->user();

    if ($user?->can('see-app-assets-zentrale')) {
        $this->activeTab = 'assets';

        return;
    }

    if ($user?->can('operate-app-fuhrpark-zentrale') || $user?->can('fuhrpark.operate-desk')) {
        $this->activeTab = 'fuhrpark';
    }
});

?>

<div>
    <x-intranet-app-zentrale::zentrale-layout
        heading="Zentrale"
        subheading="Ausgabe und Übergaben"
    >
        <flux:tab.group>
            <flux:tabs wire:model.live="activeTab">
                @if (auth()->user()?->can('see-app-assets-zentrale'))
                    <flux:tab name="assets" icon="server-stack">Assets</flux:tab>
                @endif
                @if (auth()->user()?->can('operate-app-fuhrpark-zentrale') || auth()->user()?->can('fuhrpark.operate-desk'))
                    <flux:tab name="fuhrpark" icon="truck">Fuhrpark</flux:tab>
                @endif
            </flux:tabs>

            @if (auth()->user()?->can('see-app-assets-zentrale'))
                <flux:tab.panel name="assets">
                    <div class="mt-4" wire:key="hub-assets-{{ $activeTab }}">
                        @if ($activeTab === 'assets')
                            <livewire:intranet-app-assets::apps.assets.zentrale
                                :embedded="true"
                                :key="'hub-assets-zentrale'"
                            />
                        @endif
                    </div>
                </flux:tab.panel>
            @endif

            @if (auth()->user()?->can('operate-app-fuhrpark-zentrale') || auth()->user()?->can('fuhrpark.operate-desk'))
                <flux:tab.panel name="fuhrpark">
                    <div class="mt-4" wire:key="hub-fuhrpark-{{ $activeTab }}">
                        @if ($activeTab === 'fuhrpark')
                            @livewire('apps.fuhrpark.desk', ['embedded' => true], key('hub-fuhrpark-desk'))
                        @endif
                    </div>
                </flux:tab.panel>
            @endif
        </flux:tab.group>

        @if (
            ! auth()->user()?->can('see-app-assets-zentrale')
            && ! auth()->user()?->can('operate-app-fuhrpark-zentrale')
            && ! auth()->user()?->can('fuhrpark.operate-desk')
        )
            <flux:callout variant="warning" icon="exclamation-triangle" class="mt-4">
                <flux:callout.text>
                    Es sind keine Zentrale-Rechte für Assets oder Fuhrpark vorhanden.
                </flux:callout.text>
            </flux:callout>
        @endif
    </x-intranet-app-zentrale::zentrale-layout>
</div>
