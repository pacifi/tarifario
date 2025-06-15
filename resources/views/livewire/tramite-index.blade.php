<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <form wire:submit.prevent="save" wire:key="form-{{ $selectedId ?? 'nuevo' }}" class="space-y-4">
        <div>
            <label class="block font-medium">Título</label>
            <input type="text" wire:model.defer="titulo" class="w-full border p-2 rounded bg-yellow-100 text-black">
            @error('titulo') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium">Descripción</label>
            <textarea wire:model.defer="descripcion" class="w-full border p-2 rounded"></textarea>
        </div>

        <button type="submit" class="bg-blue-500  px-4 py-2 rounded">
            {{ $selectedId ? 'Actualizar' : 'Crear' }}
        </button>
    </form>

    <hr class="my-6">

    <h2 class="text-lg font-bold mb-4">Lista de Trámites</h2>
    <div class="relative overflow-x-auto shadow rounded">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th class="px-6 py-3">Título</th>
                <th class="px-6 py-3">Descripción</th>
                <th class="px-6 py-3">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tramites as $tramite)
                <tr class="bg-white border-b">
                    <td class="px-6 py-4">{{ $tramite->titulo }}</td>
                    <td class="px-6 py-4">{{ $tramite->descripcion }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <button type="button" wire:click="edit({{ $tramite->id }})" class="text-blue-600 hover:underline">Editar</button>
                        <button type="button" wire:click="delete({{ $tramite->id }})" class="text-red-600 hover:underline">Eliminar</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
