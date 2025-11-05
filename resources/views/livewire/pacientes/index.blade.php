    <x-slot name="pageTitle">Pacientes</x-slot>
<div class="relative w-full p-6">
   
    <h1 class="text-center text-3xl font-bold mb-6">PACIENTE</h1>

   
    <div class="flex items-center gap-4 mb-6">
        <input type="text" wire:model.live="search" placeholder="Buscar Paciente"
            class="w-full max-w-md px-4 py-2 border  border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

   
<div 
    x-data="{ show: @entangle('showToast'), timeout: null }"
    x-show="show"
    x-effect="if(show){ setTimeout(() => show = false, 3000) }"
    x-transition.opacity.duration.300ms
    class="fixed top-5 right-5 z-50 max-w-xs rounded border p-4 shadow-lg"
    :class="{
        'bg-blue-100 border-blue-950 text-blue-800': @js($toastType) === 'info',
        'bg-green-100 rounded-lg border border-green-600 text-on-surface dark:bg-surface-dark dark:text-on-surface-dark': @js($toastType) === 'success',
        'bg-yellow-100 border-amber-950 text-amber-700': @js($toastType) === 'warning',
        'bg-red-100 border-red-950 text-red-800': @js($toastType) === 'danger'
    }"
    role="alert"
>
    <div class="flex items-center justify-between">
         <span class="flex-shrink-0">
        <template x-if="@js($toastType) === 'success'">
           <div class="bg-green-600/15 text-green-600 rounded-full p-1" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
            </svg>
        </div>
        </template>
        <template x-if="@js($toastType) === 'info'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd"/>
            </svg>
        </template>
        <template x-if="@js($toastType) === 'warning'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
            </svg>
        </template>
        <template x-if="@js($toastType) === 'danger'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd"/>
            </svg>
        </template>
    </span>
        <span class="font-medium ml-2" x-text="@js($toastMessage)"></span>
        <button x-on:click="show = false" class="ml-2 font-bold">&times;</button>
    </div>
</div>

  
    <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
        <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
            <thead
                class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                <tr>
                    <th scope="col" class="p-4">
                        No. expediente
                    </th>
                    <th scope="col" class="p-4">
                        Apellido Paterno
                    </th>
                    <th scope="col" class="p-4">
                        Apellido Materno
                    </th>
                    <th scope="col" class="p-4">
                        Nombre
                    </th>
                    <th scope="col" class="p-4">
                        Sexo
                    </th>
                    <th scope="col" class="p-4">
                        Seccion
                    </th>
                    <th scope="col" class="p-4">
                        Nivel
                    </th>
                    <th scope="col" class="p-4">
                     Departamento
                    </th>
                    <th scope="col" class="p-4">
                    Ultima Consulta
                    </th>
                    @if($search)
                        <th scope="col" class="p-4">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-outline dark:divide-outline-dark">
                @forelse ($pacientes as $paciente)
                    <tr class="even:bg-primary/5 dark:even:bg-primary-dark/10 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800"
                        wire:click="view({{ $paciente->id }})">
                        <td class="p-4">
                            {{ $paciente->numero_expediente }}
                        </td>
                        <td class="p-4">
                            {{ $paciente->apellido_paterno }}
                        </td>
                        <td class="p-4">
                            {{ $paciente->apellido_materno }}
                        </td>
                        <td class="p-4">
                            {{ $paciente->nombre }}
                        </td>
                        <td class="p-4">
                            {{ $paciente->sexo ?? '—' }}
                        </td>
                        <td class="p-4">
                            {{ $paciente->seccion ?? '—' }}
                        </td>
                        <td class="p-4">
                            {{ $paciente->nivel ?? '0' }}
                        </td>
                        <td class="p-4">
                            {{ $paciente->departamento ?? '—' }}
                        </td>
                        <td class="p-4">
                            {{ $paciente->fecha_consulta ? \Carbon\Carbon::parse($paciente->fecha_consulta)->format('d/m/Y') : '—' }}
                        </td>
                        @if($search)
                            <td class="p-4">
                              
                                @can('user.edit')
                        
                                <button wire:click.stop="edit({{ $paciente->id }})"
                                    class="text-blue-600 hover:underline mr-4">
                                    Editar
                                </button>
                                @endcan

                                <button wire:click.stop="updateDateConsulta({{ $paciente->id }})"
                                 class="text-green-600 hover:underline mr-4">
                                    Actualizar Consulta
                                </button>
                              
                              @can('user.delete')
                                  
                              
                                <button wire:click.stop="delete({{ $paciente->id }})"
                                    class="text-red-600 hover:underline">
                                    Eliminar
                                </button>
                                
                              @endcan 
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $search ? 8 : 7 }}" class="px-4 py-3 text-center text-sm text-gray-500">
                            NO SE ENCONTRARON PACIENTES
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $pacientes->links() }}
    </div>


    <div class="fixed bottom-6 right-6 z-10">
        <button type="button" wire:click="create"
            class="inline-flex items-center px-4 py-2 whitespace-nowrap rounded-radius bg-primary border border-primary  tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                    clip-rule="evenodd" />
            </svg>
            REGISTRAR
        </button>
    </div>


    <div x-data="{ modalIsOpen: @entangle('modalIsOpen') }">
       
        <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen"
            x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false"
            class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
            role="dialog" aria-modal="true" aria-labelledby="modalTitle">

            <div x-show="modalIsOpen" x-transition:enter="transition ease-out duration-200 delay-100"
                x-transition:enter-start="opacity-0 scale-y-0" x-transition:enter-end="opacity-100 scale-y-100"
                class="flex w-full max-w-2xl flex-col gap-4 overflow-hidden rounded-radius border border-outline bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">

                <div
                    class="flex items-center justify-between border-b border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20">
                    <h3 id="modalTitle" class="font-semibold tracking-wide">
                        @if($viewMode)
                            Información del Paciente
                        @else
                            {{ $paciente_id ? 'Editar Paciente' : 'Nuevo Paciente' }}
                        @endif
                    </h3>
                    <button x-on:click="modalIsOpen = false; $wire.closeModal()" aria-label="Cerrar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none"
                            stroke-width="1.4" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="px-4 py-6 space-y-4 max-h-[70vh] overflow-y-auto">
                    @if($viewMode && $selectedPaciente)
                      
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                           
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Apellido
                                    Paterno</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $selectedPaciente->apellido_paterno }}</p>
                            </div>

                          
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Apellido
                                    Materno</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $selectedPaciente->apellido_materno ?? '—' }}</p>
                            </div>

                         
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Nombre(s)</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $selectedPaciente->nombre }}</p>
                            </div>

                           
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Núm.
                                    Expediente</label>
                                <p
                                    class="text-gray-800 dark:text-gray-200 font-medium bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded inline-block">
                                    {{ $selectedPaciente->numero_expediente }}
                                </p>
                            </div>

                          
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Sexo</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $selectedPaciente->sexo ?? '—' }}
                                </p>
                            </div>

                          
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Fecha
                                    de Nacimiento</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $selectedPaciente->fecha_nacimiento ? \Carbon\Carbon::parse($selectedPaciente->fecha_nacimiento)->format('d/m/Y') : '—' }}
                                </p>
                            </div>

                            
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Fecha
                                    de Ingreso</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ \Carbon\Carbon::parse($selectedPaciente->fecha_ingreso)->format('d/m/Y') }}
                                </p>
                            </div>

                             <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Ultima Consulta</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ \Carbon\Carbon::parse($selectedPaciente->fecha_consulta)->format('d/m/Y') }}
                                </p>
                            </div>

                             <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Sección</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $selectedPaciente->seccion ?? '—' }}
                                </p>
                            </div>

                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Nivel</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $selectedPaciente->nivel ?? '0' }}
                                </p>
                            </div>

                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Departamento</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $selectedPaciente->departamento ?? '—' }}
                                </p>
                            </div>

                            
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Localidad</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $selectedPaciente->localidad ?? '—' }}</p>
                            </div>

                        
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Municipio</label>
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $selectedPaciente->municipio ?? '—' }}</p>
                            </div>
                           
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider dark:text-gray-400">Dirección</label>
                                <p
                                    class="text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $selectedPaciente->direccion ?? '—' }}
                                </p>
                            </div>

                       
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm">Apellido Paterno *</label>
                                <input type="text" wire:model="apellido_paterno" class="w-full border rounded px-2 py-1">
                                @error('apellido_paterno') <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm">Apellido Materno</label>
                                <input type="text" wire:model="apellido_materno" class="w-full border rounded px-2 py-1">
                                @error('apellido_materno') <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm">Nombre(s) *</label>
                                <input type="text" wire:model="nombre" class="w-full border rounded px-2 py-1">
                                @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm">Núm. Expediente *</label>
                                <input type="text" wire:model="numero_expediente" class="w-full border rounded px-2 py-1">
                                @error('numero_expediente') <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm">Sexo</label>
                                <select wire:model="sexo" class="w-full border rounded  dark:bg-surface-dark-alt dark:text-on-surface-dark px-2 py-1">
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
                                @error('sexo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm">Fecha de Nacimiento</label>
                                <input type="date" wire:model="fecha_nacimiento" class="w-full border rounded px-2 py-1">
                                @error('fecha_nacimiento') <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>


                            <div>
                                <label class="block text-sm">Fecha de Ingreso *</label>
                                <input type="date" wire:model="fecha_ingreso" class="w-full border rounded px-2 py-1">
                                @error('fecha_ingreso') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm">Ultima Consulta *</label>
                                <input type="date" wire:model="fecha_consulta" class="w-full border rounded px-2 py-1">
                                @error('fecha_ingreso') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm">Sección</label>
                                <input type="text" wire:model="seccion" class="w-full border rounded px-2 py-1" oninput=" this.value = this.value.toUpperCase();">
                                @error('seccion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm">Nivel</label>
                                <select wire:model="nivel" class="w-full border rounded  dark:bg-surface-dark-alt dark:text-on-surface-dark px-2 py-1">
                                    <option value="">Seleccione...</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                @error('nivel') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm">Departamento</label>
                                <select wire:model="departamento" class="w-full border rounded  dark:bg-surface-dark-alt dark:text-on-surface-dark px-2 py-1">
                                    <option value="">Seleccione...</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Cronico">Cronico</option>
                                    <option value="Especial">Especial</option>
                                </select>
                                @error('departamento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm">Dirección</label>
                                <input type="text" wire:model="direccion" class="w-full border rounded px-2 py-1">
                                @error('direccion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm">Localidad</label>
                                <input type="text" wire:model="localidad" class="w-full border rounded px-2 py-1">
                                @error('localidad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm">Municipio</label>
                                <input type="text" wire:model="municipio" class="w-full border rounded px-2 py-1">
                                @error('municipio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif
                </div>

                <div
                    class="flex flex-col-reverse justify-between gap-2 border-t border-outline bg-surface-alt/60 p-4 dark:border-outline-dark dark:bg-surface-dark/20 sm:flex-row sm:items-center md:justify-end">
                    <button x-on:click="modalIsOpen = false; $wire.closeModal()" type="button"
                        class="whitespace-nowrap rounded-radius px-4 py-2 text-sm font-medium tracking-wide text-gray-700 dark:text-gray-300 transition hover:opacity-75">
                        Cancelar
                    </button>

                    @unless($viewMode)
                        <button wire:click="save" type="button"
                            class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75">
                            Guardar
                        </button>
                    @endunless
                </div>
            </div>
        </div>
    </div>
</div>
