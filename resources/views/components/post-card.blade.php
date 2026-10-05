{{-- Journal card (.pcard): photo, category, title, excerpt, date and reading time. `featured` = large lead card; `compact` = small row with a thumbnail. --}}
@props(['post' => [], 'heading' => 'h3', 'featured' => false, 'compact' => false])
<article @class(['pcard', 'pcard--feature' => $featured, 'pcard--compact' => $compact])>
  <a class="pcard-m" href="{!! esc_url($post['url']) !!}" tabindex="-1" aria-hidden="true">
    <x-media :image-id="$post['image_id']" kind="room" :ratio="$featured ? 'r-16x9' : ($compact ? 'r-1x1' : 'r-4x3')" :size="$featured ? 'full' : ($compact ? 'medium' : 'large')" :eager="$featured" />
  </a>
  <div class="pcard-b">
    @if ($post['cats'])
      <p class="pcard-cats">
        @foreach ($compact ? array_slice($post['cats'], 0, 1) : $post['cats'] as $cat)
          <a href="{!! esc_url($cat['url']) !!}">{{ $cat['name'] }}</a>
        @endforeach
      </p>
    @endif
    <{{ $heading }} class="{{ $featured ? 'h2' : ($compact ? 'h5' : 'h4') }} pcard-t"><a href="{!! esc_url($post['url']) !!}">{{ $post['title'] }}</a></{{ $heading }}>
    @if ($post['excerpt'] !== '' && ! $compact)
      <p class="pcard-x">{{ $post['excerpt'] }}</p>
    @endif
    <p class="pcard-meta">
      <time datetime="{{ $post['iso'] }}">{{ $post['date'] }}</time>
      <span aria-hidden="true">·</span>
      <span>{{ sprintf(_n('%d min read', '%d min read', $post['minutes'], 'cobbleandcandle'), $post['minutes']) }}</span>
      @if ($featured && $post['author'] !== '')
        <span aria-hidden="true">·</span>
        <span>{{ sprintf(__('By %s', 'cobbleandcandle'), $post['author']) }}</span>
      @endif
    </p>
  </div>
</article>
