<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pacientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('patients.create') }}" class="flex justify-end">
                        <x-button class="ml-3">{{ __('Novo paciente') }}</x-button>
                    </a>
                    @forelse( $patients as $patient )
                        <div class="p-6 bg-white border-b border-gray-200 flex justify-between">
                            <div>{{ $patient->name }}</div>
                            <div class="buttons flex">
                                <a href="{{ route('patients.show', $patient->id) }}" class="mx-0.5">
                                    <x-button>
                                        {{ __('Visualizar') }}
                                    </x-button>
                                </a>
                                <a href="{{ route('patients.edit', $patient->id) }}" class="mx-0.5">
                                    <x-button>
                                        {{ __('Editar') }}
                                    </x-button>
                                </a>
                                <form method="POST" action="{{ route('patients.destroy', $patient->id) }}" class="mx-0.5">
                                    @csrf
                                    @method('DELETE')
                                    <x-button>
                                        {{ __('Excluir') }}
                                    </x-button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 bg-white border-b border-gray-200">
                            Nenhum paciente cadastrado
                        </div>
                    @endforelse

                    {{ $patients ?? $patients->links }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
