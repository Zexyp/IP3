<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Uživatelé') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <section>
                <div class="grid grid-cols-1 gap-6">
                    <h2 class="col-span-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Seznam</h2>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                            <table class="table-auto w-full">
                                <thead>
                                <tr>
                                    <th>Jméno</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="text-center">{{$user->name}}</td>
                                        <td class="text-center">{{$user->email}}</td>
                                        <td class="text-center">{{Role::toString($user->role)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </section>

        </div>
    </div>
</x-app-layout>
