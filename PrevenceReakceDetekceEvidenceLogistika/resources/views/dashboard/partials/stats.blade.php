<section>
    <div class="grid grid-cols-3 gap-6">
        <h2 class="col-span-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Staty</h2>
        <div class="col-span-3 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @if($actionResponder)
                    <div class="rounded bg-yellow-500 dark:bg-yellow-700 dark:text-white px-2 py-1 text-black">
                        Vyžadovaná akce
                    </div>
                    <br/>
                @endif
                {{ __("lol put some fancy graphs here") }}
                <br/>
            </div>
        </div>
    </div>
</section>
