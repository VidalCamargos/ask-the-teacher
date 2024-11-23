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
    </x-container>
</x-app-layout>
