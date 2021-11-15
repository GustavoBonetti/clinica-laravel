<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visualizar Paciente ') . $patient->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-8">
                        <x-label for="name" :value="__('Nome')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$patient->name" disabled />
                    </div>
                    <div class="mb-8">
                        <x-label for="phone" :value="__('Telefone')" />
                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="$patient->phone" disabled />
                    </div>
                    <div>
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="$patient->email" disabled />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('patients.index') }}">
                            <x-button class="ml-4">
                                {{ __('Voltar') }}
                            </x-button>
                        </a>
                        <a href="{{ route('patients.edit', $patient->id) }}">
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
