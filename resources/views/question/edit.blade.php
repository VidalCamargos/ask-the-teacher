<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Editar pergunta') }} :: {{ $question->id }}
        </x-header>
    </x-slot>

    <x-container>
        <x-form :action="route('questions.update', $question)" put>
            <x-textarea name="question" label="Pergunta" placeholder="Me pergunte algo..." :value="$question->question"/>

            <x-buttons.primary>Salvar</x-buttons.primary>
            <x-buttons.reset>Cancelar</x-buttons.reset>
        </x-form>
    </x-container>
</x-app-layout>
