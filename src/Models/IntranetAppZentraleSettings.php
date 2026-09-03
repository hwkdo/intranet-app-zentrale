<?php

declare(strict_types=1);

namespace Hwkdo\IntranetAppZentrale\Models;

use Hwkdo\IntranetAppZentrale\Data\AppSettings;
use Illuminate\Database\Eloquent\Model;

class IntranetAppZentraleSettings extends Model
{
    protected $table = 'intranet_app_zentrale_settings';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'settings' => AppSettings::class.':default',
        ];
    }

    public static function current(): ?IntranetAppZentraleSettings
    {
        return self::query()->orderByDesc('version')->first();
    }
}
