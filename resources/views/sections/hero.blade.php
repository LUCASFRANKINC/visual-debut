@php
  $heightMap = [
      'small' => '300px',
      'medium' => '400px',
      'large' => '500px',
  ];

  $contentPositionMap = [
      'top' => 'items-start',
      'middle' => 'items-center',
      'bottom' => 'items-end',
  ];
@endphp

<div class="hero-container relative" style="height: {{ $heightMap[$section->settings->height] }}">
  <div class="absolute inset-0 flex h-full w-full">
    @if ($section->settings->image)
      <img
        src="{{ $section->settings->image }}"
        alt="Summer collection background"
        class="h-full w-full object-cover"
      />
    @endif
  </div>

  @if ($section->settings->show_overlay)
    <div class="absolute inset-0 h-full w-full bg-black" style="opacity: {{ $section->settings->overlay_opacity }}%">
    </div>
  @endif

  <div class="z-5 {{ $contentPositionMap[$section->settings->content_position] }} relative flex h-full justify-center py-6">
    <div class="text-on-background relative max-w-2xl px-8 py-8">

      @foreach ($section->blocks as $block)
        @if ($block->type === 'heading')
          <h1 class="heading text-center text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
            {{ $block->settings->heading }}
          </h1>
        @elseif($block->type === 'subheading')
          <p class="subheading text-on-background mx-auto mt-6 text-center text-xl">
            {{ $block->settings->subheading }}
          </p>
        @elseif($block->type === 'button')
          <div class="mt-6 space-x-4 text-center">
            <a href="{{ $block->settings->button_link }}"
              class="bg-primary-50 hover:bg-primary-100 text-primary-600 inline-block rounded-lg border border-transparent px-8 py-3 text-base font-medium transition-colors duration-200"
            >
              {{ $block->settings->text }}
            </a>
          </div>
        @endif
      @endforeach
    </div>
  </div>
</div>

@if (ThemeEditor::inDesignMode())
  @pushOnce('scripts')
    <script>
      document.addEventListener('visual:editor:init', () => {
        const heightMap = {
          'small': '300px',
          'medium': '400px',
          'large': '500px'
        };

        window.Visual.handleLiveUpdate('{{ $section->type }}', {
          section: {
            height: {
              target: '.hero-container',
              style: 'height',
              transform: v => heightMap[v]
            }
          },
          blocks: {
            heading: {
              heading: {
                target: '.heading',
                text: true
              }
            },
            subheading: {
              subheading: {
                target: '.subheading',
                text: true
              }
            }
          }
        });
      })
    </script>
  @endPushOnce
@endif
