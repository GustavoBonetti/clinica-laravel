<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agendamentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('schedules.create') }}" class="flex justify-end">
                        <x-button class="ml-3">{{ __('Novo agendamento') }}</x-button>
                    </a>
                    @forelse( $schedules as $schedule )
                        <div class="p-6 bg-white border-b border-gray-200 flex justify-between">
                            @php
                                $datetime = new DateTime($schedule->schedule_datetime);
                            @endphp
                            <div>{{ $schedule->patient->name }} - {{ $datetime->format('d/m/Y H:i:s') }}</div>
                            <div class="buttons flex">
                                <a href="{{ route('schedules.show', $schedule->id) }}" class="mx-0.5">
                                    <x-button>
                                        {{ __('Visualizar') }}
                                    </x-button>
                                </a>
                                <a href="{{ route('schedules.edit', $schedule->id) }}" class="mx-0.5">
                                    <x-button>
                                        {{ __('Editar') }}
                                    </x-button>
                                </a>
                                <form method="POST" action="{{ route('schedules.destroy', $schedule->id) }}" class="mx-0.5">
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
                            Nenhum agendamento cadastrado
                        </div>
                    @endforelse

                    {{ $schedules ?? $schedules->links }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
