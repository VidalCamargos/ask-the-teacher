<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Votação') }}
        </x-header>
    </x-slot>

    <x-container>
        <div class="dark:text-gray-400 uppercase font-bold mb-4"> Lista de Perguntas </div>
        <div class="space-y-6">
            @foreach($questions as $item)
                <x-question :question="$item"/>
            @endforeach
        </div>
    </x-container>
</x-app-layout>
