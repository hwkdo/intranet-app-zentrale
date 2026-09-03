@props([
    'heading' => '',
    'subheading' => '',
    'navItems' => [],
    'renderAppIndexAuto' => null,
])

@php
    $defaultNavItems = [
        [
            'label' => 'Zentrale',
            'href' => route('apps.zentrale.index'),
            'icon' => 'building-office',
            'description' => 'Assets- und Fuhrpark-Zentrale',
            'buttonText' => 'Zentrale öffnen',
            'welcomeSection' => 'main',
        ],
        [
            'label' => 'App-Info',
            'href' => route('apps.zentrale.info'),
            'icon' => 'information-circle',
            'description' => 'Installierte Version und Release-Historie',
            'buttonText' => 'App-Info anzeigen',
            'welcomeSection' => 'settings',
        ],
        [
            'label' => 'Admin',
            'href' => route('apps.zentrale.admin.index'),
            'icon' => 'shield-check',
            'description' => 'App-Einstellungen',
            'buttonText' => 'Admin öffnen',
            'permission' => 'manage-app-zentrale',
            'welcomeSection' => 'settings',
        ],
    ];

    $navItems = ! empty($navItems) ? $navItems : $defaultNavItems;
    $customBgUrl = \Hwkdo\IntranetAppBase\Models\AppBackground::getCustomBackgroundUrl('zentrale');
    $shouldRenderAppIndexAuto = $renderAppIndexAuto ?? false;
@endphp

@if($customBgUrl)
    @push('app-styles')
    <style data-app-bg data-ts="{{ uniqid() }}">
        :root { --app-bg-image: url('{{ $customBgUrl }}'); }
    </style>
    @endpush
@endif

@if($shouldRenderAppIndexAuto)
    <x-intranet-app-base::app-layout
        app-identifier="zentrale"
        :heading="$heading"
        :subheading="$subheading"
        :nav-items="$navItems"
        :wrap-in-card="false"
    >
        <x-intranet-app-base::app-index-auto
            app-identifier="zentrale"
            app-name="Zentrale"
            app-description="Zentrale Ausgabe und Übergaben für Assets und Fuhrpark"
            :nav-items="$navItems"
            welcome-title="Willkommen in der Zentrale"
            welcome-description="Hier erledigen Sie Ausgabe und Übergaben für Assets und Fuhrpark an einem Ort."
        />
    </x-intranet-app-base::app-layout>
@else
    <x-intranet-app-base::app-layout
        app-identifier="zentrale"
        :heading="$heading"
        :subheading="$subheading"
        :nav-items="$navItems"
        :wrap-in-card="true"
    >
        {{ $slot }}
    </x-intranet-app-base::app-layout>
@endif
