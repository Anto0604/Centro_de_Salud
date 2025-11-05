<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800 flex">


    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>DASHBOARD</flux:navlist.item>
                <flux:navlist.item icon="users" :href="route('pacientes.index')"
                    :current="request()->routeIs('pacientes.index')" wire:navigate>PACIENTES
                </flux:navlist.item>
               
                @role('Administrador')
                    <flux:navlist.item icon="users" :href="route('users.index')"
                        :current="request()->routeIs('users.index')" wire:navigate>USUARIOS
                    </flux:navlist.item>
              @endrole

            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />


    </flux:sidebar>

    <div class="flex flex-col flex-1 overflow-hidden">


        <flux:header
            class="border-b border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 z-10 h-16 flex items-center px-4">

            <flux:sidebar.toggle class="lg:hidden me-4" icon="bars-3" />
            @php
                $routeName = request()->route()->getName() ?? '';
                $pageTitles = [
                    'dashboard' => 'Dashboard',
                    'pacientes.index' => 'Pacientes',
                    'users.index' => 'Usuarios',
                    'profile.edit' => 'Perfil',
                    'settings' => 'Configuración',
                    'appearance.edit' => 'Apariencia',
                    'password.edit' => 'Contraseña',
                    'two-factor.show' => 'Autenticación de dos factores',
                ];
                $pageTitle = $pageTitles[$routeName] ?? 'Página';
            @endphp

            <nav class="text-sm font-medium text-on-surface dark:text-on-surface-dark" aria-label="breadcrumb">
                <ol class="flex flex-wrap items-center gap-1">
                    <li class="flex items-center gap-1">
                        <a href="{{ route('dashboard') }}"
                            class="hover:text-on-surface-strong dark:hover:text-on-surface-dark-strong">
                            Centro de salud
                        </a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true"
                            stroke-width="2" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </li>
                    <li class="flex items-center text-on-surface-strong gap-1 font-bold dark:text-on-surface-dark-strong"
                        aria-current="page">
                        {{ $pageTitle ?? 'Página' }}
                    </li>
                </ol>
            </nav>


            <flux:spacer />



            <flux:dropdown position="bottom" align="end">
                <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down" data-test="header-menu-button" />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            Configuración
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full"
                            data-test="logout-button">
                            cerrar sesión
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <main class="flex-1 overflow-y-auto p-4 lg:p-6 bg-gray-50 dark:bg-zinc-800">
            {{ $slot }}
        </main>
    </div>
    @fluxScripts

</body>

</html>