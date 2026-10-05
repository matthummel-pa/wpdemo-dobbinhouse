{{-- Journal: intro with topic cards, a featured story beside the latest posts, then cards and pagination for the posts page and post archives (main query). --}}
@php
  global $wp_query;
  $posts = array_map('App\\post_card', array_values(array_filter($wp_query->posts ?? [], fn ($p) => $p instanceof \WP_Post && $p->post_type === 'post')));
  $paged = max(1, (int) get_query_var('paged'));
  $isFront = is_home() && $paged === 1;
  $featured = ($attributes['showFeatured'] && $paged === 1 && ! is_category() && ! is_tag() && ! is_author() && $posts) ? array_shift($posts) : null;
  $latest = $featured ? array_splice($posts, 0, min(3, max(0, count($posts) - 2))) : [];
  $cats = get_categories(['hide_empty' => true, 'exclude' => [(int) get_option('default_category')]]);
  $current = is_category() ? (int) get_queried_object_id() : 0;
  $blog = (int) get_option('page_for_posts') ? (string) get_permalink((int) get_option('page_for_posts')) : home_url('/');
  $hid = wp_unique_id('jr-');
  $pages = paginate_links(['total' => (int) $wp_query->max_num_pages, 'current' => $paged, 'type' => 'array', 'prev_text' => __('Newer', 'cobbleandcandle'), 'next_text' => __('Older', 'cobbleandcandle')]);
  $showIntro = $attributes['showIntro'] && $isFront && $cats;
  $total = (int) wp_count_posts('post')->publish;
  $catName = fn (\WP_Term $c): string => wp_specialchars_decode($c->name, ENT_QUOTES);
@endphp
<div {!! $wrapper !!}>
  @if ($showIntro)
    <section class="section journal-intro" aria-labelledby="{{ $hid }}-i">
      <div class="container jr-intro">
        <div class="jr-intro-t">
          @if ($attributes['introEyebrow'] !== '')
            <p class="eyebrow">{{ $attributes['introEyebrow'] }}</p>
          @endif
          <h2 class="h2" id="{{ $hid }}-i">{{ $attributes['introTitle'] }}</h2>
          @if ($attributes['introText'] !== '')
            <p class="lede">{{ $attributes['introText'] }}</p>
          @endif
          <dl class="jr-stats">
            <div><dt>{{ __('Stories', 'cobbleandcandle') }}</dt><dd>{{ $total }}</dd></div>
            <div><dt>{{ __('Topics', 'cobbleandcandle') }}</dt><dd>{{ count($cats) }}</dd></div>
            @if (\App\brand('est'))
              <div><dt>{{ __('Since', 'cobbleandcandle') }}</dt><dd>{{ \App\brand('est') }}</dd></div>
            @endif
          </dl>
        </div>
        <nav class="jr-topics" aria-label="{{ __('Browse by topic', 'cobbleandcandle') }}">
          <ul role="list">
            @foreach ($cats as $cat)
              <li>
                <a class="jr-topic" href="{!! esc_url(get_category_link($cat)) !!}">
                  <span class="jr-topic-n">{{ $catName($cat) }}</span>
                  @if ($cat->description !== '')
                    <span class="jr-topic-d">{{ wp_strip_all_tags($cat->description) }}</span>
                  @endif
                  <span class="jr-topic-c">{{ sprintf(_n('%d story', '%d stories', $cat->count, 'cobbleandcandle'), $cat->count) }}<x-icon name="arrow" /></span>
                </a>
              </li>
            @endforeach
          </ul>
        </nav>
      </div>
    </section>
  @endif

  <section class="section journal" aria-labelledby="{{ $hid }}">
    <div class="container">
      <h2 class="sr" id="{{ $hid }}">{{ __('Stories', 'cobbleandcandle') }}</h2>
      @if (! $showIntro && count($cats) > 1)
        <nav class="fchips journal-cats" aria-label="{{ __('Categories', 'cobbleandcandle') }}">
          <a class="fchip-b" href="{!! esc_url($blog) !!}" @if (! $current && ! is_tag() && ! is_author()) aria-current="page" @endif>{{ $attributes['allLabel'] }}</a>
          @foreach ($cats as $cat)
            <a class="fchip-b" href="{!! esc_url(get_category_link($cat)) !!}" @if ($current === $cat->term_id) aria-current="page" @endif>{{ $catName($cat) }} <span class="count">{{ $cat->count }}</span></a>
          @endforeach
        </nav>
      @endif

      @if ($featured)
        <div @class(['jr-lead', 'jr-lead--solo' => ! $latest])>
          <x-post-card :post="$featured" featured heading="h3" />
          @if ($latest)
            <aside class="jr-latest" aria-labelledby="{{ $hid }}-l">
              <h3 class="eyebrow" id="{{ $hid }}-l">{{ $attributes['latestTitle'] }}</h3>
              <ol role="list">
                @foreach ($latest as $post)
                  <li><x-post-card :post="$post" compact heading="h4" /></li>
                @endforeach
              </ol>
            </aside>
          @endif
        </div>
      @endif

      @if ($posts)
        @if ($featured && $attributes['moreTitle'] !== '')
          <div class="jr-more-h"><h3 class="h3">{{ $attributes['moreTitle'] }}</h3></div>
        @endif
        <div class="journal-grid">
          @foreach ($posts as $post)
            <x-post-card :post="$post" :heading="$featured ? 'h4' : 'h3'" />
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
