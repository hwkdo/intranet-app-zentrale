<?php

declare(strict_types=1);

namespace Hwkdo\IntranetAppZentrale;

use Hwkdo\IntranetAppBase\Data\NotificationTypeDefinition;
use Hwkdo\IntranetAppBase\Interfaces\IntranetAppInterface;
use Hwkdo\IntranetAppBase\Interfaces\ProvidesNotificationsInterface;
use Hwkdo\IntranetAppZentrale\Data\AppSettings;
use Illuminate\Support\Collection;

class IntranetAppZentrale implements IntranetAppInterface, ProvidesNotificationsInterface
{
    public static function app_name(): string
    {
        return 'Zentrale';
    }

    public static function app_icon(): string
    {
        return 'building-office';
    }

    public static function identifier(): string
    {
        return 'zentrale';
    }

    public static function roles_admin(): Collection
    {
        return collect(config('intranet-app-zentrale.roles.admin'));
    }

    public static function roles_user(): Collection
    {
        return collect(config('intranet-app-zentrale.roles.user'));
    }

    public static function userSettingsClass(): ?string
    {
        return null;
    }

    public static function appSettingsClass(): ?string
    {
        return AppSettings::class;
    }

    public static function mcpServers(): array
    {
        return [];
    }

    public static function notificationTypes(): array
    {
        return [
            new NotificationTypeDefinition(
                key: 'zentrale.signature_registered',
                label: 'Unterschrift registriert',
                appIdentifier: self::identifier(),
                appName: self::app_name(),
                description: 'Wenn an der Zentrale eine Unterschrift für Sie registriert wurde.',
                mandatory: true,
                defaultChannels: ['inbox', 'mail'],
                requiredChannels: ['inbox', 'mail'],
            ),
            new NotificationTypeDefinition(
                key: 'zentrale.signature_revoked',
                label: 'Unterschrift widerrufen',
                appIdentifier: self::identifier(),
                appName: self::app_name(),
                description: 'Wenn an der Zentrale Ihre registrierte Unterschrift widerrufen wurde.',
                mandatory: true,
                defaultChannels: ['inbox', 'mail'],
                requiredChannels: ['inbox', 'mail'],
            ),
        ];
    }
}
