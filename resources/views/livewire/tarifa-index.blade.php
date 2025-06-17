<div class="max-w-7xl mx-auto p-6 bg-white shadow rounded">

    <!-- Botón mostrar/ocultar formulario -->
    <button wire:click="toggleFormulario" type="button"
            class="mb-4 bg-green-600 px-4 py-2 rounded">
        {{ $mostrarFormulario ? 'Ocultar Formulario' : 'Nuevo Registro' }}
    </button>

    <!-- Formulario de creación/edición -->
    @if ($mostrarFormulario)
        <form wire:submit.prevent="save" wire:key="form-{{ $selectedId ?? 'nuevo' }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Concepto</label>
                    <input type="text" wire:model.defer="concepto" class="w-full border p-2 rounded">
                    @error('concepto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium">Costo (S/.)</label>
                    <input type="number" step="0.01" wire:model.defer="costo" class="w-full border p-2 rounded">
                    @error('costo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-medium">Trámite</label>
                    <select wire:model.defer="tramite_id" class="w-full border p-2 rounded">
                        <option value="">Seleccione...</option>
                        @foreach($tramites as $item)
                            <option value="{{ $item->id }}">{{ $item->titulo }}</option>
                        @endforeach
                    </select>
                    @error('tramite_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium">Departamento</label>
                    <select wire:model.defer="departamento_id" class="w-full border p-2 rounded">
                        <option value="">Seleccione...</option>
                        @foreach($departamentos as $item)
                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('departamento_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium">Nivel Académico</label>
                    <select wire:model.defer="nivel_academico_id" class="w-full border p-2 rounded">
                        <option value="">Seleccione...</option>
                        @foreach($niveles as $item)
                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('nivel_academico_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    {{ $selectedId ? 'Actualizar' : 'Crear' }}
                </button>
            </div>
        </form>
    @endif

    <!-- Filtros -->
    <div class="flex justify-between gap-4 mb-6">

        <div class="flex-1">
            <label class="block text-sm font-medium">Buscar concepto</label>
            <input type="text" wire:model.defer="filtroConcepto" class="w-full border p-2 rounded" placeholder="Buscar...">
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium">Trámite</label>
            <select wire:model.defer="filtroTramite" class="w-full border p-2 rounded">
                <option value="">Todos</option>
                @foreach($tramites as $item)
                    <option value="{{ $item->id }}">{{ $item->titulo }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium">Departamento</label>
            <select wire:model.defer="filtroDepartamento" class="w-full border p-2 rounded">
                <option value="">Todos</option>
                @foreach($departamentos as $item)
                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1">
            <label class="block text-sm font-medium">Nivel Académico</label>
            <select wire:model.defer="filtroNivel" class="w-full border p-2 rounded">
                <option value="">Todos</option>
                @foreach($niveles as $item)
                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end flex-1">
            <!--<button type="button" wire:click="actualizarConsulta" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                Aplicar Filtros
            </button>-->
            <button type="button" wire:click="actualizarConsulta"
                    class="w-full py-1.5 px-4 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                Aplicar Filtros
            </button>
        </div>


    </div>


    <!-- Tabla de resultados -->
    <h2 class="text-lg font-bold mb-4">Lista de Tarifas</h2>

    <table class="w-full text-sm text-left text-gray-700 border">
        <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">Concepto</th>
            <th class="px-4 py-2 border">Costo</th>
            <th class="px-4 py-2 border">Trámite</th>
            <th class="px-4 py-2 border">Departamento</th>
            <th class="px-4 py-2 border">Nivel Académico</th>
            <th class="px-4 py-2 border">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @forelse($tarifas as $tarifa)
            <tr class="border-b">
                <td class="px-4 py-2 border">{{ $tarifa->concepto }}</td>
                <td class="px-4 py-2 border">S/ {{ number_format($tarifa->costo, 2) }}</td>
                <td class="px-4 py-2 border">{{ $tarifa->tramite->titulo }}</td>
                <td class="px-4 py-2 border">{{ $tarifa->departamento->nombre }}</td>
                <td class="px-4 py-2 border">{{ $tarifa->nivelAcademico->nombre }}</td>
                <td class="px-4 py-2 border space-x-2">
                    <button wire:click="edit({{ $tarifa->id }})" class="text-blue-600 hover:underline">Editar</button>
                    <button wire:click="delete({{ $tarifa->id }})" class="text-red-600 hover:underline">Eliminar</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-4">No se encontraron resultados.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
