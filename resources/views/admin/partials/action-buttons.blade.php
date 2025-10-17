@props([
    'showRoute' => null,
    'editRoute' => null,
    'destroyRoute' => null,
    'pdfRoute' => null,
    'pdfTarget' => '_blank',
    // label text to show under each icon; set to empty string to hide
    'showLabel' => 'Lihat',
    'editLabel' => 'Edit',
    'deleteLabel' => 'Hapus',
    'pdfLabel' => 'PDF',
    'deleteTitle' => 'Hapus?',
    'deleteText' => 'Yakin ingin menghapus item ini?',
    'deleteConfirm' => 'Hapus'
])

@php
    // labelAlign: 'center' (default) or 'left'
    $labelAlign = $labelAlign ?? 'center';
    $alignClass = $labelAlign === 'left' ? 'items-start text-left' : 'items-center text-center';
    $alignStyle = $labelAlign === 'left' ? 'align-items:flex-start;text-align:left;' : 'align-items:center;text-align:center;';
@endphp

<div class="flex" style="display:flex;align-items:center;justify-content:center;gap:8px;">
    @if($showRoute)
        <div class="flex flex-col {{ $alignClass }}" style="display:flex;flex-direction:column;{{ $alignStyle }}">
            <a href="{{ $showRoute }}" class="text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-md transition-all duration-200" style="padding:8px;" title="Lihat">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </a>
            @if($showLabel)
                <span class="text-xs text-slate-600" style="margin-top:4px;">{{ $showLabel }}</span>
            @endif
        </div>
    @endif

    @if($editRoute)
        <div class="flex flex-col {{ $alignClass }}" style="display:flex;flex-direction:column;{{ $alignStyle }}">
            <a href="{{ $editRoute }}" class="text-yellow-600 hover:text-yellow-800 hover:bg-yellow-100 rounded-md transition-all duration-200" style="padding:8px;" title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>
            @if($editLabel)
                <span class="text-xs text-slate-600" style="margin-top:4px;">{{ $editLabel }}</span>
            @endif
        </div>
    @endif

    @if($destroyRoute)
        <div class="flex flex-col {{ $alignClass }}" style="display:flex;flex-direction:column;{{ $alignStyle }}">
            <form action="{{ $destroyRoute }}" method="POST" class="inline swal-delete"
                  data-swal-title="{{ $deleteTitle }}"
                  data-swal-text="{{ $deleteText }}"
                  data-swal-confirm="{{ $deleteConfirm }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800 hover:bg-red-100 rounded-md transition-all duration-200" style="padding:8px;" title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>
            @if($deleteLabel)
                <span class="text-xs text-slate-600" style="margin-top:4px;">{{ $deleteLabel }}</span>
            @endif
        </div>
    @endif

    @if($pdfRoute)
        <div class="flex flex-col {{ $alignClass }}" style="display:flex;flex-direction:column;{{ $alignStyle }}">
            <a href="{{ $pdfRoute }}" target="{{ $pdfTarget }}" rel="noopener" class="text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-md transition-all duration-200" style="padding:8px;" title="Preview PDF">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m0-8L8 12m4-4l4 4M21 12v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6"/>
                </svg>
            </a>
            @if($pdfLabel)
                <span class="text-xs text-slate-600" style="margin-top:4px;">{{ $pdfLabel }}</span>
            @endif
        </div>
    @endif
</div>
