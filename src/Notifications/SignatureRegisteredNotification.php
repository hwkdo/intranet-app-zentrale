<?php

declare(strict_types=1);

namespace Hwkdo\IntranetAppZentrale\Notifications;

use App\Models\User;
use Hwkdo\IntranetAppBase\Notifications\IntranetNotification;
use Hwkdo\IntranetAppZentrale\IntranetAppZentrale;
use Illuminate\Notifications\Messages\MailMessage;

class SignatureRegisteredNotification extends IntranetNotification
{
    public function __construct(
        public readonly User $actor,
    ) {
        parent::__construct();
    }

    public function typeKey(): string
    {
        return 'zentrale.signature_registered';
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ihre Unterschrift wurde registriert')
            ->line($this->actor->name.' hat an der Zentrale eine Unterschrift für Sie registriert.')
            ->line('Mit dieser Unterschrift können Sie Dokumente im Intranet digital unterschreiben, zum Beispiel einen Auftragsschein.')
            ->action('Zentrale öffnen', route('apps.zentrale.index'));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->inboxPayload(
            title: 'Unterschrift registriert',
            body: $this->actor->name.' hat an der Zentrale eine Unterschrift für Sie registriert.',
            url: route('apps.zentrale.index'),
            appIdentifier: IntranetAppZentrale::identifier(),
        );
    }
}
