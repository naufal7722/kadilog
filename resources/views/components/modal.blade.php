@props(['id' => '', 'title' => '', 'maxWidth' => 'max-w-lg'])

<div id="{{ $id }}" data-modal-backdrop class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full {{ $maxWidth }} animate-scale-in max-h-[90vh] flex flex-col">
        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-secondary-100">
            <h3 class="text-lg font-semibold text-secondary-900">{{ $title }}</h3>
            <button onclick="closeModal('{{ $id }}')" class="flex items-center justify-center w-8 h-8 rounded-lg text-secondary-400 hover:text-secondary-600 hover:bg-secondary-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="flex-1 overflow-y-auto px-6 py-4">
            {{ $slot }}
        </div>
    </div>
</div>
