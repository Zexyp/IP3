<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Svozy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <section>
                <div class="grid grid-cols-1 gap-6">
                    <h2 class="col-span-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Výpis</h2>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                            <table class="table-auto w-full">
                                <thead style="border-bottom: 2px solid #8888">
                                <tr>
                                    <th>Datum</th>
                                    <th>Hmotnost (kg)</th>
                                    <th>Cena (Kč)</th>
                                    <th>Kontrola</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $value)
                                    <tr style="border-top: 1px solid #8888;">
                                        <td class="text-center"><a class="underline text-blue-500 hover:text-blue-700" href="{{route('outcoming.view', [$value->id])}}">{{$value->date}}</td>
                                        <td class="text-center">{{$value->mass}}</td>
                                        <td class="text-center">{{$value->worth}}</td>
                                        <td class="text-center"><input class="{{$value->checked ? 'bg-blue-500' : 'bg-transparent'}} rounded" type="checkbox" disabled {{$value->checked ? 'checked' : ''}}></td>
                                        @if(Auth::user()->role == Role::ADMIN)
                                            <td>
                                                <form action="{{route('outcoming.delete', [$value->id])}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold rounded d-block text-center" style="display: block; height: 1em; width: 1em; line-height: 1em">×</button>
                                                </form>
                                            </td>
                                        @endif
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
