{{-- Post Footer: share links, author card, related stories. --}}
@php
  $post = \App\context_post();
@endphp
@if ($post && $post->post_type === 'post')
  @php
    $url = (string) get_permalink($post);
    $title = wp_strip_all_tags(get_the_title($post));
    $author = (int) $post->post_author;
    $bio = (string) get_the_author_meta('description', $author);
    $related = \App\related_posts($post, (int) $attributes['count']);
    $share = [
        ['Facebook', 'https://www.facebook.com/sharer/sharer.php?u='.rawurlencode($url)],
        ['X', 'https://twitter.com/intent/tweet?url='.rawurlencode($url).'&text='.rawurlencode($title)],
        [__('Email', 'cobbleandcandle'), 'mailto:?subject='.rawurlencode($title).'&body='.rawurlencode($url)],
    ];
    $hid = wp_unique_id('rel-');
  @endphp
  <div {!! $wrapper !!}>
    <div class="container post-foot">
      <div class="share" x-data="{ copied: false }">
        <p class="share-l">{{ __('Share this story', 'cobbleandcandle') }}</p>
        <ul class="share-list">
          @foreach ($share as [$label, $href])
            <li><a class="btn btn--secondary btn--sm" href="{!! esc_url($href) !!}" @if (! str_starts_with($href, 'mailto:')) target="_blank" rel="noopener" @endif>{{ $label }}@if (! str_starts_with($href, 'mailto:'))<span class="sr"> {{ __('(opens in a new tab)', 'cobbleandcandle') }}</span>@endif</a></li>
          @endforeach
          <li><button type="button" class="btn btn--secondary btn--sm" @click="navigator.clipboard?.writeText(@js($url)); copied = true; setTimeout(() => copied = false, 2000)"><span x-text="copied ? @js(__('Link copied', 'cobbleandcandle')) : @js(__('Copy link', 'cobbleandcandle'))">{{ __('Copy link', 'cobbleandcandle') }}</span></button></li>
        </ul>
      </div>

      <aside class="author-card card" aria-label="{{ __('About the author', 'cobbleandcandle') }}">
        {!! wp_kses_post(get_avatar($author, 96, '', '', ['class' => 'author-av'])) !!}
        <div>
          <p class="eyebrow">{{ __('Written by', 'cobbleandcandle') }}</p>
          <p class="h4 author-n"><a href="{!! esc_url(get_author_posts_url($author)) !!}">{{ get_the_author_meta('display_name', $author) }}</a></p>
          @if ($bio !== '')
            <p class="author-bio">{{ $bio }}</p>
          @endif
        </div>
      </aside>
    </div>
    @if ($related)
      <section class="section section--alt" aria-labelledby="{{ $hid }}">
        <div class="container">
          <x-section-head :title="$attributes['relatedTitle']" :id="$hid" />
          <div class="grid-3">
            @foreach ($related as $r)
              <x-post-card :post="$r" />
            @endforeach
          </div>
        </div>
      </section>
    @endif
  </div>
@endif
