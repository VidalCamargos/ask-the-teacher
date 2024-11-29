<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Minhas Perguntas') }}
        </x-header>
    </x-slot>

    <x-container>
        <x-form post :action="route('questions.store')">
            <x-textarea name="question" label="Pergunta" placeholder="Me pergunte algo..."/>

            <x-buttons.primary>Salvar</x-buttons.primary>
            <x-buttons.reset>Cancelar</x-buttons.reset>
        </x-form>

        <hr class="border-gray-700 my-4">

        <div class="dark:text-gray-400 uppercase font-bold mb-4"> Meus Rascunhos </div>
        <div class="space-y-6">
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Perguntas</x-table.th>
                        <x-table.th>Ações</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                @foreach($questions->where('draft', true) as $question)
                    <x-table.tr>
                        <x-table.td> {{ $question->question }} </x-table.td>
                        <x-table.td>
                            <x-form :action="route('questions.destroy', $question)" delete>
                                <button type="submit" class="hover:underline text-blue-500">Deletar</button>
                            </x-form>

                            <x-form :action="route('questions.update', [$question, 'draft' => false])" put>
                                <button type="submit" class="hover:underline text-blue-500">Publicar</button>
                            </x-form>

                            <a href="{{route('questions.edit', $question)}}" class="hover:underline text-blue-500">Editar</a>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </tbody>
            </x-table>
        </div>

        <div class="dark:text-gray-400 uppercase font-bold mb-4 mt-4"> Minhas Questões</div>
        <div class="space-y-6">
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>Perguntas</x-table.th>
                        <x-table.th>Ações</x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                @foreach($questions->where('draft', false) as $question)
                    <x-table.tr>
                        <x-table.td> {{ $question->question }} </x-table.td>
                        <x-table.td>
                            <x-form :action="route('questions.destroy', $question)" delete>
                                <button type="submit" class="hover:underline text-blue-500">Deletar</button>
                            </x-form>
                            <x-form :action="route('questions.update', [$question, 'draft' => true])" put>
                                <button type="submit" class="hover:underline text-blue-500">Arquivar</button>
                            </x-form>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </tbody>
            </x-table>
        </div>
    </x-container>
</x-app-layout>
