<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        @filamentStyles
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            

            <flux:navbar class="-mb-px max-lg:hidden">
    @if(auth()->user()->role === 'admin')
        <flux:navbar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Dashboard') }}
        </flux:navbar.item>
    @else
        <flux:navbar.item icon="lock-closed" class="opacity-40 pointer-events-none cursor-not-allowed">
            {{ __('Dashboard') }}
        </flux:navbar.item>
    @endif
</flux:navbar>
            <flux:navbar  class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="user-group" :href="route('customers.index')" :current="request()->routeIs('manage-Customers.index')" wire:navigate>
                    {{ __('Customers') }}
                </flux:navbar.item>
                <flux:navbar.item icon="user-circle" :href="route('users.index')" :current="request()->routeIs('users.index')" wire:navigate>
                    {{ __('Users') }}
                </flux:navbar.item>
                <flux:navbar.item icon="archive-box" :href="route('items.index')" :current="request()->routeIs('items.index')" wire:navigate>
                    {{ __('Items') }}
                </flux:navbar.item>
                <flux:navbar.item icon="circle-stack" :href="route('inventories.index')" :current="request()->routeIs('inventories.index')" wire:navigate>
                    {{ __('inventory') }}
                </flux:navbar.item>
                <flux:navbar.item icon="currency-dollar" :href="route('sales.index')" :current="request()->routeIs('sales.index')" wire:navigate>
                    {{ __('Sales') }}
                </flux:navbar.item>
                <flux:navbar.item icon="credit-card" :href="route('payment.methods.index')" :current="request()->routeIs('payment.methods.index')" wire:navigate>
                    {{ __('Payments') }}
                </flux:navbar.item>
                <flux:navbar.item icon="credit-card" :href="route('pos')" :current="request()->routeIs('pos')" wire:navigate>
                    {{ __('pos') }}
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <x-desktop-user-menu />
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')">
                    <flux:sidebar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard')  }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            
        </flux:sidebar>

        {{ $slot }}
        @livewire('notifications')
        @fluxScripts
        @filamentScripts
    </body>
</html>
