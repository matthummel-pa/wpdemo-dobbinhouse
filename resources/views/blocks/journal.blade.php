{{-- Journal: category chips, featured story, cards and pagination for the posts page and post archives (main query). --}}
@php
  global $wp_query;
  $posts = array_map('App\\post_card', array_values(array_filter($wp_query->posts ?? [], fn ($p) => $p instanceof \WP_Post && $p->post_type === 'post')));
  $paged = max(1, (int) get_query_var('paged'));
  $featured = ($attributes['showFeatured'] && $paged === 1 && ! is_category() && ! is_tag() && ! is_author() && $posts) ? array_shift($posts) : null;
  $cats = get_categories(['hide_empty' => true, 'exclude' => [(int) get_option('default_category')]]);
  $current = is_category() ? (int) get_queried_object_id() : 0;
  $blog = (int) get_option('page_for_posts') ? (string) get_permalink((int) get_option('page_for_posts')) : home_url('/');
  $hid = wp_unique_id('jr-');
  $pages = paginate_links(['total' => (int) $wp_query->max_num_pages, 'current' => $paged, 'type' => 'array', 'prev_text' => __('Newer', 'cobbleandcandle'), 'next_text' => __('Older', 'cobbleandcandle')]);
@endphp
<div {!! $wrapper !!}>
  <section class="section journal" aria-labelledby="{{ $hid }}">
    <div class="container">
      <h2 class="sr" id="{{ $hid }}">{{ __('Stories', 'cobbleandcandle') }}</h2>
      @if (count($cats) > 1)
        <nav class="fchips journal-cats" aria-label="{{ __('Categories', 'cobbleandcandle') }}">
          <a class="fchip-b" href="{!! esc_url($blog) !!}" @if (! $current && ! is_tag() && ! is_author()) aria-current="page" @endif>{{ $attributes['allLabel'] }}</a>
          @foreach ($cats as $cat)
            <a class="fchip-b" href="{!! esc_url(get_category_link($cat)) !!}" @if ($current === $cat->term_id) aria-current="page" @endif>{{ $cat->name }} <span class="count">{{ $cat->count }}</span></a>
          @endforeach
        </nav>
      @endif

      @if ($featured)
        <x-post-card :post="$featured" featured heading="h2" />
      @endif

      @if ($posts)
        <div class="grid-3 journal-grid">
          @foreach ($posts as $post)
            <x-post-card :post="$post" :heading="$featured ? 'h3' : 'h2'" />
          @endforeach
        </div>
      @elseif (! $featured)
        <p class="empty"><x-icon name="info" /> {{ $attributes['emptyText'] }}</p>
      @endif

      @if ($pages)
        <nav class="journal-pages" aria-label="{{ __('More stories', 'cobbleandcandle') }}">
          @foreach ($pages as $link)
            {!! wp_kses_post($link) !!}
          @endforeach
        </nav>
      @endif
    </div>
  </section>
</div>
