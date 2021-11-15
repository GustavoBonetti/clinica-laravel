<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visualizar Paciente ') . $schedule->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-8">
                        <x-label for="patient" :value="__('Paciente')" />
                        <x-input id="patient" class="block mt-1 w-full" type="text" name="patient" :value="$schedule->patient->name" disabled />
                    </div>
                    <div class="mb-8">
                        <x-label for="datetime" :value="__('Data e horário')" />
                        <x-input id="datetime" class="block mt-1 w-full" type="text" name="datetime" :value="$schedule->schedule_datetime" disabled />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('schedules.index') }}">
                            <x-button class="ml-4">
                                {{ __('Voltar') }}
                            </x-button>
                        </a>
                        <a href="{{ route('schedules.edit', $schedule->id) }}">
                            <x-button class="ml-4">
                                {{ __('Editar') }}
                            </x-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
