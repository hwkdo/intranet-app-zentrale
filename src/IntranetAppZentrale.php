<?php

declare(strict_types=1);

namespace Hwkdo\IntranetAppZentrale;

use Hwkdo\IntranetAppBase\Interfaces\IntranetAppInterface;
use Illuminate\Support\Collection;

class IntranetAppZentrale implements IntranetAppInterface
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
        return \Hwkdo\IntranetAppZentrale\Data\AppSettings::class;
    }

    public static function mcpServers(): array
    {
        return [];
    }
}
