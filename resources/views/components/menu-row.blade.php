{{-- Menu row (.mrow): optional dish photo, name……price with dotted leader, description, badges. --}}
@props(['item' => [], 'heading' => null])
@php
  $tag = $heading ?: 'span';
  $image_id = (int) ($item['image_id'] ?? 0);
  $image_alt = $image_id ? ((string) get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: (string) ($item['name'] ?? '')) : '';
@endphp
<li {{ $attributes->merge(['class' => 'mrow'.($image_id ? ' mrow--img' : '')]) }} data-diet="{{ implode(' ', $item['diet'] ?? []) }}">
  @if ($image_id)
    {!! wp_get_attachment_image($image_id, 'medium', false, ['class' => 'mrow-img', 'alt' => $image_alt, 'loading' => 'lazy', 'decoding' => 'async', 'sizes' => '112px']) !!}
  @endif
  <div class="mrow-body">
  <div class="mrow-top">
    <{{ $tag }} class="mrow-name">{{ $item['name'] }}</{{ $tag }}>
    @if (($item['flag'] ?? '') !== '')
      <span class="flag">{{ $item['flag'] }}</span>
    @endif
    <span class="leader" aria-hidden="true"></span>
    <x-price :item="$item" />
  </div>
  <div class="mrow-bot">
    @if (($item['desc'] ?? '') !== '')
      <p class="mrow-desc">{{ $item['desc'] }}</p>
    @endif
    <x-diet-badges :diet="$item['diet'] ?? []" />
  </div>
  </div>
</li>
