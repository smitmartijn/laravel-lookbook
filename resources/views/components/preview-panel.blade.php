<div class="mb-4 p-4">
    <h1 class="text-2xl font-semibold mb-4 dark:text-white">{{ $component['name'] }}</h1>

    @if(is_array($previews) && count($previews) > 0)
    @foreach($previews as $preview)
    <div class="mb-6">
        <h2 class="text-lg font-bold dark:text-white">{{ $preview['metadata']['name'] ?? ucfirst(str_replace('_', '
            ',
            $preview['method'])) }}</h2>
        @if(!empty($preview['metadata']['notes']))

        <div class="text-gray-500 dark:text-gray-400 mb-2">
            {!! \Illuminate\Support\Str::markdown($preview['metadata']['notes']) !!}
        </div>
        @endif
        <div class="preview-output border border-zinc-900/10 dark:border-white/10 rounded-lg p-4 mb-2">
            {!! $preview['output'] !!}
        </div>
    </div>
    @endforeach
    @else
    <p class="text-gray-500">No previews available for this component.</p>
    @endif
</div>