<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Votação') }}
        </x-header>
    </x-slot>

    <x-container>
        <div class="dark:text-gray-400 uppercase font-bold mb-4 text-center"> Lista de Perguntas</div>

        <div class="space-y-6 mt-4">
            <form action="{{ route('dashboard') }}" method="get" class="flex items-start space-x-2">
                @csrf

                <x-text-input type="text" name="search" value="{{ request()->search }}" class="w-full"/>
                <x-buttons.primary type="submit">Search</x-buttons.primary>
            </form>

            @if($questions->count() !== 0)
                @foreach($questions as $item)
                    <x-question :question="$item"/>

                @endforeach
            @else
                <div class="dark:text-gray-400 text-center flex flex-col justify-center">
                    <div class="justify-center flex">
                        <x-draw.searching width="300"/>
                    </div>

                    <div class="mt-6 dark:text-gray-400 font-bold text-2xl">
                        Questão não encontrada
                    </div>
                </div>
            @endif

            {{ $questions->withQueryString()->links() }}
        </div>
    </x-container>
</x-app-layout>
