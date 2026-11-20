<div>
    <x-intranet-app-zentrale::zentrale-layout heading="Benachrichtigungen" subheading="Legen Sie fest, worüber Sie in dieser App informiert werden.">
        <section class="glass-card overflow-hidden p-5">
            @livewire('intranet-app-base::notification-settings', ['appIdentifier' => 'zentrale'])
        </section>
    </x-intranet-app-zentrale::zentrale-layout>
</div>
