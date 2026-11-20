<div class="space-y-6">
    <section class="glass-card overflow-hidden">
        <div class="flex items-start gap-3 border-b border-[#d0e3f9] px-5 py-4 dark:border-white/10">
            <div class="flex size-10 items-center justify-center rounded-xl bg-[#073070]/10 text-[#073070] dark:bg-white/10 dark:text-white">
                <flux:icon.pencil-square class="size-5" />
            </div>
            <div>
                <flux:heading size="lg">Unterschrift registrieren</flux:heading>
                <flux:text class="text-slate-600 dark:text-white/70">Erfassen Sie am Signopad die Unterschrift eines Mitarbeiters. Der Vorgang wird protokolliert.</flux:text>
            </div>
        </div>

        <div class="space-y-5 px-5 py-5">
            <flux:field>
                <flux:label>Mitarbeiter</flux:label>
                <flux:select variant="listbox" searchable wire:model.live="userId" placeholder="Mitarbeiter suchen…">
                    @foreach ($this->mitarbeiter as $mitarbeiter)
                        <flux:select.option value="{{ $mitarbeiter->id }}">{{ $mitarbeiter->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>

            @if ($this->ausgewaehlt)
                <div class="rounded-xl bg-white/70 p-4 ring-1 ring-[#d0e3f9] dark:bg-white/5 dark:ring-white/10">
                    @if ($this->aktiveUnterschrift)
                        <flux:text class="text-slate-600 dark:text-white/70">
                            Registriert am {{ $this->aktiveUnterschrift->registered_at?->timezone(config('app.timezone'))->format('d.m.Y H:i') }}
                            durch {{ $this->aktiveUnterschrift->registeredBy?->name ?? 'unbekannt' }}.
                        </flux:text>
                        @if ($this->vorschau)
                            <img src="{{ $this->vorschau }}" alt="Registrierte Unterschrift" class="mt-3 h-16 w-auto rounded bg-white p-2">
                        @endif
                        <div class="mt-3">
                            <flux:button
                                size="sm"
                                variant="danger"
                                icon="x-mark"
                                wire:click="widerrufen"
                                wire:confirm="Die registrierte Unterschrift von {{ $this->ausgewaehlt->name }} wirklich widerrufen?"
                            >
                                Unterschrift widerrufen
                            </flux:button>
                        </div>
                    @else
                        <flux:text class="text-slate-600 dark:text-white/70">Für {{ $this->ausgewaehlt->name }} ist noch keine Unterschrift registriert.</flux:text>
                    @endif
                </div>

                <div>
                    <flux:heading size="sm" class="mb-2">Neue Unterschrift erfassen</flux:heading>
                    <livewire:signopad.signpad :key="'signopad-'.$userId" />
                    <flux:error name="erfassteVorschau" />
                    @if ($erfassteVorschau !== '')
                        <img src="{{ $erfassteVorschau }}" alt="Erfasste Unterschrift" class="mt-3 h-16 w-auto rounded bg-white p-2">
                        <div class="mt-3">
                            <flux:button variant="primary" icon="check" wire:click="registrieren">
                                Unterschrift für {{ $this->ausgewaehlt->name }} registrieren
                            </flux:button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <section class="glass-card overflow-hidden">
        <div class="border-b border-[#d0e3f9] px-5 py-4 dark:border-white/10">
            <flux:heading size="lg">Protokoll</flux:heading>
            <flux:text class="text-slate-600 dark:text-white/70">Wer hat für wen eine Unterschrift registriert, widerrufen oder verwendet.</flux:text>
        </div>
        <div class="divide-y divide-[#d0e3f9] dark:divide-white/10">
            @forelse ($this->protokoll as $eintrag)
                <div class="flex flex-wrap items-baseline justify-between gap-2 px-5 py-3 text-sm">
                    <div>
                        <span class="font-medium text-[#073070] dark:text-white">{{ $eintrag->action->label() }}</span>
                        <span class="text-slate-600 dark:text-white/70">
                            für {{ $eintrag->user?->name ?? 'unbekannt' }}
                            durch {{ $eintrag->actor?->name ?? 'unbekannt' }}
                            @if (filled($eintrag->context))
                                · {{ $eintrag->context }}
                            @endif
                        </span>
                    </div>
                    <span class="text-slate-500 dark:text-white/50">{{ $eintrag->created_at?->timezone(config('app.timezone'))->format('d.m.Y H:i') }}</span>
                </div>
            @empty
                <div class="px-5 py-8 text-center text-slate-600 dark:text-white/70">Noch keine Einträge.</div>
            @endforelse
        </div>
    </section>
</div>
