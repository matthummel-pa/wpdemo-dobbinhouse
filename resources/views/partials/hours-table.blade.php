{{-- Weekly and upcoming holiday hours for one location or venue. $place is a cobble_location() array. --}}
@php($holidays = \App\holiday_rows($place['id']))
<div class="lcols">
  <div>
    <h3 class="h4">{{ $title ?? __('Opening hours', 'cobbleandcandle') }}</h3>
    <table class="week">
      <caption class="sr">{{ sprintf(__('Weekly hours at %s', 'cobbleandcandle'), $place['name']) }}</caption>
      <tbody>
        @foreach (\App\week_rows($place['id']) as [$day, $hours, $today])
          <tr @class(['is-today' => $today])><th scope="row">{{ $day }}@if ($today)<span class="today-tag">{{ __('Today', 'cobbleandcandle') }}</span>@endif</th><td>{{ $hours }}</td></tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @if ($holidays)
    <div>
      <h3 class="h4">{{ __('Holiday hours', 'cobbleandcandle') }}</h3>
      <ul class="holiday">
        @foreach ($holidays as [$label, $date, $hours])
          <li><span class="hol-d">{{ $date }}</span><span class="hol-n">{{ $label }}</span><span class="hol-h">{{ $hours }}</span></li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
