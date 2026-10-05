{{-- One location's details (.lpanel): map or photo with directions, address, contact, weekly and
     holiday hours, getting there, and actions. $l is a cobble_location() array; $pin its map index. --}}
@php
  $notes = array_filter([
      ['car', __('Parking', 'cobbleandcandle'), (string) get_post_meta($l['id'], 'cobble_parking', true)],
      ['train', __('Transit', 'cobbleandcandle'), (string) get_post_meta($l['id'], 'cobble_transit', true)],
      ['access', __('Access', 'cobbleandcandle'), (string) get_post_meta($l['id'], 'cobble_accessibility', true)],
  ], fn ($n) => $n[2] !== '');
  $photo = (int) get_post_thumbnail_id($l['id']);
  $uid = wp_unique_id('map');
@endphp
<div class="lmap card">
  @if ($photo)
    <x-media :image-id="$photo" ratio="r-4x3" />
  @else
    @include('art.map', ['uid' => $uid, 'pin' => $pin ?? -1, 'names' => array_column(\App\locations(), 'name')])
  @endif
  @if ($l['map_url'] !== '')
    <a class="btn btn--primary lmap-btn" href="{!! esc_url($l['map_url']) !!}"><x-icon name="nav" /><span>{{ __('Get directions', 'cobbleandcandle') }}</span></a>
  @endif
</div>
<div class="ldetail">
  <{{ $heading ?? 'h2' }} class="h2">{{ $l['name'] }}</{{ $heading ?? 'h2' }}>
  <x-status :status="$l['status']" :of="$l['slug']" />
  @if ($l['address'] !== '')
    <address class="laddr"><x-icon name="pin" /><span>{{ $l['address'] }}</span></address>
  @endif
  <p class="lcontact">
    @if ($l['phone'] !== '')
      <a href="{!! esc_url($l['tel']) !!}"><x-icon name="phone" />{{ $l['phone'] }}</a>
    @endif
    @if ($l['email'] !== '')
      <a href="mailto:{{ $l['email'] }}"><x-icon name="mail" />{{ $l['email'] }}</a>
    @endif
  </p>
  @php($venues = \App\venues($l['id']))
  @if ($venues)
    @php($vid = wp_unique_id('venue-'))
    <div class="venues" x-data="tabs">
      <h3 class="h4" id="{{ $vid }}-h">{{ __('Hours by venue', 'cobbleandcandle') }}</h3>
      <div class="tabs" role="tablist" aria-labelledby="{{ $vid }}-h" @keydown="keys($event)">
        @foreach (array_merge([$l], $venues) as $i => $place)
          <button type="button" role="tab" class="tab" id="{{ $vid }}-t{{ $i }}" aria-controls="{{ $vid }}-p{{ $i }}"
                  aria-selected="{{ $i === 0 ? 'true' : 'false' }}" tabindex="{{ $i === 0 ? 0 : -1 }}"
                  :aria-selected="(active === {{ $i }}).toString()" :tabindex="active === {{ $i }} ? 0 : -1" @click="select({{ $i }})">{{ $place['name'] }}</button>
        @endforeach
      </div>
      @foreach (array_merge([$l], $venues) as $i => $place)
        <div role="tabpanel" class="tabpanel venue-panel" id="{{ $vid }}-p{{ $i }}" aria-labelledby="{{ $vid }}-t{{ $i }}" tabindex="0" @if ($i > 0) hidden @endif :hidden="active !== {{ $i }}">
          @if ($i > 0)
            <x-status :status="$place['status']" :of="$place['slug']" />
            @php($excerpt = (string) get_post_field('post_excerpt', $place['id']))
            @if ($excerpt !== '')
              <p class="venue-note">{{ $excerpt }}</p>
            @endif
          @endif
          @include('partials.hours-table', ['place' => $place])
        </div>
      @endforeach
    </div>
  @else
    @include('partials.hours-table', ['place' => $l])
  @endif
  @if ($notes)
    <ul class="notes">
      @foreach ($notes as [$icon, $label, $text])
        <li><x-icon :name="$icon" /><div><b>{{ $label }}</b><p>{{ $text }}</p></div></li>
      @endforeach
    </ul>
  @endif
  <div class="cta-row">
    @if (($reserveUrl ?? '') !== '')
      <x-button :href="add_query_arg('loc', $l['slug'], $reserveUrl)" icon="calendar">{{ $reserveLabel ?? __('Reserve a table', 'cobbleandcandle') }}</x-button>
    @endif
    @if (($detailsUrl ?? '') !== '')
      <x-button :href="$detailsUrl" variant="secondary">{{ __('About this house', 'cobbleandcandle') }}</x-button>
    @endif
    @if ($l['tel'] !== '')
      <x-button :href="$l['tel']" variant="text" icon="phone">{{ __('Call', 'cobbleandcandle') }}</x-button>
    @endif
  </div>
</div>
