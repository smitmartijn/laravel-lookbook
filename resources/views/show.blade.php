@extends('lookbook::layouts.app')
@section('content')

<div x-data="{
    isDragging: false,
    startY: null,
    startHeights: null,
    previewHeight: localStorage.getItem('previewHeight') || '50vh',
    sourceHeight: localStorage.getItem('sourceHeight') || '50vh',

    startDrag(e) {
        this.isDragging = true;
        this.startY = e.pageY;
        this.startHeights = {
            preview: this.$refs.previewPanel.offsetHeight,
            source: this.$refs.sourcePanel.offsetHeight
        };
    },

    drag(e) {
        if (!this.isDragging) return;

        const diff = e.pageY - this.startY;

        this.previewHeight = `${this.startHeights.preview + diff}px`;
        this.sourceHeight = `${this.startHeights.source - diff}px`;

        localStorage.setItem('previewHeight', this.previewHeight);
        localStorage.setItem('sourceHeight', this.sourceHeight);
    },

    stopDrag() {
        this.isDragging = false;
    }
}" class="flex flex-col h-[calc(100vh-4rem)]" @mousemove="drag" @mouseup="stopDrag" @mouseleave="stopDrag">

  <div x-ref="previewPanel" :style="`height: ${previewHeight}`" class="overflow-auto p-4">
    @include('lookbook::components.preview-panel')
  </div>

  <div @mousedown="startDrag" class="h-2
    bg-zinc-900/10 dark:bg-white/10
    hover:bg-zinc-900/20 dark:hover:bg-white/20
    cursor-row-resize flex items-center justify-center">
    <div class="w-8 h-1 bg-gray-400 dark:bg-gray-500 rounded-full"></div>
  </div>

  <div x-ref="sourcePanel" :style="`height: ${sourceHeight}`" class="overflow-auto p-4">
    @include('lookbook::components.source-panel')
  </div>

</div>

@endsection