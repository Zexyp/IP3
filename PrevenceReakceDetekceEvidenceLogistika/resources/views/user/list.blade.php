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
                                <thead style="border-bottom: 2px solid #8888">
                                <tr>
                                    <th>Jméno</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr style="border-top: 1px solid #8888;">
                                        <td class="text-center"><a class="underline text-blue-500 hover:text-blue-700" href="{{route('user.view', [$user->id])}}">{{$user->name}}</a></td>
                                        <td class="text-center">{{$user->email}}</td>
                                        <td class="text-center">{{Role::toString($user->role)}}</td>
                                        <td>
                                            <form action="{{route('user.delete', [$user->id])}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold rounded d-block text-center" style="display: block; height: 1em; width: 1em; line-height: 1em">×</button>
                                            </form>
                                        </td>
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
