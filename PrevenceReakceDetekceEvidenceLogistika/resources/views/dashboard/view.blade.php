<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(in_array(Auth::user()->role, [Role::ADMIN, Role::RESPONDER]))
                <div class="mb-6">
                    @include("dashboard.partials.stats")
                </div>
            @endif

            @if(in_array(Auth::user()->role, [Role::ADMIN, Role::EMPLOYEE]))
                <div class="mb-6">
                    @include("dashboard.partials.canteen")
                </div>
            @endif

            @if(in_array(Auth::user()->role, [Role::ADMIN, Role::INCOMMING]))
                <div class="mb-6">
                    @include("dashboard.partials.incomming")
                </div>
            @endif

            @if(in_array(Auth::user()->role, [Role::ADMIN, Role::OUTCOMMING]))
                <div class="mb-6">
                    @include("dashboard.partials.outcomming")
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
