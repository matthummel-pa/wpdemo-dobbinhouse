<?php

/**
 * Menus, chef's picks, and events from the Cobble & Candle Core plugin. Empty without the plugin.
 */

namespace App;

/**
 * @return list<array<string, mixed>>
 */
function menus(): array
{
    return function_exists('cobble_get_menus') ? cobble_get_menus() : [];
}

/**
 * @return list<array<string, mixed>>
 */
function chef_picks(int $limit = 3): array
{
    return function_exists('cobble_chef_picks') ? cobble_chef_picks($limit) : [];
}

/**
 * @return list<array<string, mixed>>
 */
function upcoming_events(int $limit = 3): array
{
    return function_exists('cobble_upcoming_events') ? cobble_upcoming_events($limit) : [];
}

/**
 * First N items of a menu, across its sections in order.
 *
 * @param  array<string, mixed>  $menu  One entry from menus().
 * @return list<array<string, mixed>>
 */
function menu_preview(array $menu, int $limit = 5): array
{
    $items = [];
    foreach ($menu['sections'] ?? [] as $section) {
        foreach ($section['items'] as $item) {
            $items[] = $item;
        }
    }

    return array_slice($items, 0, $limit);
}

/**
 * Placeholder art for a dish without a photo, varied by position.
 */
function dish_art(int $index): string
{
    return ['dish-plate', 'dish-duck', 'dish-dessert', 'dish-pie', 'dish-board'][$index % 5];
}

/**
 * Split "a | b | c" lines (block textarea settings) into rows of exactly $columns trimmed strings.
 *
 * @return list<list<string>>
 */
function pipe_lines(string $text, int $columns): array
{
    $rows = [];
    foreach (preg_split('/\R/', $text) ?: [] as $line) {
        if (trim($line) === '') {
            continue;
        }
        $rows[] = array_pad(array_slice(array_map('trim', explode('|', $line, $columns)), 0, $columns), $columns, '');
    }

    return $rows;
}

/**
 * Rooms with a "from" price label for cards.
 *
 * @return list<array<string, mixed>>
 */
function rooms(int $limit = 50): array
{
    if (! function_exists('cobble_get_rooms')) {
        return [];
    }

    return array_map(fn (array $room): array => $room + [
        'from' => $room['price_night'] > 0 ? cobble_money(min(array_filter([$room['price_night'], $room['price_weekend']]))) : '',
    ], array_slice(cobble_get_rooms(), 0, $limit));
}

/**
 * One month of events laid out as calendar weeks for the Event Calendar block.
 * The month comes from `?cal=YYYY-MM`, else the current month in the site timezone.
 *
 * @return array{month: string, label: string, prev: string, next: string, prev_label: string, next_label: string, weekdays: list<array{short: string, long: string}>, weeks: list<list<array{date: string, day: int, in_month: bool, today: bool, events: list<array<string, mixed>>}>>, days: list<array{date: string, label: string, events: list<array<string, mixed>>}>, count: int}
 */
function event_calendar(): array
{
    $tz = wp_timezone();
    $requested = isset($_GET['cal']) ? sanitize_text_field(wp_unslash((string) $_GET['cal'])) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- public, read-only month switch.
    $first = preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $requested)
        ? \DateTimeImmutable::createFromFormat('!Y-m-d', $requested.'-01', $tz)
        : false;
    if (! $first) {
        $first = new \DateTimeImmutable('first day of this month midnight', $tz);
    }
    $last = $first->modify('last day of this month');

    $events = function_exists('cobble_events_between') ? cobble_events_between($first->format('Y-m-d'), $last->format('Y-m-d')) : [];
    $by_day = [];
    foreach ($events as $event) {
        $by_day[substr((string) $event['start'], 0, 10)][] = $event + [
            'time' => $event['iso'] !== '' ? wp_date((string) get_option('time_format'), strtotime($event['iso'])) : '',
        ];
    }

    $week_start = (int) get_option('start_of_week', 0);
    $lead = ((int) $first->format('w') - $week_start + 7) % 7;
    $cursor = $first->modify("-{$lead} days");
    $today = wp_date('Y-m-d');

    $weekdays = [];
    for ($i = 0; $i < 7; $i++) {
        $d = $cursor->modify("+{$i} days");
        $weekdays[] = ['short' => wp_date('D', $d->getTimestamp()), 'long' => wp_date('l', $d->getTimestamp())];
    }

    $weeks = [];
    while ($cursor <= $last) {
        $week = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $cursor->format('Y-m-d');
            $week[] = [
                'date' => $date,
                'day' => (int) $cursor->format('j'),
                'in_month' => $cursor->format('m') === $first->format('m'),
                'today' => $date === $today,
                'events' => $by_day[$date] ?? [],
            ];
            $cursor = $cursor->modify('+1 day');
        }
        $weeks[] = $week;
    }

    $days = [];
    foreach ($by_day as $date => $list) {
        $days[] = ['date' => $date, 'label' => wp_date('l j F', strtotime($date.' 12:00')), 'events' => $list];
    }

    $prev = $first->modify('-1 month');
    $next = $first->modify('+1 month');

    return [
        'month' => $first->format('Y-m'),
        'label' => wp_date('F Y', $first->getTimestamp()),
        'prev' => $prev->format('Y-m'),
        'next' => $next->format('Y-m'),
        'prev_label' => wp_date('F Y', $prev->getTimestamp()),
        'next_label' => wp_date('F Y', $next->getTimestamp()),
        'weekdays' => $weekdays,
        'weeks' => $weeks,
        'days' => $days,
        'count' => count($events),
    ];
}
