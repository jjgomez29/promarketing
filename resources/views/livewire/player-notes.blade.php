<div>
    @can('create-player-note')
        <div class="bg-white shadow-sm rounded-lg p-5 mb-6 border-l-4" style="border-color: #0077c2;">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Agregar nota interna</h3>

            <form wire:submit="saveNote">
                <textarea
                    wire:model.live="noteContent"
                    rows="3"
                    maxlength="1000"
                    placeholder="Escribe una observación sobre este jugador..."
                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 resize-none"
                    style="focus-ring-color: #0077c2;"
                ></textarea>

                <div class="flex items-center justify-between mt-1 mb-3">
                    @error('noteContent')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @else
                        <span class="text-xs text-gray-400">Máximo 1000 caracteres</span>
                    @enderror
                    <span class="text-xs text-gray-400">{{ strlen($noteContent) }}/1000</span>
                </div>

                <button
                    type="submit"
                    class="text-white text-sm font-semibold px-5 py-2 rounded-lg transition hover:opacity-90"
                    style="background-color: #0077c2;"
                >
                    Guardar nota
                </button>
            </form>
        </div>
    @endcan

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="px-5 py-3 border-b flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-700">Historial de notas</h3>
            <span class="text-xs text-gray-400">{{ $notes->total() }} nota(s)</span>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse ($notes as $note)
                <div class="px-5 py-4">
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold"
                                 style="background-color: #0077c2;">
                                {{ strtoupper(substr($note->author->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-800">{{ $note->author->name }}</span>
                        </div>
                        <span class="text-xs text-gray-400">{{ $note->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <p class="text-sm text-gray-700 whitespace-pre-wrap ml-9">{{ $note->content }}</p>
                </div>
            @empty
                <div class="px-5 py-10 text-center">
                    <p class="text-gray-400 text-sm">No hay notas registradas para este jugador.</p>
                </div>
            @endforelse
        </div>

        @if ($notes->hasPages())
            <div class="px-5 py-3 border-t">
                {{ $notes->links() }}
            </div>
        @endif
    </div>
</div>
