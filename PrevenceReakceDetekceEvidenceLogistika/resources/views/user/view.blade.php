<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Uživatel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <section>
                <div class="grid grid-cols-2 gap-6">
                    <h2 class="col-span-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Uživatel {{$value->name}}</h2>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                            <dl>
                                <dt>Jméno</dt>
                                <dd class="p-2 px-4">{{$value->name}}</dd>
                                <dt>Email</dt>
                                <dd class="p-2 px-4">{{$value->email}}</dd>
                                <dt>Role</dt>
                                <dd class="p-2 px-4">{{Role::toString($value->role)}}</dd>
                            </dl>

                        </div>
                    </div>
                    <div class="p-6">
                        <a href="{{route('users')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Seznam
                        </a>
                        <br>
                        <br>
                        <a href="{{route('user.edit', [$value->id])}}" class="bg-fuchsia-500 hover:bg-fuchsia-700 text-white font-bold py-2 px-4 rounded">
                            Upravit
                        </a>
                        <br>
                        <br>
                        <form onclick="return confirm('Opravdu chcete pokračovat?')" action="{{route('user.delete', [$value->id])}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Smazat
                            </button>
                        </form>

                        @if (session('status') === 'thingy-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="py-4 text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Uloženo.') }}</p>
                        @endif
                    </div>

                </div>
            </section>

        </div>
    </div>
</x-app-layout>
