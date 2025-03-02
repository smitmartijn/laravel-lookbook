@props(['category', 'components', 'children', 'depth' => 0, 'currentPath'])

<div class="mb-2">
  @if($category !== 'root')
  <div style="margin-left: {{ $depth * 8 }}px; margin-right: 0px">
    <button @click="toggleCategory('{{ $category }}')"
      class="w-full text-left text-md font-medium mb-2 text-gray-900 dark:text-gray-100 flex items-center justify-between hover:bg-gray-200 dark:hover:bg-zinc-800 rounded px-2 py-1">
      <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="w-4 h-4 inline mr-1">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
        </svg>
        <span class="inline">{{ basename($category) }}</span>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-4 h-4 transition-transform duration-200"
        :class="collapsed['{{ $category }}'] ? '' : 'transform rotate-180'">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
      </svg>
    </button>
  </div>
  @endif

  <div class="space-y-1 transition-all duration-200" :class="{'hidden': collapsed['{{ $category }}']}"
    style="margin-left: {{ ($category !== 'root' ? $depth : 0) * 8 }}px">

    @foreach($components as $comp)
    <a href="{{ route('lookbook.show', $comp['path']) }}"
      class="block px-2 py-1 rounded-r-lg hover:bg-gray-200 dark:hover:bg-zinc-800 border-l-2 hover:border-l-[#d83f22]
                backdrop-blur-xs dark:backdrop-blur-sm transition-colors duration-200
                {{ $category !== 'root' ? 'ml-2' : '' }}
                {{ $comp['path'] === $currentPath ? 'text-zinc-600 dark:text-white bg-gray-200 dark:bg-zinc-800 border-l-[#d83f22]' : 'text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white border-l-transparent' }}">
      {{ $comp['name'] }}
    </a>
    @endforeach

    @foreach($children as $childCategory => $childData)
    <x-lookbook::navigation-tree :category="$childCategory" :components="$childData['components']"
      :children="$childData['children']" :depth="$childData['depth']" :currentPath="$currentPath" />
    @endforeach
  </div>
</div>