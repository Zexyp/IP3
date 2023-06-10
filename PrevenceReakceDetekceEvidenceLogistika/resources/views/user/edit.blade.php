<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Uživatel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <section>

                <form method="post" action="{{ route('user.edit', [$value->id]) }}">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-2 gap-6">
                        <h2 class="col-span-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Upravit Uživatele {{$value->date}}</h2>

                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">

                                <x-input-label for="name" :value="__('Jméno')"/>
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                              :value="old('name', $value->name)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('name')"/>

                                <x-input-label for="email" :value="__('Email')"/>
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                              :value="old('email', $value->email)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('email')"/>

                                <x-input-label for="role" :value="__('Email')"/>
                                <select id="role" name="role" type="sus" required
                                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                                    <option disabled>Vyberte</option>
                                    <option @selected(old('role', $value->role) == Role::ADMIN) value="{{Role::ADMIN}}">{{Role::toString(Role::ADMIN)}}</option>
                                    <option @selected(old('role', $value->role) == Role::EMPLOYEE) value="{{Role::EMPLOYEE}}">{{Role::toString(Role::EMPLOYEE)}}</option>
                                    <option @selected(old('role', $value->role) == Role::INCOMING) value="{{Role::INCOMING}}">{{Role::toString(Role::INCOMING)}}</option>
                                    <option @selected(old('role', $value->role) == Role::OUTCOMING) value="{{Role::OUTCOMING}}">{{Role::toString(Role::OUTCOMING)}}</option>
                                    <option @selected(old('role', $value->role) == Role::RESPONDER) value="{{Role::RESPONDER}}">{{Role::toString(Role::RESPONDER)}}</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('role')"/>

                                <x-input-label for="password" :value="__('Heslo')"/>
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"/>
                                <x-input-error class="mt-2" :messages="$errors->get('password')"/>

                            </div>
                        </div>

                        <div class="p-6">
                            <a onclick="return confirm('Odejít bez uložení?')"
                               href="{{route('user.view', [$value->id])}}"
                               class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Zrušit
                            </a>
                            <br>
                            <br>
                            <button type="submit"
                                    class="bg-fuchsia-500 hover:bg-fuchsia-700 text-white font-bold py-2 px-4 rounded">
                                Uložit
                            </button>
                        </div>

                    </div>

                </form>

            </section>

        </div>
    </div>
</x-app-layout>
