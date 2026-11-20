<?php

declare(strict_types=1);

namespace Hwkdo\IntranetAppZentrale\Notifications;

use App\Models\User;
use Hwkdo\IntranetAppBase\Notifications\IntranetNotification;
use Hwkdo\IntranetAppZentrale\IntranetAppZentrale;
use Illuminate\Notifications\Messages\MailMessage;

class SignatureRevokedNotification extends IntranetNotification
{
    public function __construct(
        public readonly User $actor,
    ) {
        parent::__construct();
    }

    public function typeKey(): string
    {
        return 'zentrale.signature_revoked';
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ihre Unterschrift wurde widerrufen')
            ->line($this->actor->name.' hat an der Zentrale Ihre registrierte Unterschrift widerrufen.')
            ->line('Digitale Unterschriften sind damit nicht mehr möglich, bis erneut eine Unterschrift registriert wird.')
            ->action('Zentrale öffnen', route('apps.zentrale.index'));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->inboxPayload(
            title: 'Unterschrift widerrufen',
            body: $this->actor->name.' hat an der Zentrale Ihre registrierte Unterschrift widerrufen.',
            url: route('apps.zentrale.index'),
            appIdentifier: IntranetAppZentrale::identifier(),
        );
    }
}
