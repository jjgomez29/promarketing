<div class="flex flex-col lg:flex-row gap-6">

    {{-- Columna izquierda: Formulario (solo visible con permiso) --}}
    @can('create-player-note')
        <div class="w-full lg:w-80 flex-shrink-0">
            <div class="bg-white rounded-lg shadow-sm h-full">
                <div class="px-5 py-4 border-b border-gray-200" style="background-color: #003f7f;">
                    <h3 class="text-base font-semibold text-white">Nueva Nota</h3>
                </div>

                <form wire:submit="saveNote" class="p-5 space-y-4">
                    {{-- Selector de jugador --}}
                    <div>
                        <label for="player" class="block text-sm font-medium text-gray-700 mb-1">
                            Jugador
                        </label>
                        <select
                            id="player"
                            wire:model.live="selectedPlayerId"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('selectedPlayerId') border-red-500 @enderror"
                        >
                            <option value="">Seleccionar...</option>
                            @foreach ($players as $player)
                                <option value="{{ $player->id }}">{{ $player->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedPlayerId')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo de contenido --}}
                    <div>
                        <label for="noteContent" class="block text-sm font-medium text-gray-700 mb-1">
                            Contenido
                        </label>
                        <textarea
                            id="noteContent"
                            wire:model.live="noteContent"
                            rows="4"
                            maxlength="1000"
                            placeholder="Escribe una observacion..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none @error('noteContent') border-red-500 @enderror"
                        ></textarea>
                        <div class="flex items-center justify-between mt-1">
                            @error('noteContent')
                                <p class="text-red-600 text-xs">{{ $message }}</p>
                            @else
                                <span class="text-xs text-gray-400">Max. 1000 caracteres</span>
                            @enderror
                            <span class="text-xs text-gray-400">{{ strlen($noteContent) }}/1000</span>
                        </div>
                    </div>

                    {{-- Boton guardar --}}
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white rounded-lg transition hover:opacity-90 disabled:opacity-50"
                        style="background-color: #0077c2;"
                    >
                        <span wire:loading.remove wire:target="saveNote">Guardar Nota</span>
                        <span wire:loading wire:target="saveNote" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Guardando...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    @endcan

    {{-- Columna derecha: Tabla de notas --}}
    <div class="flex-1 min-w-0">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden h-full">
            <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-800">Historial de Notas</h3>
                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $notes->total() }} nota(s)</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Autor
                            </th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Jugador
                            </th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Contenido
                            </th>
                            @can('create-player-note')
                                <th scope="col" class="px-5 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Acciones
                                </th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($notes as $note)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $note->created_at->format('d/m/Y') }}<br>
                                    <span class="text-xs text-gray-400">{{ $note->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $note->author->name }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $note->player->name }}
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-700 max-w-xs">
                                    <p class="truncate" title="{{ $note->content }}">{{ $note->content }}</p>
                                </td>
                                @can('create-player-note')
                                    <td class="px-5 py-4 text-center">
                                        <button
                                            type="button"
                                            wire:click.stop.prevent="confirmDelete({{ $note->id }})"
                                            class="text-red-600 hover:text-red-800 transition p-2 rounded hover:bg-red-50"
                                            title="Eliminar nota"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center">
                                    <svg class="w-10 h-10 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-gray-400 text-sm">No hay notas registradas.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginador simple --}}
            @if ($notes->hasPages())
                <div class="px-5 py-4 border-t border-gray-200 flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        Mostrando {{ $notes->firstItem() }} - {{ $notes->lastItem() }} de {{ $notes->total() }}
                    </p>
                    <div class="flex gap-2">
                        @if ($notes->onFirstPage())
                            <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded cursor-not-allowed">Anterior</span>
                        @else
                            <button wire:click="previousPage" class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">Anterior</button>
                        @endif

                        @if ($notes->hasMorePages())
                            <button wire:click="nextPage" class="px-3 py-1 text-sm text-white rounded transition hover:opacity-90" style="background-color: #0077c2;">Siguiente</button>
                        @else
                            <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded cursor-not-allowed">Siguiente</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal de confirmacion para eliminar --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                {{-- Overlay --}}
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    wire:click="cancelDelete"
                ></div>

                {{-- Modal --}}
                <div class="relative inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-4 text-left">
                                <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                                    Eliminar nota
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">
                                    ¿Estas seguro de que deseas eliminar esta nota? Esta accion no se puede deshacer.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                        <button
                            type="button"
                            wire:click="cancelDelete"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition"
                        >
                            Cancelar
                        </button>
                        <button
                            type="button"
                            wire:click="deleteNote"
                            wire:loading.attr="disabled"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="deleteNote">Eliminar</span>
                            <span wire:loading wire:target="deleteNote">Eliminando...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
