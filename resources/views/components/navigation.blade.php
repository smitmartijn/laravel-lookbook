<div class="component-navigation" x-data="{
    collapsed: JSON.parse(localStorage.getItem('lookbook_collapsed') || '{}'),
    toggleCategory(category) {
        this.collapsed[category] = !this.collapsed[category];
        localStorage.setItem('lookbook_collapsed', JSON.stringify(this.collapsed));
    }
}">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Components</h2>

    @if(empty($navigationTree))
    <p class="text-gray-500 dark:text-gray-400">No components found.</p>
    @else
    {{-- Root level components --}}
    @if($navigationTree['root']['components']->isNotEmpty())
    <x-lookbook::navigation-tree category="root" :components="$navigationTree['root']['components']"
        :children="$navigationTree['root']['children']" :depth="0" :currentPath="$currentPath" />
    @endif

    {{-- Categorized components --}}
    @foreach($navigationTree['children'] as $category => $node)
    <x-lookbook::navigation-tree :category="$category" :components="$node['components']" :children="$node['children']"
        :depth="$node['depth']" :currentPath="$currentPath" />
    @endforeach
    @endif
</div>