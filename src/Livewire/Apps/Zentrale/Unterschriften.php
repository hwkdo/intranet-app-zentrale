<?php

declare(strict_types=1);

namespace Hwkdo\IntranetAppZentrale\Livewire\Apps\Zentrale;

use Hwkdo\IntranetAppBase\Models\UserSignature;
use Hwkdo\IntranetAppBase\Models\UserSignatureEvent;
use Hwkdo\IntranetAppBase\Services\UserSignatureStore;
use Hwkdo\IntranetAppBase\Support\DatabaseUser;
use Hwkdo\IntranetAppZentrale\Notifications\SignatureRegisteredNotification;
use Hwkdo\IntranetAppZentrale\Notifications\SignatureRevokedNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Unterschriften extends Component
{
    public const PERMISSION = 'operate-app-zentrale-unterschriften';

    public ?int $userId = null;

    public string $erfassteVorschau = '';

    public string $erfassteRohdaten = '';

    public function mount(): void
    {
        abort_unless(Auth::user()?->can(self::PERMISSION), 403);
    }

    public function updatedUserId(): void
    {
        $this->erfassteVorschau = '';
        $this->erfassteRohdaten = '';
    }

    /**
     * @param  array<int, array{id: string, value: string}>  $checkboxes
     */
    #[On('signature-confirmed')]
    public function signatureConfirmed(string $img_src, string $base64, array $checkboxes = []): void
    {
        $this->erfassteVorschau = $img_src;
        $this->erfassteRohdaten = $base64;
    }

    public function registrieren(): void
    {
        $this->authorizeDesk();

        $mitarbeiter = $this->mitarbeiterOderFehler();
        if ($this->erfassteVorschau === '') {
            $this->addError('erfassteVorschau', 'Bitte erfassen Sie zuerst eine Unterschrift am Signopad.');

            return;
        }

        $actor = Auth::user();
        app(UserSignatureStore::class)->register(
            $mitarbeiter,
            $actor,
            $this->erfassteVorschau,
            $this->erfassteRohdaten !== '' ? $this->erfassteRohdaten : null,
        );

        $mitarbeiter->notify(new SignatureRegisteredNotification($actor));

        $this->erfassteVorschau = '';
        $this->erfassteRohdaten = '';

        $this->dispatch('unterschrift-registriert');
    }

    public function widerrufen(): void
    {
        $this->authorizeDesk();

        $mitarbeiter = $this->mitarbeiterOderFehler();
        $store = app(UserSignatureStore::class);
        if ($store->active($mitarbeiter) === null) {
            return;
        }

        $actor = Auth::user();
        $store->revoke($mitarbeiter, $actor);
        $mitarbeiter->notify(new SignatureRevokedNotification($actor));
    }

    /**
     * @return Collection<int, Model>
     */
    #[Computed]
    public function mitarbeiter(): Collection
    {
        $userClass = $this->userClass();

        return $userClass::query()
            ->where('active', true)
            ->orderBy('nachname')
            ->orderBy('vorname')
            ->get(['id', 'vorname', 'nachname']);
    }

    #[Computed]
    public function ausgewaehlt(): ?Model
    {
        if ($this->userId === null) {
            return null;
        }

        return $this->userClass()::query()->find($this->userId);
    }

    #[Computed]
    public function aktiveUnterschrift(): ?UserSignature
    {
        $mitarbeiter = $this->ausgewaehlt;
        if ($mitarbeiter === null) {
            return null;
        }

        return app(UserSignatureStore::class)->active($mitarbeiter)?->load('registeredBy');
    }

    #[Computed]
    public function vorschau(): ?string
    {
        $signature = $this->aktiveUnterschrift;
        if (! $signature instanceof UserSignature) {
            return null;
        }

        return app(UserSignatureStore::class)->dataUri($signature);
    }

    /**
     * @return Collection<int, UserSignatureEvent>
     */
    #[Computed]
    public function protokoll(): Collection
    {
        return UserSignatureEvent::query()
            ->with(['user', 'actor'])
            ->latest()
            ->limit(30)
            ->get();
    }

    public function render(): View
    {
        return view('intranet-app-zentrale::livewire.apps.zentrale.unterschriften');
    }

    private function authorizeDesk(): void
    {
        abort_unless(Auth::user()?->can(self::PERMISSION), 403);
    }

    private function mitarbeiterOderFehler(): Model
    {
        $mitarbeiter = $this->ausgewaehlt;
        if ($mitarbeiter === null) {
            abort(422, 'Bitte wählen Sie zuerst einen Mitarbeiter.');
        }

        return $mitarbeiter;
    }

    /**
     * @return class-string<Model>
     */
    private function userClass(): string
    {
        return DatabaseUser::model();
    }
}
