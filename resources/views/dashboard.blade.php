<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Dashboard') }}
        </x-header>
    </x-slot>

    <x-container>
        <x-form post :action="route('questions.store')">
            <x-textarea name="question" label="Pergunta" placeholder="Me pergunte algo..."/>

            <x-buttons.primary>Salvar</x-buttons.primary>
            <x-buttons.reset>Cancelar</x-buttons.reset>
        </x-form>

        <hr class="border-gray-700 my-4">

        <div class="dark:text-gray-400 uppercase font-bold mb-4"> Lista de Perguntas </div>
        <div class="space-y-6">
            @foreach($questions as $item)
                <x-question :question="$item"/>
            @endforeach
        </div>
    </x-container>
</x-app-layout>
