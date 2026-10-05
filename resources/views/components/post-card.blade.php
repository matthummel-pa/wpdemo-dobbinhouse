{{-- Journal card (.pcard): photo, category, title, excerpt, date and reading time. --}}
@props(['post' => [], 'heading' => 'h3', 'featured' => false])
<article @class(['pcard', 'pcard--feature' => $featured])>
  <a class="pcard-m" href="{!! esc_url($post['url']) !!}" tabindex="-1" aria-hidden="true">
    <x-media :image-id="$post['image_id']" kind="room" :ratio="$featured ? 'r-16x9' : 'r-4x3'" :size="$featured ? 'full' : 'large'" :eager="$featured" />
  </a>
  <div class="pcard-b">
    @if ($post['cats'])
      <p class="pcard-cats">
        @foreach ($post['cats'] as $cat)
          <a href="{!! esc_url($cat['url']) !!}">{{ $cat['name'] }}</a>
        @endforeach
      </p>
    @endif
    <{{ $heading }} class="{{ $featured ? 'h2' : 'h4' }} pcard-t"><a href="{!! esc_url($post['url']) !!}">{{ $post['title'] }}</a></{{ $heading }}>
    @if ($post['excerpt'] !== '')
      <p class="pcard-x">{{ $post['excerpt'] }}</p>
    @endif
    <p class="pcard-meta">
      <time datetime="{{ $post['iso'] }}">{{ $post['date'] }}</time>
      <span aria-hidden="true">·</span>
      <span>{{ sprintf(_n('%d min read', '%d min read', $post['minutes'], 'cobbleandcandle'), $post['minutes']) }}</span>
    </p>
  </div>
</article>
