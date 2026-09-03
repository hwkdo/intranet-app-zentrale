<?php

use function Livewire\Volt\{state, title};

title('Zentrale - Admin');

state(['activeTab' => 'einstellungen']);

?>

<div>
    <x-intranet-app-zentrale::zentrale-layout heading="Zentrale" subheading="Admin">
        <flux:tab.group>
            <flux:tabs wire:model="activeTab">
                <flux:tab name="einstellungen" icon="cog-6-tooth">Einstellungen</flux:tab>
                <flux:tab name="hintergrundbild" icon="photo">Hintergrundbild</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="einstellungen">
                <div class="mt-4 min-h-[200px]">
                    @livewire('intranet-app-base::admin-settings', [
                        'appIdentifier' => 'zentrale',
                        'settingsModelClass' => '\Hwkdo\IntranetAppZentrale\Models\IntranetAppZentraleSettings',
                        'appSettingsClass' => '\Hwkdo\IntranetAppZentrale\Data\AppSettings',
                    ])
                </div>
            </flux:tab.panel>

            <flux:tab.panel name="hintergrundbild">
                <div class="mt-4 min-h-[200px]">
                    @livewire('intranet-app-base::app-background-image', [
                        'appIdentifier' => 'zentrale',
                    ])
                </div>
            </flux:tab.panel>
        </flux:tab.group>
    </x-intranet-app-zentrale::zentrale-layout>
</div>
