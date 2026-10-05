{{-- Site Footer block (compact): brand, footer menu and social links on one row; a one-line card per location; then about, copyright and legal links. --}}
@php
  $about = $attributes['about'] ?: get_bloginfo('description');
  // Profiles from Settings → Restaurant, with this block's own fields (sanitized) as a fallback.
  $extra = array_filter(['instagram' => esc_url_raw($attributes['instagram']), 'facebook' => esc_url_raw($attributes['facebook'])]);
  if ($attributes['email'] !== '' && is_email($attributes['email'])) {
      $extra['mail'] = 'mailto:'.sanitize_email($attributes['email']);
  }
  $footerSocialLinks = \App\social_links($extra);
  $locs = \App\locations();
@endphp
<footer {!! $wrapper !!}>
  <div class="ftr">
    <div class="container">
      <div class="f-top">
        @include('partials.brand')
        @if (has_nav_menu('footer_navigation'))
          <nav class="f-nav" aria-label="{{ __('Footer', 'cobbleandcandle') }}">{!! \App\menu('footer_navigation') !!}</nav>
        @endif
        @if ($footerSocialLinks !== '')
          <div class="social" role="group" aria-label="{{ __('Follow us', 'cobbleandcandle') }}">{!! $footerSocialLinks !!}</div>
        @endif
      </div>

      @if ($locs)
        <h2 class="sr">{{ __('Our locations', 'cobbleandcandle') }}</h2>
        <ul class="f-locs" role="list">
          @foreach ($locs as $l)
            <li class="f-loc">
              <h3 class="f-loc-n"><a href="{!! esc_url($l['url']) !!}">{{ $l['name'] }}</a></h3>
              <x-status :status="$l['status']" :of="$l['slug']" size="sm" />
              @if ($l['street'] !== '')
                <a class="f-loc-i" href="{!! esc_url($l['map_url']) !!}"><x-icon name="pin" />{{ $l['street'] }}@if ($l['locality'] !== ''), {{ $l['locality'] }}@endif</a>
              @endif
              @if ($l['phone'] !== '')
                <a class="f-loc-i" href="{!! esc_url($l['tel']) !!}"><x-icon name="phone" />{{ $l['phone'] }}</a>
              @endif
              <a class="f-loc-more" href="{!! esc_url($l['url']) !!}">{{ __('Hours and directions', 'cobbleandcandle') }} <span aria-hidden="true">→</span></a>
            </li>
          @endforeach
        </ul>
      @endif

      <div class="f-bottom">
        <p>&copy; {{ wp_date('Y') }} {{ \App\site_name() }}@if ($about)<span class="f-about"> · {{ $about }}</span>@endif</p>
        @if (has_nav_menu('legal_navigation'))
          <nav aria-label="{{ __('Legal', 'cobbleandcandle') }}">{!! \App\menu('legal_navigation') !!}</nav>
        @endif
      </div>
    </div>
  </div>
</footer>
