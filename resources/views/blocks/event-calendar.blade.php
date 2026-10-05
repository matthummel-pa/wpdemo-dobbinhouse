{{-- Event Calendar: month grid on wide screens, day-by-day agenda on phones. Month from ?cal=YYYY-MM. --}}
@php
  $cal = \App\event_calendar();
  $hid = wp_unique_id('cal-');
  $link = fn (string $month): string => add_query_arg('cal', $month, remove_query_arg('cal')).'#'.$hid;
@endphp
<section {!! $wrapper !!} aria-labelledby="{{ $hid }}-h">
  <div class="section">
    <div class="container">
      <x-section-head :eyebrow="$attributes['eyebrow']" :title="$attributes['title']" :intro="$attributes['intro']" :id="$hid.'-h'" />
      <div class="evcal" id="{{ $hid }}">
        <nav class="evcal-nav" aria-label="{{ __('Choose a month', 'cobbleandcandle') }}">
          <a class="btn btn--secondary btn--sm" href="{!! esc_url($link($cal['prev'])) !!}" rel="nofollow"><x-icon name="chev-left" /><span>{{ $cal['prev_label'] }}</span></a>
          <p class="evcal-month h3" aria-live="polite">{{ $cal['label'] }}</p>
          <a class="btn btn--secondary btn--sm" href="{!! esc_url($link($cal['next'])) !!}" rel="nofollow"><span>{{ $cal['next_label'] }}</span><x-icon name="chev-right" /></a>
        </nav>

        <table class="evcal-grid">
          <caption class="sr">{{ sprintf(__('Events in %s', 'cobbleandcandle'), $cal['label']) }}</caption>
          <thead>
            <tr>
              @foreach ($cal['weekdays'] as $wd)
                <th scope="col"><abbr title="{{ $wd['long'] }}">{{ $wd['short'] }}</abbr></th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach ($cal['weeks'] as $week)
              <tr>
                @foreach ($week as $day)
                  <td class="evcal-day{{ $day['in_month'] ? '' : ' is-out' }}{{ $day['today'] ? ' is-today' : '' }}{{ $day['events'] ? ' has-ev' : '' }}">
                    <span class="evcal-num"@if ($day['today']) aria-current="date"@endif>{{ $day['day'] }}</span>
                    @foreach ($day['events'] as $event)
                      <a class="evcal-ev" href="{!! esc_url($event['url']) !!}">
                        @if ($event['time'] !== '')<time datetime="{{ $event['iso'] }}">{{ $event['time'] }}</time>@endif
                        <span>{{ $event['title'] }}</span>
                      </a>
                    @endforeach
                  </td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="evcal-agenda">
          @forelse ($cal['days'] as $day)
            <h3 class="evcal-date h4">{{ $day['label'] }}</h3>
            <ul class="evcal-list">
              @foreach ($day['events'] as $event)
                <li><a href="{!! esc_url($event['url']) !!}">@if ($event['time'] !== '')<time datetime="{{ $event['iso'] }}">{{ $event['time'] }}</time> · @endif{{ $event['title'] }}</a></li>
              @endforeach
            </ul>
          @empty
          @endforelse
        </div>

        @if ($cal['count'] === 0)
          <p class="empty"><x-icon name="calendar" /> {{ $attributes['emptyText'] }}</p>
        @endif
      </div>
    </div>
  </div>
</section>
