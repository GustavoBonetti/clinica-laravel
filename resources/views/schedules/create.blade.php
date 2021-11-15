<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novo Paciente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('schedules.store') }}">
                        @csrf
                        <div class="mb-8">
                            <x-label for="patient" :value="__('Paciente')" />
                            <select class="block mt-1 w-full rounded" id="patient" name="patient" required>
                                <option>Selecione o paciente</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->id . ': ' . $patient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-8">
                            <x-label for="datetime" :value="__('Data e horário')" />
                            <x-input id="datetime" class="block mt-1 w-full" type="datetime-local" name="datetime" :value="old('datetime')" required autofocus />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('schedules.index') }}">
                                <x-button class="ml-4">
                                    {{ __('Voltar') }}
                                </x-button>
                            </a>

                            <x-button class="ml-4">
                                {{ __('Salvar') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
