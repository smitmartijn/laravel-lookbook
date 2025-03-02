@extends('lookbook::layouts.app')
@section('content')
<div class="mb-4 p-4">
    <h2 class="text-xl font-semibold mb-4 dark:text-white">No Components Found</h2>
    <div class="text-gray-500 dark:text-gray-400">
        <p class="my-2">No component previews have been created yet. Go create some!</p>
        <code class="my-6 italic text-sm">php artisan make:lookbook-component ComponentName</code>
    </div>
</div>
@endsection