<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Svoz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <section>

                <form method="post" action="{{ route('outcoming.edit', [$value->id]) }}">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-2 gap-6">
                        <h2 class="col-span-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Upravit Záznam ze dne {{$value->date}}</h2>

                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">

                                <x-input-label for="date" :value="__('Datum')" />
                                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date', $value->date)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('date')" />

                                <x-input-label for="mass" :value="__('Hmotnost (kg)')" />
                                <x-text-input id="mass" name="mass" type="number" step=".01" class="mt-1 block w-full" :value="old('mass', $value->mass)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('mass')" />

                                <x-input-label for="worth" :value="__('Cena (Kč)')" />
                                <x-text-input id="worth" name="worth" type="number" step=".01" class="mt-1 block w-full" :value="old('worth', $value->worth)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('worth')" />

                                <x-input-label for="checked" :value="__('Kontrola')" />
                                <x-text-input id="checked" name="checked" type="checkbox" class="mt-1 block w-full" value="1" style="width: unset; aspect-ratio: 1"/>
                                <x-input-error class="mt-2" :messages="$errors->get('checked')" />

                                @if($value->checked)
                                <script>
                                    // im loosin it... f*ck it
                                    let chekus = document.getElementById('checked')
                                    chekus.checked = true
                                </script>
                                @endif
                            </div>
                        </div>

                        <div class="p-6">
                            <a onclick="return confirm('Odejít bez uložení?')" href="{{route('outcoming.view', [$value->id])}}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Zrušit
                            </a>
                            <br>
                            <br>
                            <button type="submit" class="bg-fuchsia-500 hover:bg-fuchsia-700 text-white font-bold py-2 px-4 rounded">
                                Uložit
                            </button>
                        </div>

                    </div>

                </form>

            </section>

        </div>
    </div>
</x-app-layout>
