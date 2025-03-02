@if(is_array($previews) && count($previews) > 0)
<div class="mb-4 p-4">
    <h2 class="text-2xl font-semibold mb-4 dark:text-white">Source</h2>
    @foreach($previews as $preview)
    <div class="mb-6">
        <h3 class="text-lg font-bold dark:text-gray-100">{{ $preview['metadata']['name'] ?? ucfirst(str_replace('_',
            ' ',
            $preview['method'])) }}</h3>
        <div class="relative">
            <button
                class="absolute top-2 right-2 px-2 py-1 text-xs text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 bg-gray-200 dark:bg-gray-600 rounded shadow transition-colors duration-200"
                onclick="copyToClipboard(this, 'pre-{{ $preview['method'] }}')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>

            </button>
            <pre id="pre-{{ $preview['method'] }}"
                class="bg-gray-200 dark:bg-zinc-800 dark:text-gray-300 p-4 rounded mt-2 overflow-x-auto text-sm"><code class="language-blade">{{ $preview['source'] }}</code></pre>
        </div>
    </div>
    @endforeach
</div>

<script>
    function copyToClipboard(button, preId) {
    const text = document.getElementById(preId).innerText;
    const originalText = button.innerHTML;
    navigator.clipboard.writeText(text).then(() => {
      button.textContent = 'Copied!';
      button.classList.add('bg-green-200', 'dark:bg-green-700', 'text-green-800', 'dark:text-green-200');

      setTimeout(() => {
        button.innerHTML = originalText;
        button.classList.remove('bg-green-200', 'dark:bg-green-700', 'text-green-800', 'dark:text-green-200');
      }, 2000);
    }).catch(err => {
      console.error('Failed to copy text: ', err);
      button.textContent = 'Failed to copy';
      button.classList.add('bg-red-200', 'dark:bg-red-700', 'text-red-800', 'dark:text-red-200');

      setTimeout(() => {
        button.innerHTML = originalText;
        button.classList.remove('bg-red-200', 'dark:bg-red-700', 'text-red-800', 'dark:text-red-200');
      }, 2000);
    });
  }
</script>
@endif