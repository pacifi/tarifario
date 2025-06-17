<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <form wire:submit.prevent="save" wire:key="form-{{ $selectedId ?? 'nuevo' }}" class="space-y-4">
        <div>
            <label class="block font-medium">Nombre</label>
            <input type="text" wire:model="nombre" class="w-full border p-2 rounded">
           {{-- <flux:input icon="academic-cap" wire:model="nombre" placeholder="Search orders" />--}}


            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block font-medium">Descripción</label>
            <textarea wire:model="descripcion" class="w-full border p-2 rounded"></textarea>
        </div>
        <button type="submit" class="bg-blue-600  px-4 py-2 rounded">
            {{ $selectedId ? 'Actualizar' : 'Crear' }}
        </button>
    </form>

    <hr class="my-6">

    <h2 class="text-lg font-bold mb-4">Niveles Académicos</h2>
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2">Nombre</th>
            <th class="px-4 py-2">Descripción</th>
            <th class="px-4 py-2">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($niveles as $nivel)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $nivel->nombre }}</td>
                <td class="px-4 py-2">{{ $nivel->descripcion }}</td>
                <td class="px-4 py-2 space-x-2">
                    <button wire:click="edit({{ $nivel->id }})" class="text-blue-600 hover:underline">Editar</button>
                    <button wire:click="delete({{ $nivel->id }})" class="text-red-600 hover:underline">Eliminar</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
